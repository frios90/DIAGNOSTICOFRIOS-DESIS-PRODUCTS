<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba de Diagnostico Francisco Rios</title>
    <link rel="stylesheet" href="public/css/form.css">
    <link rel="stylesheet" href="public/css/table.css">
</head>
<body>
<div class="container">
    <h1>Formulario de Producto</h1>
    <form id="productForm">
        <div class="row">
            <div class="col">
                <label>Código</label>
                <input type="text" name="code" id="code" maxlength="15" placeholder="Ej: PROD001">
            </div>
            <div class="col">
                <label>Nombre</label>
                <input type="text" name="name" id="name" maxlength="50" placeholder="Ingrese el nombre">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Bodega</label>
                <select name="warehouse" id="warehouse">
                    <option value="">Seleccione Bodega</option>
                </select>
            </div>
            <div class="col">
                <label>Sucursal</label>
                <select name="branch" id="branch">
                    <option value="">Seleccione Sucursal</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Moneda</label>
                <select name="currency" id="currency">
                    <option value="">Seleccione Moneda</option>
                </select>
            </div>
            <div class="col">
                <label>Precio</label>
                <input type="text" name="price" id="price" placeholder="0.00">
            </div>
        </div>

        <div class="col">
            <label>Material del Producto</label>
            <div class="checkbox-group" id="materialsContainer"></div>
        </div>

        <div class="col" style="margin-top:15px;">
            <label>Descripción</label>
            <textarea name="description" id="description" rows="3" placeholder="Ingrese la descripción"></textarea>
        </div>
        <button class="btn" type="submit">Guardar Producto</button>
    </form>
</div>

<div class="table-container">
    <h2>Productos Registrados</h2>
    <div id="productTable" style="overflow-x: auto; margin-top: 20px;">
        <table id="productsTable">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Bodega</th>
                    <th>Sucursal</th>
                    <th>Moneda</th>
                    <th>Precio</th>
                    <th>Materiales</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <tr><td colspan="9" style="text-align:center;">Cargando productos...</td></tr>
            </tbody>
        </table>
    </div>
</div>
    <script type="module" src="public/js/app.js"></script>
</body>
</html>