/**
 * Función para validar los datos del formulario según requerimiento del documento
 *
 *
*/
export const validateForm = () => {
    const code = document.getElementById('code').value.trim();
    if (code === '') {
        alert('El código del producto no puede estar en blanco.');
        return false;
    }
    if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/.test(code)) {
        alert('El código debe tener letras y números (5-15 caracteres).');
        return false;
    }

    const name = document.getElementById('name').value.trim();
    if (name === '') {
        alert('El nombre no puede estar en blanco.');
        return false;
    }
    if (name.length < 2 || name.length > 50) {
        alert('El nombre debe tener entre 2 y 50 caracteres.');
        return false;
    }

    const price = document.getElementById('price').value.trim();
    if (price === '') {
        alert('El precio no puede estar en blanco.');
        return false;
    }
    if (!/^\d+(\.\d{1,2})?$/.test(price) || parseFloat(price) <= 0) {
        alert('El precio debe ser un número positivo con hasta 2 decimales.');
        return false;
    }

    if (document.getElementById('warehouse').value === '') {
        alert('Debe seleccionar una bodega.');
        return false;
    }

    if (document.getElementById('branch').value === '') {
        alert('Debe seleccionar una sucursal.');
        return false;
    }

    if (document.getElementById('currency').value === '') {
        alert('Debe seleccionar una moneda.');
        return false;
    }

    const materials = document.querySelectorAll('input[name="materials[]"]:checked');
    if (materials.length < 2) {
        alert('Debe seleccionar al menos dos materiales.');
        return false;
    }

    const description = document.getElementById('description').value.trim();
    if (description === '') {
        alert('La descripción no puede estar en blanco.');
        return false;
    }
    if (description.length < 10 || description.length > 1000) {
        alert('La descripción debe tener entre 10 y 1000 caracteres.');
        return false;
    }

    return true;
}
