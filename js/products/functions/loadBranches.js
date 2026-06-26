/**
 * Función para cargar el listado de SUCURSALES
 *
 *
*/
export const loadBranches = (warehouse_id) => {
    if (!warehouse_id) {
        document.getElementById('branch').innerHTML = '<option value="">Seleccione Sucursal</option>';
        return;
    }
    const end_point = `ajax/branches/getList.php?warehouse_id=${warehouse_id}`;
    fetch(end_point)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('branch');
            select.innerHTML = '<option value="">Seleccione Sucursal</option>';
            data.forEach(item => {
                select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
            });
        })
        .catch(error => console.error('Error:', error));
}
