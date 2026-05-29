let width, height, score;

export class GameOverScene extends Phaser.Scene {
    constructor(){
        super('GameOverScene');
    }  

    preload(){}    

    create(){ 
        setTimeout(() => {
            location.reload();
        }, 5000);
    }
} 