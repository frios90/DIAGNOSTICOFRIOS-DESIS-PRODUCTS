import { loadProducts } from './loadProducts.js';

/**
 * Función para CREAR un nuevo PRODUCTO
 *
 *
 */
export const postProduct = () => {
    const form_data = new FormData(document.getElementById('productForm'));

    const materials = [];
    document.querySelectorAll('input[name="materials[]"]:checked').forEach(e => {
        materials.push(e.value);
    });

    materials.forEach(e => form_data.append('materials[]', e));
    const end_point = 'app/modules/products/controllers/PostProductController.php';
    fetch(end_point, {method: 'POST', body: form_data})
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('productForm').reset();
            document.getElementById('branch').innerHTML = '<option value="">Seleccione Sucursal</option>';
            document.querySelectorAll('input[name="materials[]"]').forEach(e => e.checked = false);
            loadProducts();
        }
        alert(data.message);
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error);
    });
}