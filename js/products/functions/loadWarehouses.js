/**
 * Función para cargar el listado de BODEGAS
 *
 *
*/
export const loadWarehouses = () => {
    const end_point = `ajax/warehouses/getList.php`;
    fetch(end_point)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('warehouse');
            select.innerHTML = '<option value="">Seleccione Bodega</option>';
            data.forEach(item => {
                select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
            });
        })
        .catch(error => console.error('Error:', error));
}
