<?php 
/* 1- (1 pt.) HeladoCarga.php: (por GET)se ingresa Sabor, precio, Tipo (“crema” o “agua”), cantidad( de kilos). Se 
guardan los datos en en el archivo de texto Helados.txt, tomando el sabor y tipo  como identificador .  */

class Helado
{
    private $_sabor;
    private $_precio;
    private $_tipo;
    private $_cantidad;

    public function __construct($sab, $tip, $pre, $cant)
    {
        if ($tip == "crema" || $tip == "agua") 
        {
            $this->_sabor = $sab;
            $this->_tipo = $tip;
            $this->_precio = $pre;
            $this->_cantidad = $cant;
        }
        else
        {
            echo "error el tipo: $tip no es valido";
            return FALSE;
        }
    }

    #region getters
    public function getSabor()
    {
        return $this->_sabor;
    }
    public function getTipo()
    {
        return $this->_tipo;
    }
    public function getPrecio()
    {
        return $this->_precio;
    }
    public function getCantidad()
    {
        return $this->_cantidad;
    }
    #endregion

    #region setters
    public function setSabor($valor)
    {
        $this->_sabor = $valor;
    }
    public function setTipo($valor)
    {
        $this->_tipo = $valor;
    }
    public function setPrecio($valor)
    {
        $this->_precio = $valor;
    }
    public function setCantidad($valor)
    {
        $this->_cantidad = $valor;
    }
    #endregion setters
    
    #region funciones
    public function ToString()
    {
        return $this->getSabor()." - ".$this->getTipo()." - ".$this->getPrecio()." - ".$this->getCantidad();
    }

    public static function Guardar($obj)
    {
        if (!is_dir("./archivos/"))//verfico que el directorio exista, caso contrario lo creo
        {
            //echo "entro a la condicion";
            mkdir("./archivos/");
        }

        //declaro mis variables
        if (!($recurso=fopen("./archivos/Helados.txt","a"))) 
        {
            echo "error no se pudo guardar<br>";
            break;
        }
        else 
        {
            fwrite($recurso,$obj->ToString()."\r\n");
            fclose($recurso);
        }
    }

    public static function GuardarLista($lista)
    {
        $recurso=fopen("./archivos/Helados.txt","w"); 
        foreach ($lista as $key => $value) 
        {
            if ($value!==NULL) 
            {
                fwrite($recurso,$value->ToString()."\r\n");
            }
            
        }
        fclose($recurso);


    }

    public static function TraerHelados()
    {
        $recurso = fopen("./archivos/Helados.txt","r");
        $arrHelados = array();
        $strHelado;
        $objHelado = NULL;

        while (!feof($recurso))//recorro linea por linea
        {
            $strHelado = trim(fgets($recurso));//hago trim
            $strHelado = explode(" - ",$strHelado);//le quito el delimitador
            
            if ($strHelado[0]!="")//si no esta vacio voy y lo incluyo en el array
            {
                $objHelado = new Helado($strHelado[0],$strHelado[1],$strHelado[2],$strHelado[3]);
                array_push($arrHelados,$objHelado);
            }
        }
        return $arrHelados;
    }

    public static function Comprobar($sabor,$tipo)
    {
        $arrHelados = Helado::TraerHelados();
        $retorno = "No hay ni tipo ni sabor";

        foreach ($arrHelados as $key => $value) 
        {
            if ($value->getTipo() == $tipo) 
            {
                $retorno = "Hay Tipo pero no sabor";
                 if ($value->getSabor() == $sabor) 
                { 
                    $retorno = "Si hay";
                    break;
                }

            }
            else if ($value->getSabor() == $sabor) 
            {
                $retorno = "Hay sabor pero no tipo";
            }

        }
        return $retorno;
    }

    public static function DescontarCantidad($sabor,$tipo,$cantidad)
    {
        $arrHelados = Self::TraerHelados();
        $desconto = FALSE;
        if (Self::Comprobar($sabor,$tipo)=="Si hay") 
        {
            foreach ($arrHelados as $key => $value) 
            {
                if ($value->getSabor()==$sabor && $value->getTipo()==$tipo) 
                {
                    //echo $arrHelados[$key]->getCantidad()."<br>";
                    if ($value->getCantidad()>=$cantidad) 
                    {
                        echo "hay Suficiente stock, Descontando<br>";
                        $arrHelados[$key]->setCantidad(($value->getCantidad()-$cantidad));
                        $desconto = TRUE;
                        //echo "<br>".$arrHelados[$key]->getCantidad()."<br>";
                        break;
                    }
                    else
                    {
                        echo "no hay stock";
                    }
                        //echo "<br>".$arrHelados[$key]->getCantidad()."<br>";
                    
                    

                }
            }
            Self::GuardarLista($arrHelados);
        }
        return $desconto;

    }
/* 6- (2pts.) HeladoModificacion.php: (por POST)se ingresarán todos los valores necesarios (incluida una imagen) 
para realizar los cambios en los datos de cualquier helado. La identificación de un helado es por medio de su 
sabor y por el tipo. */ 
    public static function ModificarHelado($sab,$tip,$pre,$cant)
    {
        
    }
    #endregion
}
//$mihelado = new Helado("Frutilla","crema",30,300);
//echo $mihelado->ToString();
//Helado::Guardar($mihelado);
//echo var_dump(Helado::TraerHelados());
//echo Helado::Comprobar("menta","crema");
?>