<?php
echo"
<html>
<head>
<link rel='icon' href='recursos/imagenes/icon.png'>
<title>El tiempo</title>
<style>

body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 0px;
    padding: 0px;
    color: white;
    background-color: #181a1b;
}

ul {
  list-style-type: none;
  overflow: hidden;
  position: absolute; top: 130px;
}

.tit{
    background-image: url('recursos/imagenes/bg.jpg');
    background-size: cover;
    height: 220px;
}
.title{
  padding: 10;
  position: absolute; top: 65px; left: 38px;
}


li {
  float: left;
}

li a {
  opacity: 1;
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  margin: 5px;
}

li a:hover:not(.active) {
  background-color: #111;
  border-radius: 15px;
}
.index{
  display: flex;
}
.bod {
  margin: 20;
  margin-bottom: 50px;
    
}

.active {
  background-color: #111;
  border-radius: 15px;
}

table {
  border-collapse: collapse;
}

th, td {
  text-align: center;
  padding: 10px;
}

tr:nth-child(even){
  background-color: #111;
}
tr:nth-child(odd){
  background-color: #2A2A2A;
}


th {
  background-color: #0099cc;
}

th:first-of-type {
  border-top-left-radius: 10px;
  border-bottom-left-radius: 10px;
}
th:last-of-type {
  border-top-right-radius: 10px;
  border-bottom-right-radius: 10px;
}

td:first-of-type {
  border-top-left-radius: 10px;
  border-bottom-left-radius: 10px;
}
td:last-of-type {
  border-top-right-radius: 10px;
  border-bottom-right-radius: 10px;
}

div.left {
  position: relative;
  top: 0;
  left: 0;

}
div.right {
  position: relative;
  top: 0;
  left: 0;
  margin-left: 50px;
}

a.cat{
  background-color: #5e5e5e;
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  margin-left: 30px;
  border-radius: 5px;
}
a.cat_main{
  background-color: #0099cc;
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  
  border-radius: 5px;
}

footer {
  text-align: center;
  padding: 10px;
  background-color: #111;
  position:fixed;
  bottom:0;
  width: 100%;
}

.big{
  font-size:60px;
  margin-bottom: 0px;
  margin-top: 0px;
}

.medium{
  font-size:40px;
  margin-bottom: 15px;
  margin-top: 0px;
}

.nomargin{
  margin-bottom: 0px;
}

.small{
  font-size:15px;
  margin-bottom: 0px;
  margin-top: 0px;
}

</style>
</head>
<body>

<div class='tit'>
<h1 class='title'>EL TIEMPO</h1>
<ul>";
if(isset($_GET['pg'])){
  $pg=$_GET['pg'];
}else{
  $pg='index';
}

  echo"
  <li><a ";
  if($pg=="index"){
    echo"class='active'";
  }
  echo " href='index.php?pg=index'>Pagina principal</a></li>";

  echo"
  <li><a ";
  if($pg=="registros"){
    echo"class='active'";
  }
  echo " href='registros.php?pg=registros'>Registros y gestion</a></li>";

 
  echo"
  <li><a ";
  if($pg=="estaciones"){
    echo"class='active'";
  }
  echo " href='estaciones.php?pg=estaciones'>Estaciones y gestion</a></li>";

  echo"
  <li><a ";
  if($pg=="info"){
    echo"class='active'";
  }
  echo " href='info.php?pg=info'>Informacion del proyecto</a></li>

</ul>
</div>
<div class='bod'>
";

function pie(){
  echo"
  </div>
  <footer>
  Pablo Anton Lafuente 2 ASIR
  </footer>
  <body>
  ";
}
?>