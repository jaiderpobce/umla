<?php

class Funciones
{

    public function __construct()
    {
        // echo "<p>Class X</p>";
        //$this->db = new EasyPDO('mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset=UTF8', DB_USER, DB_PASSWORD);
    }
    static function convertiraMS($tiempo)
    {
        $porcion1 = explode(":", $tiempo);
        $minutos = $porcion1[0];
        $porcion2 = explode(".", $porcion1[1]);
        $segundos = $porcion2[0];
        $milisegundos = ($porcion2[1] * 10);

        $tiempoMS = ($minutos * 60 * 1000) + ($segundos * 1000) + $milisegundos;
        return $tiempoMS;
    }

    static function convertiraSEG($tiempo)
    {

        $segundos = $tiempo / 1000;
        //verificamos residuo para ver si llevará decimales
        $Ms = (($tiempo % 1000) / 10);
        //$segundos = $segundos - $Ms;

        $segundos1 = floor($segundos);
        //$segundos1

        if ($segundos1 >= 60) {
            $minutos1 = $segundos1 / 60;
            //verificamos residuo para ver si llevará decimales
            $Seg = $segundos1 % 60;
            $minutos = floor($minutos1);
        } else {
            $Seg = $segundos1;
            $minutos = "00";
        }


        $tiempoSG = str_pad($minutos, 2, "0", STR_PAD_LEFT) . ":" . str_pad($Seg, 2, "0", STR_PAD_LEFT) . "." . str_pad($Ms, 2, "0", STR_PAD_LEFT);


        return $tiempoSG;
        // return $segundos." ".$Ms

    }

    static function convertiraSEGRed($tiempo, $tipo)
    {

        $segundos = $tiempo / 1000;
        //verificamos residuo para ver si llevará decimales
        $Ms = (($tiempo % 1000) / 10);
        //$segundos = $segundos - $Ms;

        $segundos1 = floor($segundos);
        //$segundos1

        if ($segundos1 >= 60) {
            $minutos1 = $segundos1 / 60;
            //verificamos residuo para ver si llevará decimales
            $Seg = $segundos1 % 60;
            $minutos = floor($minutos1);
        } else {
            $Seg = $segundos1;
            $minutos = "00";
        }

        if ($tipo == 'max') {
            if ($Ms > 0) {
                $Ms = 0;
                if ($Seg == 59) {
                    $Seg = 0;
                    $minutos = $minutos + 1;
                } else {
                    $Seg = $Seg + 1;
                }
                $Seg = $Seg + 1;
            }
        }

        if ($tipo == 'min') {
            if ($Ms > 0) {
                $Ms = 0;
                if ($Seg == 0) {
                    $Seg = 59;
                    $minutos = $minutos - 1;
                } else {
                    $Seg = $Seg - 1;
                }
                $Seg = $Seg - 1;
            }
        }



        $tiempoSG = str_pad($minutos, 2, "0", STR_PAD_LEFT) . ":" . str_pad($Seg, 2, "0", STR_PAD_LEFT) . "." . str_pad($Ms, 2, "0", STR_PAD_LEFT);


        return $tiempoSG;
        // return $segundos." ".$Ms

    }


    static function convertiraSEGsinMS($tiempo)
    {

        $segundos = $tiempo;
        //verificamos residuo para ver si llevará decimales
        
    $Ms = round(($tiempo - floor($segundos)),2);

    $Ms = $Ms * 100;


        //$segundos = $segundos - $Ms;

        $segundos1 = floor($segundos);
        //$segundos1

        if ($segundos1 >= 60) {
            $minutos1 = $segundos1 / 60;
            //verificamos residuo para ver si llevará decimales
            $Seg = $segundos1 % 60;
            $minutos = floor($minutos1);
        } else {
            $Seg = $segundos1;
            $minutos = "00";
        }


        $tiempoSG = str_pad($minutos, 2, "0", STR_PAD_LEFT) . ":" . str_pad($Seg, 2, "0", STR_PAD_LEFT) . "." . str_pad($Ms, 2, "0", STR_PAD_LEFT);


        return $tiempoSG;
        // return $segundos." ".$Ms

    }


    static function diasSemana($dia)
    {
        switch ($dia) {
            case 0:
                return "Domingo";
                break;
            case 1:
                echo "Lunes";
                break;
            case 2:
                echo "Martes";
                break;
            case 3:
                echo "Miércoles";
                break;
            case 4:
                echo "Jueves";
                break;
            case 5:
                echo "Viernes";
                break;
            case 6:
                echo "Sábado";
                break;
        }
    }


    static function mostrarMes($mes, $tipo='L')
    {

        $mes1 = array();
        switch ($mes) {
            case 1:
                $mes1['L'] = "Enero";
                $mes1['C'] = "ene";
                break;

            case 2:
                $mes1['L'] = "Febrero";
                $mes1['C'] = "feb";
                break;
            case 3:
                $mes1['L'] = "Marzo";
                $mes1['C'] = "mar";
                break;
            case 4:
                $mes1['L'] = "Abril";
                $mes1['C'] = "abr";
                break;
            case 5:
                $mes1['L'] = "Mayo";
                $mes1['C'] = "may";
                break;
            case 6:
                $mes1['L'] = "Junio";
                $mes1['C'] = "jun";
                break;
            case 7:
                $mes1['L'] = "Julio";
                $mes1['C'] = "ju";
                break;
            case 8:
                $mes1['L'] = "Agosto";
                $mes1['C'] = "ago";
                break;
            case 9:
                $mes1['L'] = "Septiembre";
                $mes1['C'] = "sep";
                break;
            case 10:
                $mes1['L'] = "Octubre";
                $mes1['C'] = "oct";
                break;
            case 11:
                $mes1['L'] = "Noviembre";
                $mes1['C'] = "nov";
                break;
            case 12:
                $mes1['L'] = "Diciembre";
                $mes1['C'] = "dic";
                break;
        }

        if ($tipo == 'C') {
            return $mes1['C'];

        } else {
            return $mes1['L'];

        }

        
    }


    static function fechaMostrar($fecha, $hora = 0)
    {
        $fecha1 = strtotime($fecha);
        if ($hora == 1) {
            return date('d-m-Y h:i:s', $fecha1);
        } else {
            return date('d-m-Y', $fecha1);
        }
    }

    static function fechaEngToDB($fecha)
    {

        $lafecha =  explode("/", $fecha);

        return $lafecha[2] . "/" . $lafecha[0] . "/" . $lafecha[1];
    }

    static function getPiscinaMeet($piscina)
    {
        if ($piscina == "25") {
            $piscina_meet = "SO";
            $piscina_meetP = "S";
        } else if ($piscina == "50") {
            $piscina_meet = "LO";
            $piscina_meetP = "L";
        } else if ($piscina == "100") {
            $piscina_meet = "SLY";
        } else if ($piscina == "22") {
            $piscina_meet = "YO";
            $piscina_meetP = "Y";
        }

        $piscina_meetA['comp'] = $piscina_meet;
        $piscina_meetA['prue'] = $piscina_meetP;

        return $piscina_meetA;
    }

    static function getPiscina($piscina_meet)
    {
        if ($piscina_meet == "SO" || $piscina_meet == "S") {
            $piscina = "25";
        } else if ($piscina_meet == "LO" || $piscina_meet == "L") {
            $piscina = "50";
        } else if ($piscina_meet == "SLY") {
            $piscina = "100";
        } else if ($piscina_meet == "YO" || $piscina_meet == "Y") {
            $piscina = "22";
        }
        return $piscina;
    }

    static function CalculateHy3Checksum($hy3)
    {
        define('WPST_HY3_CHECKSUM_RECORD', '%-128.128s%01.1d%01.1d');
        // Ensure the string is 128 bytes in length and padded with whitespace

        $hy3 = str_pad($hy3, 128, ' ', STR_PAD_RIGHT);

        $sumEvn = 0;
        $sumOdd = 0;

        //  Loop through 128 characters, two at a time

        // Ajuste local: compatibilidad PHP 7.4+, reemplazando offsets con llaves por corchetes.
        for ($i = 0; $i < 64; $i++) {
            $sumEvn = $sumEvn + ord($hy3[(2 * $i)]);
            $sumOdd = $sumOdd + (2 * ord($hy3[(2 * $i) + 1]));
        }

        //  Calculate the checksum and save the ones and tens digits

        $chksum = (floor(($sumEvn + $sumOdd) / 21)) + 205;
        $ones = $chksum / 1 % 10;
        $tens = $chksum / 10 % 10;

        $valores = sprintf(WPST_HY3_CHECKSUM_RECORD, $hy3, $ones, $tens);
        return iconv(mb_detect_encoding($valores), 'Windows-1252//TRANSLIT', $valores);
    }

    static function CalculateCl2Checksum($cl2)
    {


        // Ensure the string is 128 bytes in length and padded with whitespace

        $cl2 = str_pad($cl2, 156, ' ', STR_PAD_RIGHT);

        $sumEvn = 0;
        $sumOdd = 0;

        //  Loop through 128 characters, two at a time

        // Ajuste local: compatibilidad PHP 7.4+, reemplazando offsets con llaves por corchetes.
        for ($i = 0; $i < 156; $i++) {
            $sumEvn = $sumEvn + ord($cl2[$i]);
            //$sumOdd = $sumOdd + (2 * ord($hy3[(2 * $i) +1 ])) ;
        }

        //  Calculate the checksum and save the ones and tens digits

        $division = floor($sumEvn / 19);
        $suma = $division + 211;


        $ones = $suma / 1 % 10;
        $tens = $suma / 10 % 10;


        return "N" . $ones . $tens;

        /*Divide that result by 19 to get 413. Then add 211 to that result to
    get 624.
    
    Again we take the last two characters backward. In this case the
    result is: 42.*/

        /*$chksum = (floor(($sumEvn + $sumOdd)/21)) + 205 ;
            $ones = $chksum/1 % 10 ;
            $tens = $chksum/10 % 10 ;
    
            return sprintf(WPST_HY3_CHECKSUM_RECORD, $hy3, $ones, $tens) ;*/
    }

    static function obtener_edad_segun_fecha($fecha_nacimiento, $fecha_calc)
    {
        $nacimiento = new DateTime($fecha_nacimiento);
        $ahora = new DateTime($fecha_calc);
        $diferencia = $ahora->diff($nacimiento);
        return $diferencia->format("%y");
    }

    static function numeroVacio($valor) {
        if (empty($valor)) {
            return 0;
        } else {
            return $valor;
        }

    }

    static function encodeUTF8($valor){

        return utf8_encode($valor);

    }

    static function mostrarPruebaMeet ($prueba) {
        $distancia = intval(preg_replace('/[^0-9]+/', '', $prueba), 10);
        $estilo = preg_replace('/[^a-z]/iu', '', $prueba);

        if ($estilo == 'A') {
            $estiloN = "Libre";
        } else if ($estilo == 'B') {
            $estiloN = "Espalda";
        } else if ($estilo == 'C') {
            $estiloN = "Pecho";
        } else if ($estilo == 'D') {
            $estiloN = "Mariposa";
        } else if ($estilo == 'E') {
            $estiloN = "Combinado";
        }

        $salida = $distancia ." ". $estiloN;

        return $salida;


    }
    static function mostrarGenero ($genero) {
        
        if ($genero == 'F' || $genero == 1) {
            $estiloN = "Femenino";
        } else if ($genero == 'M' || $genero == 2) {
            $estiloN = "Masculino";
        } 

        return $estiloN;


    }

    static function  ordenarArray(&$arrIni, $col, $order = SORT_ASC)
    {
        $arrAux = array();
        foreach ($arrIni as $key=> $row)
        {
            $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
            $arrAux[$key] = strtolower($arrAux[$key]);
        }
        array_multisort($arrAux, $order, $arrIni);
    }
}
