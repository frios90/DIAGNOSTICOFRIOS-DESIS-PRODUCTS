/**
 * JS principal de la aplicación.
 * Con el fin de representar una base escalable, arme una estructura que permite "acoplar" módulos a este js principal de manera
 * sencilla y organizada. Para el caso solo aplica el módulo de productos pero eventualmente podría añadir otros.
 */
import { appProducts } from './products/index.js';
import { appBranches } from './branches/index.js';
import { appCurrencies } from './currencies/index.js';
import { appMaterials } from './materials/index.js';
import { appWarehouses } from './warehouses/index.js';

document.addEventListener('DOMContentLoaded', function() {
    appProducts();
    appBranches();
    appCurrencies();
    appMaterials();
    appWarehouses();
    /**Llamada a otros posibles módulos. */
});