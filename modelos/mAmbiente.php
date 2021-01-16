<?php

/**
 * Created by PhpStorm.
 * User: acf_0
 * Date: 04/01/2021
 * Time: 08:09 AM
 */

require "../config/conexion.php";

class mAmbiente
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
    public function insertar($temperatura,$humedad)
    {

        $sql="INSERT INTO ambiente (temperatura,humedad,fechahora)
		VALUES ('$temperatura','$humedad',CURRENT_TIME())";
        //return ejecutarConsulta($sql);
        return ejecutarConsulta($sql);
    }
    public function insertarMonitor($temperatura,$humedad)
    {

        $sql="INSERT INTO temporal (temperatura,humedad,fechahora)
		VALUES ('$temperatura','$humedad',CURRENT_TIME())";
        //return ejecutarConsulta($sql);
        return ejecutarConsulta($sql);
    }
    public function error($error)
    {

        $sql="INSERT INTO error (error,fechahora)
		VALUES ('$error',CURRENT_TIME())";
        //return ejecutarConsulta($sql);
        return ejecutarConsulta($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function hora($date)
    {
        $sql="SELECT TIME(fechahora) as hora  FROM ambiente where (fechahora BETWEEN '$date 00:00:00' AND '$date 23:59:59')";
        return ejecutarConsulta($sql);
    }
    public function temperatura($date)
    {
        $sql="SELECT temperatura  FROM ambiente where (fechahora BETWEEN '$date 00:00:00' AND '$date 23:59:59')";
        return ejecutarConsulta($sql);
    }
    public function humedad($date)
    {
        $sql="SELECT humedad  FROM ambiente where (fechahora BETWEEN '$date 00:00:00' AND '$date 23:59:59')";
        return ejecutarConsulta($sql);
    }
    public function horaMonitor($date)
    {
        $sql="SELECT TIME(fechahora) as hora FROM (SELECT * FROM temporal where (fechahora BETWEEN '$date 00:00:00' AND '$date 23:59:59')ORDER BY id desc LIMIT 50) as tmp  ORDER BY id ASC";
        return ejecutarConsulta($sql);
    }
    public function temperaturaMonitor($date)
    {
        $sql="SELECT temperatura FROM (SELECT * FROM temporal where (fechahora BETWEEN '$date 00:00:00' AND '$date 23:59:59') ORDER BY id desc  LIMIT 50) as tmp  ORDER BY id ASC";
        return ejecutarConsulta($sql);
    }
    public function humedadMonitor($date)
    {
        $sql="SELECT humedad FROM (SELECT * FROM temporal where (fechahora BETWEEN '$date 00:00:00' AND '$date 23:59:59') ORDER BY id desc LIMIT 50) as tmp  ORDER BY id ASC";
        return ejecutarConsulta($sql);
    }
}