<?php 
/* 2- (1pt.) ConsultarHelado.php: (por POST)Se ingresa Sabor,Tipo, si coincide con algún registro del archivo 
Helados.txt,  retornar “Si Hay”. De lo contrario informar si no existe el tipo o el sabor.   */
require_once "helado.php";
echo Helado::Comprobar($_POST["sabor"],$_POST["tipo"]);
?>