/**
 * JS principal de la aplicación.
 * Con el fin de representar una base escalable, arme una estructura que permite "acoplar" módulos a este js principal de manera
 * sencilla y organizada. Para el caso solo aplica el módulo de productos pero eventualmente podría añadir otros.
 */
import { appProducts } from './products/index.js';

document.addEventListener('DOMContentLoaded', function() {
    appProducts();
    /**Llamada a otros posibles módulos. */
});