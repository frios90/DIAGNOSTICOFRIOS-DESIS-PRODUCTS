/**
 * Función para cargar el listado de MATERIALES
 *
 *
*/
export const loadMaterials = () => {
    const end_point = `app/modules/materials/controllers/getListController.php`;
    fetch(end_point)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('materialsContainer');
            container.innerHTML = '';
            data.forEach(item => {
                container.innerHTML += `
                    <label>
                        <input type="checkbox" name="materials[]" value="${item.id}">
                        ${item.name}
                    </label>
                `;
            });
        })
        .catch(error => console.error('Error:', error));
}
