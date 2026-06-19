export class PreloadScene extends Phaser.Scene {
    constructor(){
        super('PreloadScene');
    }

    preload(){
        this.load.setPath('/images/game');
        this.load.image('bg', 'bg.jpg');
        this.load.image('ball', 'ball.png');
        this.load.image('bug', 'bug.png');
        this.load.image('catch', 'catch.png');
        this.load.spritesheet('fly', 'fly_compressed.png', { frameWidth: 1043.8, frameHeight: 773 } );
        this.load.spritesheet('cry', 'cry.png', { frameWidth: 1025.8, frameHeight: 773 } );
        this.load.image('iddle', 'iddle.png');
        this.load.image('logo1', 'logo1.png');
        this.load.image('logo2', 'logo2.png');
        this.load.audio('bg', 'background.mp3');
        this.load.audio('goal', 'goal.mp3');
        this.load.audio('kick', 'kick.mp3');
    }

    create(){
        this.scene.start('MenuScene');
    }
}
