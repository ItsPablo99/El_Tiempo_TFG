<?php

//Se incluyen el arvhivo de conexion y la plantilla
include("recursos/php/plantilla.php");
include("recursos/php/conexion.php");

//Select para obtener la ultima ID de registros (numero total de registros)
$sql="SELECT MAX(ID) FROM registros";
$max_id=$bbdd->query($sql)->fetch();

//Texto y enlace a GitHub
echo'
<h1>"El tiempo en casa"</h1>
<h2>Un proyecto relizado por Pablo Anton Lafuente</h2>
<h3>IES Rosa Chacel 2023</h3>
<h3><a href="https://github.com/ItsPablo99/eltiempo_tfg">Codigo y documentacion (GitHub)</a></h3>
<br>Software del servidor: 
';

//Informacion sobre el servidor
echo $_SERVER['SERVER_SOFTWARE'];
echo"<br><br>Protocolo de conexion: ";
echo $_SERVER['SERVER_PROTOCOL'];
echo"<br><br>Uptime del servidor: ";
echo shell_exec('uptime -p');

//Numero de registros
echo"<br><br><h3>Registros totales procesados: ";
echo $max_id[0];
pie();
?>

