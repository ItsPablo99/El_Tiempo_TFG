<?php

//Se incluyen el arvhivo de conexion y la plantilla
include("recursos/php/plantilla.php");      
include("recursos/php/conexion.php");

//Titulo y tabla para mostrar las estaciones
echo"
<h2>Estaciones</h2>
<table>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Ubicacion</th>
    <th>Opciones</th>
</tr>";

//Se obtienen y muestran todas las estaciones, con un boton borrar que pasara un parametro delete y otro editar que lleva a otra pagina
foreach($bbdd->query("SELECT * FROM estaciones") as $row){
    echo"<tr>
    <td>".$row['ID']."</td>
    <td>".$row['Nombre']."</td>
    <td>".$row['Ubicacion']."</td>
    <td>
    <a href='estaciones.php?pg=estaciones&delete=".$row['ID']."'><input type='button' value='Borrar' /></a>
    <a href='editar.php?pg=estaciones&edit=".$row['ID']."'><input type='button' value='Editar' /></a>
    </td>
    </tr>
    ";
}

//Se cierra la tabla y boton añadir estacion
echo "</table><br>
Atencion: Editar o borrar una estacion borrara todos sus datos.<br><br>
<a href='añadir.php?pg=estaciones'><input type='button' value='Añadrir estacion' /></a>";

//Si se ha pulsado el boton borrar el parametro delete exisitira, y se borra la estacion indicada
if(isset($_GET['delete'])){
  $sql="DELETE FROM estaciones WHERE ID='".$_GET['delete']."'"; 
  $delete=$bbdd->query($sql);
  echo "<br><br>Estacion con ID ".$_GET['delete']." borrada";
}

pie();
?>


