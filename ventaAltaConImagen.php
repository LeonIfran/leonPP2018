<?php 
require_once "venta.php";

//("leon@ymail.com","Frutilla","crema",100);
$miventa= new Venta($_POST["mail"],$_POST["sabor"],$_POST["tipo"],$_POST["cantidad"]);
Venta::guardarVentaImagen($miventa);
?>