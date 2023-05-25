<?php

//Se incluyen el arvhivo de conexion y la plantilla
include("recursos/php/plantilla.php");      
include("recursos/php/conexion.php");

//Se seleccionan los nombres de las estaciones de las diferentes ubicaciones
$estaciones_int=$bbdd->query("SELECT nombre FROM estaciones WHERE UBICACION='interior'")->fetchAll(PDO::FETCH_COLUMN);
$estaciones_ext=$bbdd->query("SELECT nombre FROM estaciones WHERE UBICACION='exterior'")->fetchAll(PDO::FETCH_COLUMN);
$estaciones_otro=$bbdd->query("SELECT nombre FROM estaciones WHERE UBICACION='otro'")->fetchAll(PDO::FETCH_COLUMN);

//Se muestra la lista de cada ubicacion con sus estaciones, el parametro type almacenara lo que se eleija
echo"
    <div class='index'><div class='left'>
    <a class='cat_main' href='index.php?pg=index&type=Todo'>Todo</a><br>

    <a class='cat_main' href='index.php?pg=index&type=Interior'>Interior</a><br>";
    foreach ($estaciones_int as $value) {
        echo"<a class='cat' href='index.php?pg=index&type=$value'>$value</a><br>";
    }

    echo"<a class='cat_main' href='index.php?pg=index&type=Exterior'>Exterior</a><br>";
    foreach ($estaciones_ext as $value) {
        echo"<a class='cat' href='index.php?pg=index&type=$value'>$value</a><br>";
    }
    
    echo"<a class='cat_main' href='index.php?pg=index&type=Otro'>Otros</a><br>";
    foreach ($estaciones_otro as $value) {
        echo"<a class='cat' href='index.php?pg=index&type=$value'>$value</a><br>";
    }
echo "</div><div class='right'>";

//Si no hay nada elegido, se elegira todo
if(isset($_GET['type'])){
    $type=$_GET['type'];
}else{
    $type="Todo";
}

//Se muestra el nombre de lo elegido
echo "<h1 class='medium'>$type</h1>";

//Se compruba si se ha filtrado por periodo, si es asi se añade el filtro a la select
if(empty($_POST)){
    $select=")";
}else{
    if($_POST['tiempo']!=""){
        $select=" AND fecha > now() - interval ".$_POST['tiempo']." hour)";
    }else{
        $select=")"; 
    }
}

//Funcion para dar formato a la fecha
function fecha_format($fecha){
    echo(substr($fecha,8,2)."/".substr($fecha,5,2)." a las ".substr($fecha,11,5));
}

//Si se ha elegido una estacion individual y no una ubicacion
if($type!="Todo" AND $type!="Interior" AND $type!="Exterior" AND $type!="Otro"){    
    
    //Se obtiene la ID que corresponde a la estacion elegida
    $sql="SELECT ID FROM estaciones where Nombre='$type'";      
    $row=$bbdd->query($sql)->fetch();
    $id_selected=$row[0];
    
    //Con la ID se obtiene el dato deseado, si se filtra por fecha se añade el filtro al final
    $sql="SELECT Temperatura, Fecha FROM registros WHERE Temperatura = (SELECT MAX(temperatura) FROM registros WHERE ID_sensor=$id_selected".$select;
    $t_max=$bbdd->query($sql)->fetch();
    
    $sql="SELECT Temperatura, Fecha FROM registros WHERE Temperatura = (SELECT MIN(temperatura) FROM registros WHERE ID_sensor=$id_selected".$select;
    $t_min=$bbdd->query($sql)->fetch();
    
    $sql="SELECT Humedad, Fecha FROM registros WHERE humedad = (SELECT MAX(humedad) FROM registros WHERE ID_sensor=$id_selected".$select;
    $h_max=$bbdd->query($sql)->fetch();

    $sql="SELECT Humedad, Fecha FROM registros WHERE humedad = (SELECT MIN(humedad) FROM registros WHERE ID_sensor=$id_selected".$select;
    $h_min=$bbdd->query($sql)->fetch();

    $sql = "SELECT AVG (temperatura) FROM registros WHERE ID_sensor=$id_selected".rtrim($select, ")");
    $t_avg=$bbdd->query($sql)->fetch();

    $sql = "SELECT AVG(humedad) FROM registros WHERE ID_sensor=$id_selected".rtrim($select, ")");
    $h_avg=$bbdd->query($sql)->fetch();

    $sql="SELECT Temperatura, Humedad, Fecha FROM registros WHERE ID =(SELECT MAX(ID) FROM registros WHERE ID_sensor=$id_selected".$select;
    $ultimo=$bbdd->query($sql)->fetch();

    //Si no hay datos mensaje de error
    if(empty($t_max)){
        echo"<br>Sin datos :(<br><br>";

    //Si hay datos se muestran
    }else{
        echo "<p class='big'>".$ultimo['Temperatura']."C    ".$ultimo['Humedad']."%</p>(De la ultima lectura el ";
        fecha_format($ultimo['Fecha']);
        echo")";
   
        echo "<h2 class='nomargin'>Temperatura maxima: ".$t_max['Temperatura']."C</h2>";
        echo "<p class='small'>De la lectura del ";
        fecha_format($t_max['Fecha']);
    
        echo "<h2 class='nomargin'>Temperatura minima: ".$t_min['Temperatura']."C</h2>";
        echo "<p class='small'>De la lectura del ";
        fecha_format($t_min['Fecha']);
    
        echo "<h2 class='nomargin'>Humedad maxima: ".$h_max['Humedad']."%</h2>";
        echo "<p class='small'>De la lectura del ";
        fecha_format($h_max['Fecha']);
    
        echo "<h2 class='nomargin'>Humedad minima: ".$h_min['Humedad']."%</h2>";
        echo "<p class='small'>De la lectura del ";
        fecha_format($h_min['Fecha']);
    
        echo "<h2>Temperatura media: ".round($t_avg[0],2)."C</h2>";
        echo "<h2>Humedad media: ".round($h_avg[0],2)."%</h2>";
    }

//Si se ha elegido una ubicacion
}else{

    //Si se ha elegido todo se obtienen todas las ID de los sensores
    if($type=="Todo"){
        $sql=$bbdd->query("SELECT ID FROM estaciones")->fetchAll(PDO::FETCH_COLUMN);

    //Si se ha elegido una ubicacion que no sea todo se obtienen las ID de los sensores de esa ubicacion
    }else{    
        $sql=$bbdd->query("SELECT ID FROM estaciones WHERE UBICACION='$type'")->fetchAll(PDO::FETCH_COLUMN);
    }

    //Se almacenan todas las ID obtenidas en un array
    $i=0;
    foreach ($sql as $value) {
        $ids[$i]=$value;
        $i=$i+1;
    }

    //Se convierte el array en una cadena con los numeros separados por comas
    $ids_selected=implode(",", $ids);

    //Se obtienen los datos deseados de los sensores que esten en la cadena, si se filtra por periodo se añade el filtro
    $sql="SELECT estaciones.Nombre, Temperatura, Fecha FROM registros  INNER JOIN estaciones ON registros.ID_sensor = estaciones.ID AND Temperatura = (SELECT MAX(temperatura) FROM registros WHERE ID_sensor IN ($ids_selected)".$select;
    $t_max=$bbdd->query($sql)->fetch();
    
    $sql="SELECT estaciones.Nombre, Temperatura, Fecha FROM registros  INNER JOIN estaciones ON registros.ID_sensor = estaciones.ID AND Temperatura = (SELECT MIN(temperatura) FROM registros WHERE ID_sensor IN ($ids_selected)".$select;
    $t_min=$bbdd->query($sql)->fetch();

    $sql="SELECT estaciones.Nombre, Humedad, Fecha FROM registros  INNER JOIN estaciones ON registros.ID_sensor = estaciones.ID AND Humedad = (SELECT MAX(Humedad) FROM registros WHERE ID_sensor IN ($ids_selected)".$select;
    $h_max=$bbdd->query($sql)->fetch();

    $sql="SELECT estaciones.Nombre, Humedad, Fecha FROM registros  INNER JOIN estaciones ON registros.ID_sensor = estaciones.ID AND Humedad = (SELECT MIN(Humedad) FROM registros WHERE ID_sensor IN ($ids_selected)".$select;
    $h_min=$bbdd->query($sql)->fetch();

    $sql = "SELECT AVG (humedad) FROM registros WHERE ID_sensor IN ($ids_selected)".rtrim($select, ")");
    $h_avg=$bbdd->query($sql)->fetch();

    $sql = "SELECT AVG (temperatura) FROM registros WHERE ID_sensor IN ($ids_selected)".rtrim($select, ")");
    $t_avg=$bbdd->query($sql)->fetch();

    //Si no hay datos mensaje de error
    if(empty($t_max)){
        echo"<br>Sin datos :(<br><br>";
    }else{

    //Si hay datos se muestran
    echo "<h2 class='nomargin'>Temperatura maxima: ".$t_max['Temperatura']."C</h2>";
    echo "<p class='small'>De la lectura en ".$t_max['Nombre']." del ";
    fecha_format($t_max['Fecha']);
    
    echo "<h2 class='nomargin'>Temperatura minima: ".$t_min['Temperatura']."C</h2>";
    echo "<p class='small'>De la lectura en ".$t_min['Nombre']." del ";
    fecha_format($t_min['Fecha']);
    
    echo "<h2 class='nomargin'>Humedad maxima: ".$h_max['Humedad']."%</h2>";
    echo "<p class='small'>De la lectura en ".$h_max['Nombre']." del ";
    fecha_format($h_max['Fecha']);
    
    echo "<h2 class='nomargin'>Humedad minima: ".$h_min['Humedad']."%</h2>";
    echo "<p class='small'>De la lectura en ".$h_min['Nombre']." del ";
    fecha_format($h_min['Fecha']);
    
    echo "<h2>Temperatura media: ".round($t_avg[0],2)."C</h2>";
    echo "<h2>Humedad media: ".round($h_avg[0],2)."%</h2>";
    }
}

//Funcion para mantener el peridod seleccionado al refrescar la pagina
function selected_periodo($periodo=""){
    if(!empty($_POST) AND $_POST['tiempo']==$periodo){
        echo 'selected="selected"';
    }
}

//Formulario para seleccionar el periodo deseado
echo"<form action='index.php?pg=index&type=$type' method='post'>
Periodo <select name='tiempo'>";

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
echo"</select> <input type='submit' name='filtrar' value='Aplicar filtro'/></form>";
echo "</div></div>";
pie();
?>