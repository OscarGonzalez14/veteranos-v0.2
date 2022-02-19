<?php
require_once("../config/conexion.php");

class Reporteria extends Conectar{

public function print_orden($codigo){
    $conectar= parent::conexion();
    parent::set_names(); 

    $sql = "select o.fecha,o.paciente,o.dui,o.edad,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.avsc,o.avfinal,o.modelo_aro,o.marca_aro,o.horizontal_aro,o.vertical_aro,o.puente_aro,o.tipo_lente,o.codigo from orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo where o.codigo=?;";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1,$codigo);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    
}

public function get_ordenes_recibir_lab($codigo){
  $conectar= parent::conexion();
  parent::set_names();
  $sql = "select*from orden_lab where id_orden=?;";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$codigo);
  $sql->execute();
  return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
}

public function getItemsReporteOrdenes($correlativo){
  $conectar= parent::conexion();
  parent::set_names();
  $sql = "elect o.paciente,o.dui,d.codigo_orden,a.fecha,a.hora,a.usuario,a.ubicacion,o.tipo_lente,d.id_detalle_accion from orden_lab as o inner join detalle_acciones_veteranos as d on o.codigo=d.codigo_orden INNER join acciones_ordenes_veteranos as a on a.correlativo_accion=d.correlativo_accion where d.correlativo_accion=?;";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$correlativo);
  $sql->execute();
  return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
}



}///FIN DE LA CLASE




