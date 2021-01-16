<?php
/**
 * Created by PhpStorm.
 * User: acf_0
 * Date: 06/03/2020
 * Time: 08:48 AM
 */
ob_start();
session_start();

require_once "../modelos/mUsuarios.php";
$usuarios=new mUsuarios();

$clave=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$nickname=isset($_POST["nickname"])? limpiarCadena($_POST["nickname"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$contrasenia=isset($_POST["contrasenia"])? limpiarCadena($_POST["contrasenia"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$match=isset($_POST["match"])? limpiarCadena($_POST["match"]):"";
$control=isset($_POST["control"])? limpiarCadena($_POST["control"]):"";

switch ($_GET["op"]){


    case 'guardaryeditar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["fotoActual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../vistas/files/" . $imagen);
            }
        }

        if (empty($clave)){
            $sw = true;
            $usuarios->iniciarTransaccion() or $sw = false;
            $rspta=$usuarios->insertar($nombre,$nickname,$email,$contrasenia,$imagen,$_GET["tipo"],$control) or $sw = false;
            switch ($_GET["caso"]) {
                case 3:
                    $rspta=$usuarios->insertarMatchPadre($rspta,$match) or $sw = false;
                    break;
            }
            $usuarios->terminarTransaccion($sw);
            echo $sw ? "Usuario registrado" : "Usuario no se pudo registrar";
        }
        else {
            $sw = true;
            $usuarios->iniciarTransaccion() or $sw = false;
            $rspta=$usuarios->editar($clave,$nombre,$nickname,$email,$contrasenia,$imagen,$control) or $sw = false;
            switch ($_GET["caso"]) {
                case 3:
                    $rspta=$usuarios->editarMatchPadre($clave,$match) or $sw = false;
                    break;
            }
            $usuarios->terminarTransaccion($sw);
            echo $sw ? "Usuario actualizada" : "Usuario no se pudo actualizar";
        }
        break;

    case 'desactivar':
        $rspta=$usuarios->desactivar($clave);
        echo $rspta ? "Usuario Desactivada" : "Usuario no se puedo desactivar";
        break;

    case 'activar':
        $rspta=$usuarios->activar($clave);
        echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
        break;

    case 'mostrar':
        $rspta=$usuarios->mostrar($clave);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;


    case 'listarUsuario':
        switch ($_GET["caso"]) {
            case 0:
                $rspta=$usuarios->listarAdm();
                break;
            case 1:
                $rspta=$usuarios->listarMae();
                break;
            case 2:
                $rspta=$usuarios->listarPad();
                break;
            case 3:
                $rspta=$usuarios->listarAlu();
                break;
        }
        $data= Array();
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->estado)?
                    '<button class="btn btn-success btn"  onclick="registro('.$reg->numero_c.')"><i class="fas fa-eye fa-sm text-white-50"></i></button> &nbsp'.
                    '<button class="btn btn-warning btn"  onclick="mostrar('.$reg->clave.')"><i class="fas fa-edit fa-sm text-white-50"></i></button> &nbsp'.
                    '<button class="btn btn-danger btn"  onclick="desactivar('.$reg->clave.')"><i class="fas fa-window-close fa-sm text-white-50"></i></button>':
                    '<button class="btn btn-success btn"  onclick="registro('.$reg->numero_c.')"><i class="fas fa-eye fa-sm text-white-50"></i></button> &nbsp'.
                    '<button class="btn btn-warning btn"  onclick="mostrar('.$reg->clave.')"><i class="fas fa-edit fa-sm text-white-50"></i></button> &nbsp'.
                    '<button class="btn btn-primary btn"  onclick="activar('.$reg->clave.')"><i class="fas fa-check fa-sm text-white-50"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->email,
                "3"=>'<img alt="" src="../vistas/files/'.$reg->imagen.'" class="img-profile rounded-circle" width="100px" height="100px" id="fotoActualMuestra">',
                "4"=>($reg->estado)?'<span class="bg-success"><small style="color:#ffffff"><b>Activado</b></small></span>':
                    '<span class="bg-danger"><small style="color:#ffffff"><b>Desactivado</b></small></span>'
            );
        }
        $results = array(
            "sEcho"=>1,
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data);
        echo json_encode($results);

        break;

    case 'listarPadre':

        $rspta=$usuarios->listarPadre();
        $data= Array();
        //<th>Nombre</th>
        // <th>Email</th>
        // <th>Foto</th>
        // <th>Estado</th>
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-success btn" type="button" onclick="agregarJoin('.$reg->clave.')"><i class="fas fa-check-double fa-sm text-white-50"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->email,
                "3"=>$reg->numero_c,
                "4"=>'<img alt="" src="../vistas/files/'.$reg->imagen.'" class="img-profile rounded-circle" width="100px" height="100px" id="fotoActualMuestra">'
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;

    case 'salir' :
        session_unset();
        session_destroy();
        break;

    case 'verificar':
        $correo = $_POST['email'];
        $contrasenia = $_POST['password'];


        $rspta = $usuarios->verificar($correo, $contrasenia);
        $fetch = $rspta->fetch_object();

        if (isset($fetch)){
            $_SESSION['clave'] = $fetch->clave;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['imagen'] = $fetch->imagen;
            $_SESSION['tipo'] = $fetch->tipo;

        }

        if ($_SESSION['tipo'] == "Padre") {
            require_once "../modelos/mConsulta.php";
            $consulta=new mConsulta();
            $alumno=$consulta->ConsultarNumeroAlumno($_SESSION['clave']);
            $_SESSION['numeroControlAlumno'] = $alumno->numero_c;
            $_SESSION['nombreAlumno'] = $alumno->nombre;
        }


        echo json_encode($fetch);
        break;

    case 'obtenerNombreMatch':
        $rspta=$usuarios->obtenerNombreMatch($clave);
        echo $rspta->nombre;
        break;

    case 'mostrarNombrePadre':
        $rspta=$usuarios->mostrarNombrePadre($clave);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    case 'listarEntradasSalidas':
        $rspta=$usuarios->listarEntradaSalida($_GET["clave"]);

        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->ingreso,
                "1"=>$reg->egreso
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;
}

?>
