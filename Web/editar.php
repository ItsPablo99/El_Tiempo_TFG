<?php

//Se incluyen el arvhivo de conexion y la plantilla
include("recursos/php/plantilla.php");      
include("recursos/php/conexion.php");

//Se obtiene la ID a editar y todos los datos de esta
$id_edit=$_GET['edit'];
$sql="SELECT * FROM estaciones WHERE id=$id_edit";
$editar=$bbdd->query($sql)->fetch();

//Formulario editar, aparecen el nombre y la ubicacion actual
echo"
<form action='editar.php?pg=estaciones&edit=$id_edit&edt=$id_edit' method='post'>
<table>
    <tr>
        <th colspan=2>Editando estacion ID: $id_edit</th>
    </tr>
    <tr>
        <td>Nuevo nombre:</td>
        <td><input type='text' name='nombre' value='".$editar['Nombre']."'></td>
    </tr>
    <tr>
        <td>Nueva ubicacion:</td>
        <td>
        <select name='ubicacion'>
            <option value='Otro'"; if($editar['Ubicacion']=='Otro'){echo 'selected="selected"';} echo">Otro</option>
            <option value='Interior'"; if($editar['Ubicacion']=='Interior'){echo 'selected="selected"';} echo">Interior</option>
            <option value='Exterior'"; if($editar['Ubicacion']=='Exterior'){echo 'selected="selected"';} echo">Exterior</option>
        </select>
        </td>
    </tr>
    <tr>
        <td colspan=2><input type='submit' value='Actualizar'></td>
    </tr>
</table>
</form>
";

//Si se ha hecho click en actualizar
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Se ejecuta el update
    $sql="UPDATE estaciones SET Nombre = '".$_POST['nombre']."', Ubicacion= '".$_POST['ubicacion']."' WHERE ID='".$_GET['edit']."'"; 
    $update=$bbdd->query($sql);
    header("Refresh:0");
}

//Si se ha actualizado la estacion
if(isset($_GET['edt'])){
    $id=$_GET['edt'];
    echo "Estacion con ID $id editada, todos sus datos se han borrado.";
    $sql="DELETE FROM registros WHERE `ID_Sensor` = $id"; 
    $update=$bbdd->query($sql);

}else{
    echo"Atencion: Editar una estacion borrara todos los datos anteriores creados por esta.";
}
pie();
?>