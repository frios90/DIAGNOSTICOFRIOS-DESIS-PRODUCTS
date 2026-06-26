/**
 * Esta sería la segunda entrada app -> products index, que funciona como un centralizador de funcionalidades.
 * Dichas funciones, para este módulo son las que estan creadas en la carpeta funcions, permitiendo una mejor lectura
 * evitando la creación de un solo archivo JS lleno de funciones que con el tiempo se hace muy dificil de leer.
 *
*/
import { loadWarehouses } from './functions/loadWarehouses.js';
import { loadBranches } from './functions/loadBranches.js';
import { loadCurrencies } from './functions/loadCurrencies.js';
import { loadMaterials } from './functions/loadMaterials.js';
import { loadProducts } from './functions/loadProducts.js';
import { validateForm } from './functions/validateForm.js';
import { saveProduct } from './functions/saveProduct.js';

export const appProducts = () => {
    loadWarehouses();
    loadCurrencies();
    loadMaterials();
    loadProducts();

    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateForm()) {
            saveProduct();
        }
    });

    document.getElementById('warehouse').addEventListener('change', function() {
        loadBranches(this.value);
    });
}
