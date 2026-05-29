export class MainScene extends Phaser.Scene {
    constructor(){
        super({ key: 'MainScene' });
            this.state = 'READY'; // READY, SHOOTING, WAITING, GAMEOVER
            this.score = 0;
            this.shots = 4;
            this.invoiceId = null; // Asignar el ID del usuario antes de enviar
    }

    create() {
        // Capturar el valor del input hidden invoice_id
        this.invoiceId = document.getElementById('invoice_id').value;

        // 1. Crear texturas procedurales (Cancha, Portería, Arquero, Balón)
        this.generateTextures();

        // 2. Fondo con imagen bg
        const bg = this.add.image(360, 640, 'bg');
        bg.setDisplaySize(720, 1280);

        // Logos arriba de la cancha
        this.add.image(210, 200, 'logo1').setScale(0.2);
        this.add.image(510, 200, 'logo2').setScale(0.2);

        // 3. Añadir elementos del juego
        this.goal = this.add.image(360, 500, 'goal').setAlpha(0);
        this.goalie = this.physics.add.sprite(330, 580, 'fly');
        this.goalie.setScale(0.3);

        // Animación del arquero (mosca)
        this.anims.create({
            key: 'fly_anim',
            frames: this.anims.generateFrameNumbers('fly', { start: 0, end: 4 }),
            frameRate: 30,
            repeat: -1
        });
        this.anims.create({
            key: 'cry_anim',
            frames: this.anims.generateFrameNumbers('cry', { start: 0, end: 4 }),
            frameRate: 8,
            repeat: -1
        });
        this.goalie.play('fly_anim');
        this.ball = this.physics.add.sprite(360, 1100, 'ball').setScale(.5);

        // Configurar físicas y movimiento del arquero
        this.goalie.setVelocityX(400);

        // 6. Sonidos
        this.bgMusic = this.sound.add('bg', { loop: true, volume: 0.3 });
        this.bgMusic.play();
        this.soundKick = this.sound.add('kick', { volume: 0.8 });
        this.soundGoal = this.sound.add('goal', { volume: 1 });

        // 4. Interfaz de usuario (Textos)
        this.scoreText = this.add.text(18, 16, 'Goles: 0', { fontSize: '64px', fill: '#fff', fontStyle: 'bold', fontFamily: 'font1' }).setShadow(2, 2, '#000', 2);
        this.shotsText = this.add.text(565, 16, 'Tiros: 4', { fontSize: '64px', fill: '#fff', fontStyle: 'bold', fontFamily: 'font1' }).setShadow(2, 2, '#000', 2);
        this.msgText = this.add.text(360, 750, '¡DESLIZA PARA PATEAR!', { fontSize: '52px', fill: '#ffeb3b', fontStyle: 'bold', fontFamily: 'font1' }).setOrigin(0.5).setShadow(3, 3, '#000', 4);

        // 5. Controles Táctiles (Swipe)
        this.input.on('pointerdown', (pointer) => {
            if (this.state === 'READY') {
                this.swipeY = pointer.y;
                this.swipeX = pointer.x;
            }
        });

        this.input.on('pointerup', (pointer) => {
            if (this.state === 'READY') {
                let dx = pointer.x - this.swipeX;
                let dy = pointer.y - this.swipeY;

                // Solo registrar el tiro si se desliza el dedo hacia arriba significativamente
                if (dy < -40) {
                    this.shoot(dx, dy);
                }
            }
        });
    }

    shoot(dx, dy) {
        this.state = 'SHOOTING';
        this.msgText.setText('');
        this.soundKick.play();

        // Calcular velocidad basada en la fuerza del swipe
        let velocityY = Math.max(dy * 3, -1000);
        let velocityX = dx * 3;

        this.ball.setVelocity(velocityX, velocityY);
    }

    update() {
        // Lógica de rebote del arquero
        if (this.goalie.x > 570) {
            this.goalie.setVelocityX(-Phaser.Math.Between(350, 600));
        } else if (this.goalie.x < 150) {
            this.goalie.setVelocityX(Phaser.Math.Between(350, 600));
        }

        if (this.state === 'SHOOTING') {
            // Rotar el balón mientras se mueve
            this.ball.rotation += 0.2;

            // Efecto de perspectiva (hacer el balón más pequeño mientras se aleja)
            let scale = 0.15 + 0.5 * ((this.ball.y - 620) / (1100 - 620));
            this.ball.setScale(Math.max(0.3, scale));

            // Comprobar si el balón ha cruzado la línea de gol (Y = 620) o salió por los lados
            if (this.ball.y <= 620 || this.ball.x < -20 || this.ball.x > 740) {
                this.evaluateShot();
            }
        }
    }

    evaluateShot() {
        this.ball.setVelocity(0, 0);
        this.state = 'WAITING';

        // Lógica de colisiones y resultados
        let isTrapped = Math.abs(this.ball.x - this.goalie.x) < 85 && this.ball.y <= 620 && this.ball.y > 400;
        let isPost = !isTrapped && this.ball.y <= 620 && (this.ball.x >= 20 && this.ball.x <= 35 || this.ball.x >= 685 && this.ball.x <= 700);
        let isGoal = !isTrapped && !isPost && (this.ball.x > 20 && this.ball.x < 700) && this.ball.y <= 620;

        if (isTrapped) {
            // Mostrar catch al instante y detener arquero
            this.ball.setVisible(false);
            this.goalie.setVelocity(0, 0);
            this.goalie.stop();
            this.goalie.setTexture('catch');
            this.showResult('¡ATRAPADA!', false);
        } else if (isPost) {
            // Balón en el palo
            this.tweens.add({
                targets: this.ball,
                y: 380, scale: 0.25, duration: 300, ease: 'Bounce.easeOut',
                onComplete: () => this.showResult('¡AL PALO!', false)
            });
        } else if (isGoal) {
            // Animación de gol (choca con la red)
            this.soundGoal.play();
            this.cameras.main.shake(400, 0.018);
            this.spawnConfetti();
            this.tweens.add({
                targets: this.ball,
                y: 480, scale: 0.3, duration: 250, ease: 'Quad.easeOut',
                onComplete: () => this.showResult('¡GOOOOL!', true)
            });
        } else {
            // Animación de balón fuera
            this.tweens.add({
                targets: this.ball,
                y: 330, scale: 0.2, duration: 350,
                onComplete: () => this.showResult('¡AFUERA!', false)
            });
        }
    }

    showResult(message, isGoal) {
        this.msgText.setText(message);
        this.shots--;

        if (isGoal) {
            this.score++;
            this.msgText.setColor('#4caf50'); // Verde
        } else {
            this.msgText.setColor('#f44336'); // Rojo
        }

        this.scoreText.setText('Goles: ' + this.score);
        this.shotsText.setText('Tiros: ' + this.shots);

        // Esperar 1.5 segundos antes de reiniciar el tiro
        this.time.delayedCall(1500, () => {
            this.resetTurn();
        });
    }

    resetTurn() {
        if (this.shots <= 0) {
            this.state = 'GAMEOVER';
            this.msgText.setText('¡JUEGO TERMINADO!\n');
            this.msgText.setColor('#ffeb3b');
            this.goalie.setVelocity(0, 0);
            this.goalie.play('cry_anim');
            this.sendResult();
            return;
        }

        this.msgText.setText('');
        this.goalie.setVelocityX(Phaser.Math.Between(350, 600));
        this.goalie.play('fly_anim');
        this.ball.setVisible(true);
        this.ball.setPosition(360, 1100);
        this.ball.setScale(.5);
        this.ball.rotation = 0;
        this.state = 'READY';
    }

    spawnConfetti() {
        const colors = [0xff2222, 0x22cc22, 0xffee00, 0xff44ff, 0x00ccff, 0xff8800, 0xffffff];
        for (let i = 0; i < 70; i++) {
            const x = Phaser.Math.Between(40, 680);
            const color = Phaser.Utils.Array.GetRandom(colors);
            const w = Phaser.Math.Between(8, 16);
            const h = Phaser.Math.Between(10, 18);
            const rect = this.add.rectangle(x, Phaser.Math.Between(250, 450), w, h, color);
            rect.setDepth(20);
            this.tweens.add({
                targets: rect,
                y: rect.y + Phaser.Math.Between(350, 650),
                x: rect.x + Phaser.Math.Between(-120, 120),
                angle: Phaser.Math.Between(180, 720),
                alpha: 0,
                duration: Phaser.Math.Between(900, 1800),
                ease: 'Quad.easeIn',
                onComplete: () => rect.destroy()
            });
        }
    }

    sendResult() {
        const payload = {
            invoice_id: this.invoiceId,
            score: this.score
        };

        fetch(window.gameRoutes.score, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            const data = await res.json();

            if (! res.ok) {
                Swal.fire({
                    icon: 'error',
                    title: '¡Oops!',
                    text: 'Error al guardar el puntaje.',
                    cancelButtonText: 'Cerrar',
                    allowOutsideClick: false
                });
            }

            return data;
        })
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: '¡Listo!',
                text: data.message,
                confirmButtonText: 'Aceptar',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = window.gameRoutes.ranking;
            });
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: '¡Oops!',
                text: 'Error al guardar el puntaje.',
                cancelButtonText: 'Cerrar',
                allowOutsideClick: false
            });

            console.error('Error al enviar resultado:', err);
        });
    }

    // Función para dibujar los gráficos sin usar imágenes externas
    generateTextures() {
        // Portería (680×300 para canvas 720px)
        let gg = this.make.graphics();
        gg.lineStyle(8, 0xffffff);
        gg.strokeRect(3, 3, 674, 294);
        gg.lineStyle(2, 0xaaaaaa); // Red
        for (let i = 20; i < 674; i += 20) { gg.moveTo(i, 3); gg.lineTo(i, 297); }
        for (let i = 20; i < 294; i += 20) { gg.moveTo(3, i); gg.lineTo(677, i); }
        gg.strokePath();
        gg.generateTexture('goal', 680, 300);

        // Arquero - reemplazado por spritesheet 'fly'

        // Balón
        let gb = this.make.graphics();
        gb.fillStyle(0xffffff); gb.fillCircle(20, 20, 18);
        gb.fillStyle(0x000000);
        gb.fillCircle(20, 20, 6);
        gb.fillCircle(8, 12, 4);
        gb.fillCircle(32, 12, 4);
        gb.fillCircle(12, 32, 4);
        gb.fillCircle(28, 32, 4);
        gb.lineStyle(2, 0x000000);
        gb.strokeCircle(20, 20, 19);
        gb.generateTexture('ball', 40, 40);
}

    getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }

    gameOver(){
        mContext.scene.start('GameOverScene', {score: scoreCounter});
    }
}
