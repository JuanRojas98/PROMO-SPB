let width, height;

export class MenuScene extends Phaser.Scene {
    constructor(){
        super('MenuScene');
    }  

    preload(){
        
    }    
 
    create(){
        this.scene.start('MainScene');
    }

    playMusic(){
        let backgroundMusic = this.sound.add('song', { loop: true });
        backgroundMusic.volume = 0.2;
        backgroundMusic.play();
    }

    getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }
}