<?php 
/* 1- (1 pt.) HeladoCarga.php: (por GET)se ingresa Sabor, precio, Tipo (“crema” o “agua”), cantidad( de kilos). Se 
guardan los datos en en el archivo de texto Helados.txt, tomando el sabor y tipo  como identificador .  */
require_once "Helado.php";
//$mihelado = new Helado("Frutilla","crema",30,300);
$mihelado = new Helado($_GET["Sabor"],$_GET["Tipo"],$_GET["Precio"],$_GET["Cantidad"]);
Helado::Guardar($mihelado);
?>