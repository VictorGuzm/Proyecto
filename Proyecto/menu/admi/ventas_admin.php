<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de venta</title>
    <link rel="stylesheet" href="style/style_ventas.css">
    <?php
    require("../../BD/conect.php");
    $conexion = conectar_bd();
    $sql = "SELECT * FROM productos";
    $result = $conexion->query($sql);
    ?>
</head>
<body>
<nav>
    <div class="logo">
        <img src="../../public/img/logo_menu.png" alt="Logo">
    </div>
    <ul class="options"> 
        <li><a href="menu_admin.php"><img src="../../public/img/inicio.png" alt="inicio"><p>Inicio</p></a></li> 
        <li><a href="productos_admin.php"><img src="../../public/img/productos.png" alt="productos"><p>Productos</p></a></li> 
        <li><a href="ventas_admin.php"><img src="../../public/img/ventas.png" alt="ventas"><p>Ventas</p></a></li> 
        <li><a href="proveedores_admin.php"><img src="../../public/img/proveedores.png" alt="proveedores"><p>Proveedores</p></a></li> 
        <li><a href="reportes_admin.html"><img src="../../public/img/reportes.png" alt="reportes"><p>Reportes</p></a></li> 
        <li><a href="empleados_admin.php"><img src="../../public/img/empleados.png" alt="empleados"><p>Empleados</p></a></li> 
        <li><a href="../../login/"><img src="../../public/img/cerrar.png" alt="salir"><p>Cerrar</p></a></li> 
    </ul> 
</nav>
<h1>Ventas</h1>
<div class="contenedor">
    <div class="div-left">
        <h1>Formulario</h1>
        <form action="guardar-venta.php" method="post">
            <label for="vendedor_ci">CI Vendedor:</label>
            <input class="formulario" type="text" id="vendedor_ci" name="vendedor_ci">
            <label for="cliente_ci">CI Cliente:</label>
            <input class="formulario" type="text" id="cliente_ci" name="cliente_ci" onkeyup="buscarCliente(this.value)">
            <label for="nombre">Nombre:</label>
            <input class="formulario" type="text" id="nombre" name="nombre">
            <label for="direccion">Dirección:</label>
            <input class="formulario" type="text" id="direccion" name="direccion"> 
            <label for="cantidad">Teléfono:</label>
            <input class="formulario" type="number" id="telefono" name="telefono">
            <label for="fecha">Fecha:</label>
            <input class="formulario" type="date" id="fecha" name="fecha" value="" autocomplete="date">
            <label for="hora">Hora:</label>
            <input class="formulario" type="time" id="hora" name="hora" value="" autocomplete="time">
            <label for="metodos-pago">Métodos de pago:</label>
            <select id="metodos-pago" name="metodos-pago">
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta de crédito">Tarjeta de crédito</option>
                <option value="tarjeta de débito">Tarjeta de débito</option>
            </select><br>
            <input type="submit" value="Agregar cliente" class="boton" formaction="procss_client.php">
            <input type="button" value="Añadir al carrito" class="boton" id="agregar-producto">
            <input type="reset" value="Limpiar" class="boton">
        </form>
    </div>
    <div class="div-right">
        <h1>Carrito</h1>
        <div class="tablas">
            <table >
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="tabla-carrito">
                </tbody>
            </table>
            <h3>Total: $<span id="total-carrito">0</span> Bs:<span id="precio-bolivares">0</span></h3>
        </div>
        <div class="boton-derecha">
            <button id="finalizar-compra" class="boton">Finalizar Compra</button>
        </div>
    </div>
</div>
<div class="boton-derecha">
</div>
<div id="mensaje" class="mensaje">
    <h2>Ingresa el precio del dólar en bolívares</h2>
    <input type="number" id="precio-dolar" step="0.01" required>
    <button class="boton" type="button" id="guardar-precio-dolar">Guardar</button></div>
    <p id="precio-dolar-actual"></p>
    <div id="productos-container" class="productos-container hidden">
        <h1>Productos</h1>
        <table id="productos-table"class="tablas2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Agregar</th>
                </tr>
            </thead>
            <tbody>
<?php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td id='product-name-".$row['id']."'>".$row['nombre']."</td>";
    echo "<td id='product-price-".$row['id']."'>".$row['precio']."</td>";
    echo "<td>".$row['stock']."</td>";
    echo "<td>".$row['categoria']."</td>";
    echo "<td>
        <form method='post'>
            <button type='button' class='boton agregar' id='agregar-producto-".$row['id']."' onclick='agregarProducto(".$row['id'].")'>Agregar</button>
        </form>
    </td>";
    echo "</tr>";
}
?>
</tbody>
        </table>
    </div>

<script>
const botonesAgregar = document.querySelectorAll('.agregar');
botonesAgregar.forEach((boton) => {
  boton.addEventListener('click', agregarProducto);
});

function agregarProducto(event) {
  const boton = event.target;
  const productoId = boton.id.split('-')[2];

  // Obtener los datos del producto seleccionado
  const productoNombre = document.getElementById(`product-name-${productoId}`).innerText;
  const productoPrecio = parseFloat(document.getElementById(`product-price-${productoId}`).innerText);

  // Agregar el producto al carrito
  agregarAlCarrito(productoId, productoNombre, productoPrecio);
}

let carrito = [];

function agregarAlCarrito(productoId, productoNombre, productoPrecio) {
  const productoExistente = carrito.find((producto) => producto.id === productoId);

  if (productoExistente) {
    productoExistente.cantidad++;
  } else {
    carrito.push({ id: productoId, nombre: productoNombre, precio: productoPrecio, cantidad: 1 });
  }

  calcularTotalCarrito();
  mostrarCarrito();
}

function calcularTotalCarrito() {
  let total = 0;

  carrito.forEach((producto) => {
    const subtotal = producto.precio * producto.cantidad;
    total += subtotal;
  });

  document.getElementById('total-carrito').innerText = total.toFixed(2);
}

function mostrarCarrito() {
  const tablaCarrito = document.getElementById('tabla-carrito');
  tablaCarrito.innerHTML = '';

  carrito.forEach((producto) => {
    const row = document.createElement('tr');

    const nombreCell = document.createElement('td');
    nombreCell.innerText = producto.nombre;
    row.appendChild(nombreCell);

    const cantidadCell = document.createElement('td');
    cantidadCell.innerText = producto.cantidad;
    row.appendChild(cantidadCell);

    const precioCell = document.createElement('td');
    precioCell.innerText = producto.precio.toFixed(2);
    row.appendChild(precioCell);

    const subtotalCell = document.createElement('td');
    subtotalCell.innerText = (producto.precio * producto.cantidad).toFixed(2);
    row.appendChild(subtotalCell);

    tablaCarrito.appendChild(row);
  });
}

document.getElementById('finalizar-compra').addEventListener('click', enviarCompra);

function enviarCompra() {
  // Enviar los datos de la compra a PHP utilizando AJAX o Fetch API
}
</script>


<script>
    //Script para obtener el precio del dolar
    // Comprobamos si existe un valor guardado en local storage
    let dolarPrice = localStorage.getItem('dolarPrice');
    // Si no existe un valor guardado, mostramos el mensaje emergente
    if (!dolarPrice) {
        dolarPrice = prompt('Ingresa el precio del dólar en bolívares:');
        if (dolarPrice !== null && dolarPrice !== '') {
            localStorage.setItem('dolarPrice', dolarPrice);
        } else {
            alert('Debe ingresar un valor válido para el precio del dólar.');
            location.reload();
        }
    }
    // Actualizamos el precio del dólar en el párrafo correspondiente
    document.getElementById('precio-dolar-actual').innerText = `Precio del dólar actual: ${dolarPrice}Bs`;
    // Función para guardar el precio del dólar en local storage
    function saveDolarPrice() {
        dolarPrice = document.getElementById('precio-dolar').value;
        if (dolarPrice !== null && dolarPrice !== '') {
            localStorage.setItem('dolarPrice', dolarPrice);
            alert('El precio del dólar ha sido actualizado.');
        } else {
            alert('Debe ingresar un valor válido para el precio del dólar.');
        }
    }
    // Agregamos un event listener al botón "Guardar" para guardar el precio del dólar
    document.getElementById('guardar-precio-dolar').addEventListener('click', saveDolarPrice);
</script>
<script>
    //mostrar tabla
    // Agrega un listener de eventos al botón 'añadir-producto'
    document.getElementById('agregar-producto').addEventListener('click', function() {
        // Alterna la clase 'hidden' para el div 'productos-container'
        document.getElementById('productos-container').classList.toggle('hidden');
        document.getElementById('productos-container').classList.toggle('productos-table-visible');
    });
    // Agrega un listener de eventos al botón 'finalizar-compra' para ocultar la tabla de nuevo
    document.getElementById('finalizar-compra').addEventListener('click', function() {
        document.getElementById('productos-container').classList.toggle('hidden');
        document.getElementById('productos-container').classList.toggle('productos-table-visible');
    });
</script>

<script>
    document.getElementById('finalizar-compra').addEventListener('click', enviarCompra);
</script>
</body>
</html>