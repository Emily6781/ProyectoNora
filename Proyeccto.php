<?php
require('conexion.php');

// Obtener productos y categorías
$productos = $conn->query("SELECT * FROM productos ORDER BY Tipo_ID");
$categorias = [
    1 => "Postres",
    2 => "Bebidas",
    3 => "Desayunos",
    4 => "Aperitivos",
    5 => "Comidas"
];
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Proyecto C.S.S.</title>
    <link rel="stylesheet" href="estilo.css" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
  </head>

  <body>
    <div class="container">
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <!-- Inicio (Landing page) -->
                <a class="navbar-brand" href="#">C++</a>

                  <li><a href="./Clientes/mostrarClientes.php">Clientes</a></li>
                  <li><a href="">Empleados</a></li>
                  <li><a href="./Productos/gest.php">Productos</a></li>
                  <li><a href="./Ventas/Views/CrearVenta.php">Ventas</a></li>
            </ul>
        </div>
    </div>
</nav>

      <br>
      <br>
      <br>
      <br>

      <img src="Recursos/Visuales/Café++.png" alt="Café ++" id="imagenC" />

      <br>

      <audio controls autoplay loop>
        <source src="Recursos/Auditivos/P540.wav" type="audio/wav">
        <source src="Recursos/Auditivos/P540.wav" type="audio/wav">
        Tu navegador no soporta la etiqueta de audio.
      </audio>

      <h1>"Mucho más que los demás"</h1><br>

      <div id="listDiv">
            <h2>Lo más atractivo de nuestro menú</h2>
            <div class="carousel-container">
                <?php
                foreach ($categorias as $tipo_id => $nombre_categoria) {
                    echo "<div class='list-item'>";
                    echo "<h3>{$nombre_categoria}</h3><ul>";
                    foreach ($productos as $producto) {
                        if ($producto['Tipo_ID'] == $tipo_id) {
                            echo "<li>{$producto['Nombre']} - {$producto['Precio']}</li>";
                        }
                    }
                    echo "</ul></div>";
                }
                ?>
            </div>
        </div>
      <br>
      <br>

      <img src="Recursos/Visuales/Café_+A2.png" alt="Café +A" id="imagenA" />
      <div id="tableDiv">
        <table>
          <h2>Conozca a los integrantes de la familia Café ++</h2>
          <br>
          <tr>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Puesto</th>
            <th>Luce como...</th>
          </tr>
          <tr>
            <td>David</td>
            <td>36</td>
            <td>Gerente genaral</td>
            <td>NONE</td>
          </tr>
          <tr>
            <td>Juan</td>
            <td>25</td>
            <td>Mesero</td>
            <td>NONE</td>
          </tr>
          <tr>
            <td>María</td>
            <td>30</td>
            <td>Auxiliar de cocina</td>
            <td>NONE</td>
          </tr>
          <tr>
            <td>Carlos</td>
            <td>28</td>
            <td>Auxiliar de cocina</td>
            <td>NONE</td>
          </tr>
          <tr>
            <td>Gustavo</td>
            <td>55</td>
            <td>Encargado de limpieza</td>
            <td><img src="Recursos/Visuales/Gus.jpg" alt="Gustavo" id="credencial"/></td>
          </tr>
        </table>
      </div>

      <img src="Recursos/Visuales/Mack.png" alt="Mack" id="Monito">
      <div id="mapDiv">
        <h2>Visítenos en nuestra sucursal</h2>
        <ul>
          <li>
            Café++
            <ul>
              <li>Ubicación: Av. Universidad de Guadalajara 203, Ixtapa, Los Tamarindos, 48280 Puerto Vallarta, Jal.</li>
              <li>Teléfono: 322-XXX-XX-XX</li>
            </ul>
          </li>
          <li>
          <br>
          <br>
            Sucursales en camino:
            <ul>
              <li>Café Shyarp (Proximamente)</li>
              <li>ANSI Café (Proximamente)</li>
            </ul>
          </li>
        </ul>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29857.38471710671!2d-105.2276638232788!3d20.703194734247873!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x84214602cc646113%3A0x25abd7f1a407a134!2sCUCOSTA%20Centro%20Universitario%20de%20la%20Costa%20-%20UDG!5e0!3m2!1ses-419!2smx!4v1725400578909!5m2!1ses-419!2smx"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
      </div>

      <img src="Recursos/Visuales/Rick.png" alt="Rick" id="Monito">
      <div id="gameDiv">
        <h2>¿Interesado en lo que hacemos?</h2>
        <ul>
          <li>
            <br>
            Una empresa asociada con nosotros desarrolló una versión interactiva de nuestra cafeteria
          </li>
        </ul>
        <ul>
          <li>
            <img src="Recursos/Visuales/Team Tocino.png" alt="Café ++" id="imagenC" />
          </li>
          <li>
            Un videojuego accesible para todos donde se te estudiara como persona
              <img src="Recursos/Visuales/Fase 1.png" alt="Café ++" id="imagenC" />
          </li>
          <li>
            Y luego llegaras a tomar uno de los puestos existentes en nuestra cafeteria
              <img src="Recursos/Visuales/Fase 22.png" alt="Café ++" id="imagenC" />
              <br>
              ¿Quien sabe? a lo mejor encuentras el puesto ideal para tí
          </li>
          <li>
            <a href="Recursos/Ejecutables/bin-EPI.zip" download="archivo.pdf">Descargelo ahora mismo y comience</a>
          </li>
        </ul>
      </div>
      <img src="Recursos/Visuales/Wendy.png" alt="Wendy" id="Monito">

      <h2>Cliente Nuevo</h2>
      <form action="clienteNuevo.php" method="post">
          <div id="encuesta">
          <label for="">Nombre</label>
          <input type="text" name="nombreC" id="nombreC">
          <label for="">Fecha de Visita</label>
          <input type="date" name="FechaV" id="FechaV">
          <label for="Edad">Edad</label>
          <input type="number" name="edad" id="edad" >
          </div>

          <div id="encuesta">
            <p>En la siguiente escala, cómo calificaria su experiencia en local</p><br>
            <input type="radio" name="ExpL" value="Excelente"/>Excelente
            <input type="radio" name="ExpL" value="Buena" />Buena
            <input type="radio" name="ExpL" value="Neutra" />Neutra
            <input type="radio" name="ExpL" value="Mala" />Mala
            <input type="radio" name="ExpL" value="Terrible" />Terrible
          </div>

          <div id="encuesta">
            <p>Describa cuál fue su modalidad de visita</p><br>
            <input type="radio" name="Modalidad" value="Comedor"/>Comer en el local
            <input type="radio" name="Modalidad" value="Llevar" />Para llevar
          </div>

          <div id="encuesta">
            <p>Qué tan satisfecho estubo con su pedido</p><br>
            <input type="radio" name="Spedido" value="Mucho"/>Mucho
            <input type="radio" name="Spedido" value="Bien" />Bien
            <input type="radio" name="Spedido" value="Suficiente" />Suficiente
            <input type="radio" name="Spedido" value="Poco" />Poco
            <input type="radio" name="Spedido" value="Nada" />Nada
           </div>

          <div id="encuesta">
            <p>En la siguiente escala, como calificaria el tiempo que espero sus alimentos</p><br>
            <input type="radio" name="Calimentos" value="Excelente"/>Excelente
            <input type="radio" name="Calimentos" value="Buena" />Bueno
            <input type="radio" name="Calimentos" value="Neutra" />Neutro
            <input type="radio" name="Calimentos" value="Mala" />Malo
            <input type="radio" name="Calimentos" value="Terrible" />Terrible
          </div>

          <div id="encuesta">
            <p>Esta de acuerdo con los precios de los productos que compró</p><br>
            <input type="radio" name="Pproductos" value="Muy de acuerdo"/>Muy de acuerdo
            <input type="radio" name="Pproductos" value="De acuerdo" />De acuerdo
            <input type="radio" name="Pproductos" value="Neutro" />Neutro
            <input type="radio" name="Pproductos" value="En desacuerdo" />En desacuerdo
            <input type="radio" name="Pproductos" value="Muy en desacuerdo
            " />Muy en desacuerdo
          </div>

          <div id="encuesta">
            <p>En la siguiente escala, como calificaria la atención del meser@</p><br>
            <input type="radio" name="Amesero" value="Excelente"/>Excelente
            <input type="radio" name="Amesero" value="Buena" />Buena
            <input type="radio" name="Amesero" value="Neutra" />Neutra
            <input type="radio" name="Amesero" value="Mala" />Mala
            <input type="radio" name="Amesero" value="Terrible" />Terrible
          </div>

          <div id="encuesta">
            <p>¿Cuál es la probabilidad de que regrese?</p><br>
            <input type="radio" name="Probabilidad" value="100"/>100%
            <input type="radio" name="Probabilidad" value="75" />75%
            <input type="radio" name="Probabilidad" value="50" />50%
            <input type="radio" name="Probabilidad" value="25" />25%
            <input type="radio" name="Probabilidad" value="0" />0%
          </div>

          <br />Escribanos al buzón de sugerencias: <br />
          <textarea name="comenta" rows="6" cols="60" placeholder="Escribe aquí"> </textarea>

          <br>
          <input type="submit" name="cliente" value="Guardar">
          <input type="reset" value="Borrar">
      </form>
      <br>
    </body>

    <footer>
      <p>Hecho por Café++ en colobaración con Team Tocino. Puerto Vallarta, Jal. 19 de Noviembre 2024.</p><br>
    </footer>

  </div>
  </html>
