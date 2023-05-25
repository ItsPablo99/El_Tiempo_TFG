<?php

//Se incluyen el arvhivo de conexion y la plantilla
include("recursos/php/plantilla.php");      
include("recursos/php/conexion.php");
?>

<!--Select para filtrar ubicacion-->
<form action='registros.php?pg=registros' method='post'>
<h3 class='nomargin'>Filtrado</h3>
Ubiacion
<select name='ubicacion'>
<option value="">Todas</option>

<?php

//Se obtienen todas las ubicaciones y se muestran como opcion
$sql="SELECT * FROM estaciones";
foreach($bbdd->query($sql) as $row){
    echo"<option value='".$row['Nombre']."'";

    //Para mantener la ubicacion seleccionada al refrescar la pagina
    if(!empty($_POST) AND $_POST['ubicacion']==$row['Nombre']){
        echo 'selected="selected"';
    }
    echo">".$row['Nombre']."</option>";
    }

//Funcion para mantener el periodo seleccionado al refrescar la pagina
function selected_periodo($periodo=""){
    if(!empty($_POST) AND $_POST['tiempo']==$periodo){
        echo 'selected="selected"';
    }
}

//Select para filtrar por periodo
echo"</select> Periodo <select name='tiempo'>";

echo'<option value=""';
selected_periodo();
echo">Desde siempre</option>";
  
echo'<option value="1"';
selected_periodo(1);
echo">Ultima hora</option>";

echo'<option value="6"';
selected_periodo(6);
echo">Ultimas 6 horas</option>";
 
echo'<option value="12"';
selected_periodo(12);
echo">Ultimas 12 horas</option>";

echo'<option value="24"';
selected_periodo(24);
echo">Ultimo dia</option>";

echo'<option value="168"';
selected_periodo(168);
echo">Ultima semana</option>";

echo'<option value="744"';
selected_periodo(744);
echo">Ultimo mes</option>";
?>

</select>
<input type='submit' name='filtrar' value='Aplicar filtro'/>
<br><br>

<!--Tabla para mostrar los datos-->
<table>
<tr>
    <th>ID</th>
    <th>Sensor</th>
    <th>Temperatura</th>
    <th>Humedad</th>
    <th>Fecha</th>
    <th>Borrar</th>
</tr>

<?php

//Select para obtener los datos deseados
$sql = "SELECT registros.ID, ID_sensor, Temperatura, Humedad, Fecha, estaciones.Nombre, estaciones.Ubicacion FROM registros INNER JOIN estaciones ON registros.ID_sensor = estaciones.ID";
$cond="";

//Si se ha aplicado algun filtro se añade a la select
if(!empty($_POST)){

    //Si se aplica filtro de ubicacion y de periodo
    if($_POST['ubicacion']!=""AND $_POST['tiempo']!=""){
        $cond=" AND estaciones.Nombre='".$_POST['ubicacion']."' AND fecha > now() - interval ".$_POST['tiempo']." hour";
    }

    //Si se aplica filtro de periodo
    else if($_POST['tiempo']!=""){
        $cond=" AND fecha > now() - interval ".$_POST['tiempo']." hour";
    }

    //Si se aplica filtro de ubicacion
    else if($_POST['ubicacion']!=""){
        $cond=" AND estaciones.Nombre='".$_POST['ubicacion']."'";
    }
    $sql=$sql.$cond;
}

//Los resultados se ordenan de mas nuevo a mas antiguo
$sql=$sql." ORDER BY ID DESC";
//Se muestran todos los resultados y se almacenan en un array, se almacena en otro array los que se marquen para borrar
foreach($bbdd->query($sql) as $row){
    $registros[] = $row['ID'];
    echo"<tr>
    <td>".$row['ID']."</td>
    <td>".$row['Nombre']."</td>
    <td>".$row['Temperatura']."</td>
    <td>".$row['Humedad']."</td>
    <td>".$row['Fecha']."</td>
    <td>
    <input type='checkbox' name='borrar[]' value='".$row['ID']."'>
    </td>
    </tr>";
}

//Si no hay datos se muestra un error
if (!isset($registros)){
    echo"
    <tr>
    <td colspan='6'>Sin datos :(</td>
    </tr>";
}

//Opcion para borrar todos los datos mostrados
echo "
<tr>
<th colspan='5'>Borrar todos los datos mostrados <input type='checkbox' name='borra_todo' value='a'></th>
<th><input type='submit' name='elimina' value='Borrar'/></th>
</tr>
</table></form><br>";

//Se comprueba si hay datos marcados para borrar o se ha seleccionado borrar todo y si se ha hecho click en eliminar
if((isset($_POST['borrar'])OR(isset($_POST['borra_todo']))) && isset($_POST['elimina'])){

    //Si se ha elegido borrar todo se recorre el array con todos los datos mostrados eliminandolos
    if(isset($_POST['borra_todo'])){
        $i=0;
        while($i<count($registros)){
            $borra=$registros[$i];
            $sql="DELETE FROM registros where id=$borra";
            $bbdd->query($sql);
            $i++;
        }
        echo "<br>Se han borrado ".count($registros)." registros";

    //Si se han marcado datos para borrar se recorre el array con los datos marcados eliminandolos
    }else{
        $i=0;
        while($i<count($_POST['borrar'])){
            $borra=$_POST['borrar'][$i];
            $sql="DELETE FROM registros where id=$borra";
            $bbdd->query($sql);
            $i++;
        }
        echo "<br>Se han borrado ".count($_POST['borrar'])." registros";
    }

//Si se hace click en borrar pero no hay datos que eliminar
}else if(isset($_POST['elimina'])){
    echo "No se ha seleccionado ningun dato que borrar";
}

pie();
?>
