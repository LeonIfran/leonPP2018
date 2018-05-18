<?php 
/* 3- (2 pts.) AltaVenta.php: (por POST)se recibe el email del usuario y el sabor,tipo y cantidad ,si el helado existe en 
Helados.txt, y hay stock guardar en el archivo de texto Venta.txt todos los datos  y descontar la cantidad vendida  */
require_once "helado.php";
class Venta
{
    private $_email;
    private $_sabor;
    private $_tipo;
    private $_cantidad;

    #region setters
    public function getSaborV()
    {
        return $this->_sabor;
    }
    public function getTipoV()
    {
        return $this->_tipo;
    }
    public function getEmail()
    {
        return $this->_email;
    }
    public function getCantidadV()
    {
        return $this->_cantidad;
    }
    #endregion
    public function __construct($mail,$sabor,$tipo,$cant)
    {
        $this->_email = $mail;
        $this->_sabor = $sabor;
        $this->_tipo = $tipo;
        $this->_cantidad = $cant;
    }

    public function ToString()
    {
        return $this->getEmail()." - ".$this->getSaborV()." - ".$this->getTipoV()." - ".$this->getCantidadV();
    }
    public static function guardarArchivo($linea)
    {
        if (!($recurso=fopen("./archivos/ventas.txt","a"))) 
        {
            echo "error guardando el Archivo ventas.txt<br>";
        }
        else
        {
            fwrite($recurso,$linea->ToString()."\r\n");
            echo "<br>guardado con exito<br>";
        }
        fclose($recurso);
    }
    
    public static function guardarVenta($obj)
    {
        $sab = $obj->getSaborV();
        $tip = $obj->getTipoV();
        $can = $obj->getCantidadV();

        $respuesta = Helado::Comprobar($obj->getSaborV(),$obj->getTipoV());
 

        if ($respuesta == "Si hay") 
        {
            $helados = helado::TraerHelados();
            foreach ($helados as $key => $value) 
            {
                if ($value->getSabor()==$obj->getSaborV() && $value->getTipo()==$obj->getTipoV()) 
                {
                    if ($obj->getCantidadV()<=$value->getCantidad()) 
                    {
                        echo "hay suficiente cantidad vender<br>";
                        $resul= $value->getCantidad() - $obj->getCantidadV();
                        $helados[$key]->setCantidad($resul);
                        Venta::guardarArchivo($obj);
                        //break;
                    }
                    else
                    {
                        echo "no hay cantidad para la venta<br>";
                    }
                }
            }
            helado::guardarLista($helados);

        }
    }
}
$miVenta = new Venta("leon@ymail.com","menta","crema",300);
//Venta::guardarVenta($miVenta);
//echo helado::DescontarCantidad("Dulce de leche","crema",50);
?>