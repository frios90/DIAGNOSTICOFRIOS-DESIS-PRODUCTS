import { showMessage } from './showMessage.js';
import { loadProducts } from './loadProducts.js';

/**
 * Función para CREAR un nuevo PRODUCTO
 *
 *
 */
export const saveProduct = () => {
    const formData = new FormData(document.getElementById('productForm'));

    const materials = [];
    document.querySelectorAll('input[name="materials[]"]:checked').forEach(e => {
        materials.push(e.value);
    });

    materials.forEach(e => formData.append('materials[]', e));

    showMessage('Guardando...', 'info');

    const end_point = 'app/modules/products/controllers/postProductController.php';
    fetch(end_point, {method: 'POST', body: formData})
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage(data.message, 'success');
            document.getElementById('productForm').reset();
            document.getElementById('branch').innerHTML = '<option value="">Seleccione Sucursal</option>';
            document.querySelectorAll('input[name="materials[]"]').forEach(e => e.checked = false);
            loadProducts();
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage(error, 'error');
    });
}