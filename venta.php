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

        if (Helado::DescontarCantidad($sab,$tip,$can)==TRUE) 
        {
            Venta::guardarArchivo($obj);
            return TRUE;
        }
    }
/* 4- (2pts.) AltaVentaConImagen.php: con imagen , guardando la imagen con el sabor y fecha de la venta  en la 
carpeta /ImagenesDeLaVenta.  */
    public static function guardarVentaImagen($obj)
    {
        $extension = pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION);
        $fName = $obj->getSaborV().date("_Ymd_His").".".$extension;
        if (Self::guardarVenta($obj)==TRUE) 
        {
            if (!move_uploaded_file($_FILES["imagen"]["tmp_name"],"./ImagenesDeLaVenta/".$fName)) 
            {
                echo "error al guardar el archivo<br>";
            }
            else
            {
                echo "Archivo guardado como $fName";
            }
        }
    }
    #region Punto 5
    public static function TraerVentas()
    {
        $arrVentas=array();
        $strAux;
        $ventaAux;
        $recurso = fopen("./archivos/ventas.txt","r");
        
        if ($recurso!=FALSE) 
        {
            while (!feof($recurso)) 
            {
                $strAux = trim(fgets($recurso));
                $strAux = explode(" - ",$strAux);
                if ($strAux[0]!='') 
                {
                    $ventaAux = $strAux;
                    //$ventaAux = new Venta($strAux[0],$strAux[1],$strAux[2],$strAux[3]);
                    array_push($arrVentas,$ventaAux);
                }
            }
        }
        return $arrVentas;
    }

    public static function Busqueda($mail=NULL,$tipo=NULL)
    {
        $arrVentas = Self::TraerVentas();
        $arrMostrar = array();
        //echo "$mail $tipo<br>";
        if ($mail!=NULL && $tipo!=NULL)
        {//si ninguno de los dos es nulo voy a traer las entradas con ambas coincidencias
            foreach ($arrVentas as $value) 
            {
                if (array_search($mail,$value)!==FALSE && array_search($tipo,$value)!==FALSE) 
                {
                    array_push($arrMostrar,$value);
                }
            }
        }
        elseif ($mail!=NULL || $tipo!=NULL) 
        {//si alguno de los dos es nulo voy a traer las entradas con alguna coincidencias            
            foreach ($arrVentas as $value) 
            {
                if (array_search($mail,$value)!==FALSE || array_search($tipo,$value)!==FALSE) 
                {
                    array_push($arrMostrar,$value);
                }
            }
        }
        else 
        {
            $arrMostrar = $arrVentas;
        }
        //return $arrMostrar;
        Self::CrearTabla($arrMostrar);
    }

    public static function CrearTabla($arrVentas)
    {
        $img;
        $tabla = "<table border=1>
                    <tbody>
                        <thead>
                            <th>Mail</th>
                            <th>Sabor</th>
                            <th>Tipo</th>
                            <th>Imagen</th>
                        </thead>";
        foreach ($arrVentas as $value) 
        {

            $img = glob("./ImagenesDeLaVenta/$value[1]_*.*");//busco la imagen usando el titulo como base
            //echo $img[0]."<br>";
            $tabla=$tabla."<tr>
            <td>$value[0]</td>
            <td>$value[1]</td>
            <td>$value[2]</td>
            <td><img src='{$img[0]}' width='100px' height='100px'></td>
            </tr>";
        }
        $tabla=$tabla."</tbody></table>";
        echo $tabla;
    }
    
    #endregion
}

//$miVenta = new Venta("leon@ymail.com","Frutilla","crema",100);
//Venta::guardarVenta($miVenta);
//echo helado::DescontarCantidad("Dulce de leche","crema",50);
//Venta::guardarVenta($miVenta);
//echo var_dump(Venta::TraerVentas());
//echo var_dump(Venta::Busqueda("serg@you.com","crema"));
Venta::Busqueda("serg@you.com","crema");
?>