<?php 
require_once "Helado.php";
Helado::ModificarHelado($_POST["sabor"],$_POST["tipo"],$_POST["precio"],$_POST["cantidad"]);

?>