<?php 
/* 5- (2pt.) TablaVentas.php, puede recibir datos de la venta  como el email, el sabor o nada (traer todos los 
registros) para hacer una busqueda, y retorna una tabla con: (la imagen y todos sus datos ) */  
require_once "venta.php";
Venta::Busqueda($_POST["mail"],$_POST["sabor"]);
//Venta::Busqueda("serg@you.com","crema");

?>