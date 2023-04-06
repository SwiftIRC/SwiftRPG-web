import "../css/map.css";
import * as Phaser from "phaser";
import { MapScene } from "./map/scenes/map.scene";
import { BootScene } from "./map/scenes/boot.scene";

class App {
    game: Phaser.Game;
    width = window.document
        .querySelector<HTMLDivElement>("#app")!
        .getBoundingClientRect().width;
    height = window.document
        .querySelector<HTMLDivElement>("#app")!
        .getBoundingClientRect().height;
    private _config: Phaser.Types.Core.GameConfig = {
        scale: {
            mode: Phaser.Scale.RESIZE,
            width: "100%",
            height: "100%",
            parent: "app",
        },
        scene: [BootScene, MapScene],
        backgroundColor: "#8f7f67",
    };
    constructor() {
        this.game = new Phaser.Game(this._config);
    }
}

new App();
