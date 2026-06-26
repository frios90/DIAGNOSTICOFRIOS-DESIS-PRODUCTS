/**
 * Función para cargar el listado de PRODUCTOS
 *
 * funcionalidad adicional para poder revisar los datos que se estan creando
 * se ve en una tabla que deje un poco mas abajo del formulario haciendo scroll
 *
*/
export const loadProducts = () => {
    const tbody = document.getElementById('tableBody');
    tbody.innerHTML = '<tr><td colspan="9">Cargando...</td></tr>';
    const end_point = 'app/modules/products/controllers/getListController.php';
    fetch(end_point)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                tbody.innerHTML = `<tr><td colspan="9" style="color:red;">Error: ${data.error}</td></tr>`;
                return;
            }
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="9">No hay productos registrados</td></tr>';
                return;
            }

            tbody.innerHTML = '';
            data.forEach(product => {
                const date = new Date(product.created_at).toLocaleDateString('es-CL');
                const price = new Intl.NumberFormat('es-CL', {
                    style: 'currency',
                    currency: 'CLP'
                }).format(product.price);

                tbody.innerHTML += `
                    <tr>
                        <td><strong>${product.code}</strong></td>
                        <td>${product.name}</td>
                        <td>${product.warehouse || 'N/A'}</td>
                        <td>${product.branch || 'N/A'}</td>
                        <td>${product.currency || 'N/A'}</td>
                        <td>${price}</td>
                        <td><span class="material-tags">${product.materials}</span></td>
                        <td>${product.description.substring(0, 50)}${product.description.length > 50 ? '...' : ''}</td>
                        <td>${date}</td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = '<tr><td colspan="9" style="color:red;">Error al cargar productos</td></tr>';
        });
}
