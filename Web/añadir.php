<?php

//Se incluyen el arvhivo de conexion y la plantilla
include("recursos/php/plantilla.php");      
include("recursos/php/conexion.php");

//Se obtiene la siguiente ID a la ultima existente y la URL a la que se enviaran los datos
$id=$bbdd->query("SELECT MAX(id) FROM estaciones")->fetch();
$ultimo_id=$id[0]+1;
$url="https://".$_SERVER['HTTP_HOST']."/post_datos.php";

//Formulario para crear el nuevo sensor, la ID y URL se rellenan automaticamente, enviara todos los datos a otra pagina
echo"
<div class='index'>
<div class='left'>
<form action='añadir_bg.php?pg=estaciones' method='post'>
  <h2></h2><br>
  <table>
  <tr>
    <th colspan=2>Registra una nueva estacion</th>
  </tr>
  <tr>
    <td>Estacion numero:</td>
    <td><input type='text' name='ID' value='$ultimo_id'><br></td>
  </tr>
  <tr>
    <td>Nombre:</td>
    <td><input type='text' name='nombre'></td>
  </tr>
  <tr>
    <td>Ubicacion:</td>
    <td><select name='ubicacion'>
    <option>-Seleccionar-</option>
    <option value='Otro'>Otro</option>
    <option value='Interior'>Interior</option>
    <option value='Exterior'>Exterior</option>
  </select></td>
  </tr>
  <tr>
    <td>Codigo seguridad:</td>
    <td><input type='text' name='codigo'></td>
  </tr>
  <tr>
    <td>SSID WiFi:</td>
    <td><input type='text' name='ssid'><br></td>
  </tr>
  <tr>
    <td>Contraseña WiFi:</td>
    <td><input type='text' name='pass'><br></td>
  </tr>
  <tr>
    <td>URL:</td>
    <td><input type='text' name='url' value='$url'><br></td>
  </tr>
  <tr>
    <td>Frecuencia Acutalizacion:</td>
    <td><select name='tiempo'>
      <option value='600000'>10 minutos</option>
      <option value='300000'>5 minutos</option>
      <option value='60000'>1 minuto</option>
      <option value='10000'>10 segundos</option>
    </select></td>
  </tr>
  <tr>
    <td colspan=2><input type='submit' value='Crear'></td>
  </tr>
</table>
<br>

</form>

</div>
<div class='right'>
<br><br>
Al añadir un sensor, este sera agragado a la base de datos, y se mostrara el codigo necesario para el ESP32 con todos
los parametros configurados para que el sensor funcione y una imagen con el diagrama para conectar el sensor correctamente.<br><br><br>
-Numero de estacion: Se recomienda mantener el valor por defecto (siguiente al ultimo existente) a no ser que sea para ocupar el de una estacion borrada.<br><br>
-Nombre: El nombre con el que se mostrara la estacion, por ejemplo salon.<br><br>
-Ubicacion: Sirve principalmente para agrupar los sensores y poder ver datos del interior o exterior.<br><br>
-Codigo de seguridad: Servira para que solo el sensor indicado pueda generar los datos, sera configurara automaticamente en el sensor pero es mejor recordarlo.<br><br>
-SSID y contraseña WiFi: Son los que usara el sensor para conectarese a internet, solo seran almacenados en el propio sensor.<br><br>
-URL: La direccion a la que el sensor enviara los datos. Si no se ha realizado ninguna modificacion se debe mantener la configurada por defecto
para que el envio de datos funcione.<br><br>
-Frecuencia de actualizacion: Se recomienda usar el valor por defecto (10 minutos) o 5 como minimo. Los valores menores son solo para pruebas o usos muy concretos,
 ya que generan demasiados datos y la temperatura o humedad no llega a cambiar tan rapido.<br><br>

</div>
</div>

";

pie();
?>