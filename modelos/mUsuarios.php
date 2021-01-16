<?php
/**
 * Created by PhpStorm.
 * User: acf_0
 * Date: 06/03/2020
 * Time: 08:09 AM
 */

require "../config/conexion.php";

Class mUsuarios
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    public function iniciarTransaccion()
    {
        $sql="START TRANSACTION";
        return ejecutarConsulta($sql);
    }
    public function terminarTransaccion($valor)
    {
        if ($valor){
            $sql="COMMIT";
        }
        else {
            $sql="ROLLBACK";
        }
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para insertar registro
    public function insertar($nombre,$nickname,$email,$contrasenia,$imagen,$tipo,$control)
    {

        $sql="INSERT INTO usuarios (nombre,nickname,email,contrasenia,tipo,imagen,estado,fecha_c,numero_c)
		VALUES ('$nombre','$nickname','$email','$contrasenia','$tipo','$imagen',true, CURRENT_TIME(),$control)";
        //return ejecutarConsulta($sql);
        return ejecutarConsulta_retornarID($sql);
    }

    public function editar($clave,$nombre,$nickname,$email,$contrasenia,$imagen,$control)
    {

        $sql="UPDATE usuarios SET nombre = '$nombre', nickname = '$nickname', email = '$email', contrasenia = '$contrasenia', imagen = '$imagen', numero_c = '$control' WHERE clave = '$clave'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para desactivar categorías
    public function desactivar($clave)
    {
        $sql="UPDATE usuarios SET estado='0' WHERE clave='$clave'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para activar categorías
    public function activar($clave)
    {
        $sql="UPDATE usuarios SET estado='1' WHERE clave='$clave'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($clave)
    {
        $sql="SELECT * FROM usuarios WHERE clave='$clave'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para listar los registros

    public function listarAdm()
    {
        $sql="SELECT * FROM usuarios where tipo = 'administrador'";
        return ejecutarConsulta($sql);
    }
    public function listarPad()
    {
        $sql="SELECT * FROM usuarios where tipo = 'padre'";
        return ejecutarConsulta($sql);
    }
    public function listarAlu()
    {
        $sql="SELECT * FROM usuarios where tipo = 'alumno'";
        return ejecutarConsulta($sql);
    }
    public function listarMae()
    {
        $sql="SELECT * FROM usuarios where tipo = 'maestro'";
        return ejecutarConsulta($sql);
    }
    public function verificar ($correo,$contrasenia) {
        $sql = "select * from usuarios where email='$correo' and contrasenia = '$contrasenia' and estado = '1'";
        return ejecutarConsulta($sql);
    }

    public function listarPadre() //Listado especial para mostrar el nombre de la institucion a la cual pertenece este psicologo
    {
        $sql="SELECT * FROM usuarios 
            where tipo = 'padre' ";
        return ejecutarConsulta($sql);
    }
    public function obtenerNombreMatch ($clave) {
        $sql = "select nombre from usuarios where clave = '$clave'";
        return ejecutarConsultaRegistros($sql);
    }

    public function insertarMatchPadre($clave,$claveMatch)
    {
        $sql="INSERT INTO padres_alumnos (claveAlumno, clavePadre)
		VALUES ('$clave','$claveMatch')";
        return ejecutarConsulta($sql);
    }

    public function editarMatchPadre($clave,$claveMatch)
    {
        $sql="UPDATE padres_alumnos SET clavePadre = '$claveMatch' WHERE claveAlumno = '$clave'";
        return ejecutarConsulta($sql);
    }
    public function mostrarNombrePadre($clave)
    {
        $sql="select ip.clavePadre, u.nombre  from usuarios u
        inner join padres_alumnos ip on u.clave = ip.clavePadre
        where claveAlumno = '$clave'";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function listarEntradaSalida($clave) //Listado especial para mostrar el nombre de la institucion a la cual pertenece este psicologo
    {
        $sql="SELECT * FROM registro 
            where numero_c = '$clave' ";
        return ejecutarConsulta($sql);
    }
}

?>
