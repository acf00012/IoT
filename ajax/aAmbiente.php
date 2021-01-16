<?php
/**
 * Created by PhpStorm.
 * User: acf_0
 * Date: 04/01/2021
 * Time: 08:09 AM
 */
ob_start();
session_start();
date_default_timezone_set('America/Mexico_City');

require_once "../modelos/mAmbiente.php";
$ambiente=new mAmbiente();

$temperatura=isset($_GET["temperatura"])? limpiarCadena($_GET["temperatura"]):"";
$humedad=isset($_GET["humedad"])? limpiarCadena($_GET["humedad"]):"";
$error=isset($_GET["error"])? limpiarCadena($_GET["error"]):"";

switch ($_GET["op"]){

    case 'guardar':
        $sw = true;
        $ambiente->iniciarTransaccion() or $sw = false;
        if ($temperatura>0 and $humedad>0){
            $rspta=$ambiente->insertar($temperatura,$humedad) or $sw = false;
        } else {
            $rspta=$ambiente->error($error) or $sw = false;
        }
        $ambiente->terminarTransaccion($sw);
        echo $sw ? "datos registrados" : "error al registrar los datos";
        break;
    case 'guardarMonitor':
        $sw = true;
        $ambiente->iniciarTransaccion() or $sw = false;
        if ($temperatura>0 and $humedad>0){
            $rspta=$ambiente->insertarMonitor($temperatura,$humedad) or $sw = false;
        }
        $ambiente->terminarTransaccion($sw);
        echo $sw ? "datos registrados" : "error al registrar los datos";
        break;


    case 'horas':
        $fecha = date('Y-m-d');
        //$datos = array("00:00:00","01:00:00","02:00:00","03:00:00","04:00:00","05:00:00","06:00:00","07:00:00","08:00:00","09:00:00","10:00:00","11:00:00"
        //,"12:00:00","13:00:00","14:00:00","15:00:00","16:00:00","17:00:00","18:00:00","19:00:00","20:00:00","21:00:00","22:00:00","23:00:00");
        $res = $ambiente->hora($fecha);
        $datos= Array();

        for ($i = 0; $reg=$res->fetch_object(); $i++){
            $datos[$i]=$reg->hora;
        }
        echo json_encode($datos);

        break;
    case 'temperatura':
        $fecha = date('Y-m-d');
        //$datos = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $res = $ambiente->temperatura($fecha);
        $datos= Array();
        for ($i = 0; $reg=$res->fetch_object(); $i++){
            $datos[$i]=$reg->temperatura;
        }
        echo json_encode($datos);

        break;
    case 'humedad':
        $fecha = date('Y-m-d');
        //$datos = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $res = $ambiente->humedad($fecha);
        $datos= Array();
        for ($i = 0; $reg=$res->fetch_object(); $i++){
            $datos[$i]=$reg->humedad;
        }
        echo json_encode($datos);

        break;
    case 'horasMonitor':
        $fecha = date('Y-m-d');
        //$datos = array("00:00:00","01:00:00","02:00:00","03:00:00","04:00:00","05:00:00","06:00:00","07:00:00","08:00:00","09:00:00","10:00:00","11:00:00"
        //,"12:00:00","13:00:00","14:00:00","15:00:00","16:00:00","17:00:00","18:00:00","19:00:00","20:00:00","21:00:00","22:00:00","23:00:00");
        $res = $ambiente->horaMonitor($fecha);
        $datos= Array();

        for ($i = 0; $reg=$res->fetch_object(); $i++){
            $datos[$i]=$reg->hora;
            $_SESSION['hora'] = $reg->hora;
        }
        echo json_encode($datos);

        break;
    case 'temperaturaMonitor':
        $fecha = date('Y-m-d');
        //$datos = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $res = $ambiente->temperaturaMonitor($fecha);
        $datos= Array();
        for ($i = 0; $reg=$res->fetch_object(); $i++){
            $datos[$i]=$reg->temperatura;
            $_SESSION['temperatura'] = $reg->temperatura;
        }
        echo json_encode($datos);

        break;
    case 'humedadMonitor':
        $fecha = date('Y-m-d');
        //$datos = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $res = $ambiente->humedadMonitor($fecha);
        $datos= Array();
        for ($i = 0; $reg=$res->fetch_object(); $i++){
            $datos[$i]=$reg->humedad;
            $_SESSION['humedad'] = $reg->humedad;
        }
        echo json_encode($datos);
        break;
    case 'consultarValores':
        $fecha = date('Y-m-d');
        echo '{"fecha":"'.$fecha.' '.@$_SESSION['hora'].'","temperatura":"'.@$_SESSION['temperatura'].' °C","humedad":"'.@$_SESSION['humedad'].' %"}';
        break;

}


?>
