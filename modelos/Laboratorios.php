<?php

require_once("../config/conexion.php");  

  class Laboratorios extends Conectar{
   
    public function get_ordenes_filter_date($inicio,$fin){
    $conectar= parent::conexion();
    $sql= "select*from orden_lab where (fecha between ? and ?) and estado_aro < 2 order by id_orden DESC;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $inicio);
    $sql->bindValue(2, $fin);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function recibirOrdenesLab(){
    $conectar= parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H:i:s");
    $detalle_recibidos = array();
    $detalle_recibidos = json_decode($_POST["arrayRecibidos"]);
    $usuario = $_POST["usuario"];

    foreach ($detalle_recibidos as $k => $v) {
      
      $codigoOrden = $v->codigo;
      $accion = "Recibir Lab";
      $destino = "-";

      $sql2 = "update orden_lab set estado_aro='2' where codigo=?;";
      $sql2=$conectar->prepare($sql2);
      $sql2->bindValue(1, $codigoOrden);
      $sql2->execute();

      $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1, $hoy);
      $sql->bindValue(2, $usuario);
      $sql->bindValue(3, $codigoOrden);
      $sql->bindValue(4, $accion);
      $sql->bindValue(5, $destino);
      $sql->execute();
    }
  }

  public function get_ordenes_procesando_lab(){
    $conectar= parent::conexion();
    parent::set_names();
    $sql= "select*from orden_lab where estado_aro = 2 order by id_orden DESC;";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

    public function finalizarOrdenesLab(){
    $conectar= parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H:i:s");
    $detalle_finalizados = array();
    $detalle_finalizados = json_decode($_POST["arrayOrdenesBarcode"]);
    $usuario = $_POST["usuario"];

    foreach ($detalle_finalizados as $k => $v) {
      
      $codigoOrden = $v->n_orden;
      $accion = "Finalizar Lab";
      $destino = "-";

      $sql2 = "update orden_lab set estado_aro='3' where codigo=?;";
      $sql2=$conectar->prepare($sql2);
      $sql2->bindValue(1, $codigoOrden);
      $sql2->execute();

      $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1, $hoy);
      $sql->bindValue(2, $usuario);
      $sql->bindValue(3, $codigoOrden);
      $sql->bindValue(4, $accion);
      $sql->bindValue(5, $destino);
      $sql->execute();
    }
  }

  public function get_ordeOrdenesFinalizadas(){
    $conectar= parent::conexion();
    parent::set_names();
    $sql= "select o.id_orden,o.codigo,a.fecha,o.paciente,o.tipo_lente,o.img from orden_lab as o INNER JOIN acciones_orden as a on a.codigo=o.codigo where a.`tipo_accion` = 'Finalizar Lab' and o.estado_aro='3';";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

    public function get_ordenes_barcode_lab($codigo){
    $conectar= parent::conexion();
    $sql= "select*from orden_lab where codigo = ?;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $codigo);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

    public function recibirOrdenesLabBarcode(){
    $conectar= parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H:i:s");
    $detalle_recibidos = array();
    $detalle_recibidos = json_decode($_POST["arrayOrdenesBarcode"]);
    $usuario = $_POST["usuario"];

    foreach ($detalle_recibidos as $k => $v) {
      
      $codigoOrden = $v->n_orden;
      $accion = "Recibir Lab";
      $destino = "A proceso";

      $sql2 = "update orden_lab set estado_aro='2' where codigo=?;";
      $sql2=$conectar->prepare($sql2);
      $sql2->bindValue(1, $codigoOrden);
      $sql2->execute();

      $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1, $hoy);
      $sql->bindValue(2, $usuario);
      $sql->bindValue(3, $codigoOrden);
      $sql->bindValue(4, $accion);
      $sql->bindValue(5, $destino);
      $sql->execute();
    }
  }


}

/***************** REPORTERIA LABORATORIO **********************************
select o.paciente,o.estado,o.tipo_lente,o.fecha as fechaexp,a.fecha,a.tipo_accion,a.observaciones from orden_lab as o inner join acciones_orden as a on a.codigo=o.codigo where a.fecha like "%06-12-2021%"*/
