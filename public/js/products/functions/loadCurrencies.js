/**
 * Función para cargar el listado de MONEDAS
 *
 *
*/
export const loadCurrencies = () => {
    const end_point = `app/modules/currencies/controllers/getListController.php`;
    fetch(end_point)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('currency');
            select.innerHTML = '<option value="">Seleccione Moneda</option>';
            data.forEach(item => {
                select.innerHTML += `<option value="${item.id}">${item.name} (${item.symbol})</option>`;
            });
        })
        .catch(error => console.error('Error:', error));
}
