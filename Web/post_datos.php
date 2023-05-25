<?php

//Se incluye el archivo PHP con la conexion al a base de datos      
include("recursos/php/conexion.php");

//Primero se comprueba si se esta haciendo un envio mediante POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){   

//Se leen los datos enviados por el sensor, el ID, la temperatura, humedad y el codigo de seguridad
$temp=$_POST['temp'];       
$hum=$_POST['hum'];
$id=$_POST['id'];
$codigo_post=$_POST['codigo'];

//Se saca de la base de datos el codigo hasheado que corresponde al sernsor para compararlo
$sql = "SELECT * FROM estaciones  WHERE id = '$id'";    
$cod=$bbdd->query($sql)->fetchColumn(3);

//Se verifica que el codigo de seguridad enviado es correcto comparandolo con el de la base de datos
if (password_verify($codigo_post, $cod)){    

    //Se hace el insert de los datos
    echo "Codigo correcto";
    $sql="INSERT INTO registros (ID_sensor,Temperatura,Humedad) VALUES ('$id','$temp','$hum')";     
    $bbdd->query($sql);
    echo "\r\nInsert correcto";
    
//Si el codigo no es correcto se muestra un error
}else{
    echo "CODIGO INCORRECTO $cod";  
}

//Si se accede a la pagina sin envio de datos POST se muestra un error
}else{      
    echo "<h2><br>Esta no es una pagina para el usuario, es una pagina interna para el envio automatizado de datos mediante POST</h2><br><a href='index.php'>Pagina principal</a>";
}
?>