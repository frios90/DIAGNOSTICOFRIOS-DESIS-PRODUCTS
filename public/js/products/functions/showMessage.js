/**
 * Función para visualizar un mensaje
 *
 *
*/
export const showMessage = (text, type) => {
    const div = document.getElementById('message');
    div.textContent = text;
    div.className = 'message ' + type;
    div.style.display = 'block';
    if (type === 'success') {
        setTimeout(() => div.style.display = 'none', 5000);
    }
}
