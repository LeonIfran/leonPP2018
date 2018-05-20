<?php 
/* 3- (2 pts.) AltaVenta.php: (por POST)se recibe el email del usuario y el sabor,tipo y cantidad ,si el helado existe en 
Helados.txt, y hay stock guardar en el archivo de texto Venta.txt todos los datos  y descontar la cantidad vendida  */
require_once "Venta.php";
$miventa= new Venta($_POST["mail"],$_POST["sabor"],$_POST["tipo"],$_POST["cantidad"]);
//venta::guardarVentaImagen($miventa);
Venta::guardarVenta($miventa);
?>