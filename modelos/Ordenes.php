<?php

require_once("../config/conexion.php");  

  class Ordenes extends Conectar{
/*SELECT o.paciente,o.fecha_creacion,s.nombre,s.direccion,op.nombre from orden as o inner join sucursal_optica as s on o.id_sucursal = s.id_sucursal INNER join optica as op on s.id_optica= op.id_optica*/
    ///////////GET SUCURSALES ///////////
    public function get_opticas(){
      $conectar=parent::conexion();
      parent::set_names();
      $sql="select id_optica,nombre from optica;";
      $sql=$conectar->prepare($sql);
      $sql->execute();
      return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    ///////////GET SUCURSALES ///////////
    public function get_sucursales_optica($id_optica){
      $conectar=parent::conexion();
      parent::set_names();
      $sql="select id_sucursal,direccion from sucursal_optica where id_optica=?;";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1,$id_optica);
      $sql->execute();
      return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    //////////////////  GET CODIGO DE ORDEN ////////////////////////

    public function get_correlativo_orden($fecha){
    $conectar = parent::conexion();
    $fecha_act = $fecha.'%';         
    $sql= "select codigo from orden_lab where fecha_correlativo like ? order by id_orden DESC limit 1;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$fecha_act);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  /////////////////  COMPROBAR SI EXISTE CORRELATIVO ///////////////
  public function validar_correlativo_orden($codigo){
    $conectar = parent::conexion();
    parent::set_names();
    $sql="select*from orden_lab where codigo=?;";
    $sql= $conectar->prepare($sql);
    $sql->bindValue(1, $codigo);
    $sql->execute();
    return $resultado=$sql->fetchAll();
  }

    public function validar_existe_correlativo($dui){
    $conectar = parent::conexion();
    parent::set_names();
    $sql="select*from orden_lab where dui=?;";
    $sql= $conectar->prepare($sql);
    $sql->bindValue(1, $dui);
    $sql->execute();
    return $resultado=$sql->fetchAll();
  }
  //////////////CREAR  BARCODE///////////////////////////////////
  public function crea_barcode($codigo){
    include 'barcode.php';       
    barcode('../codigos/' . $codigo . '.png', $codigo, 50, 'horizontal', 'code128', true);
  }
  /////////////   REGISTRAR ORDEN ///////////////////////////////
  public function registrar_orden($correlativo_op,$paciente,$fecha_creacion,$od_pupilar,$oipupilar,$odlente,$oilente,$marca_aro_orden,$modelo_aro_orden,$horizontal_aro_orden,$vertical_aro_orden,$puente_aro_orden,$id_usuario,$observaciones_orden,$dui,$od_esferas,$od_cilindros,$od_eje,$od_adicion,$oi_esferas,$oi_cilindros,$oi_eje,$oi_adicion,$tipo_lente,$color_varilla,$color_frente,$imagen,$edad,$usuario,$ocupacion,$avsc,$avfinal,$avsc_oi,$avfinal_oi,$telefono){

    $conectar = parent::conexion();
    date_default_timezone_set('America/El_Salvador'); 
    $hoy = date("d-m-Y H:i:s");
    $estado = 0;
    $categoria_lente = "-";
    $laboratorio = "";
    $estado_aro = '0';
    $dest_aro = '0';
    $sql = "insert into orden_lab values (null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    $sql = $conectar->prepare($sql);
    $sql->bindValue(1, $correlativo_op);
    $sql->bindValue(2, $paciente);
    $sql->bindValue(3, $fecha_creacion);
    $sql->bindValue(4, $od_pupilar);
    $sql->bindValue(5, $oipupilar);
    $sql->bindValue(6, $odlente);
    $sql->bindValue(7, $oilente);
    $sql->bindValue(8, $marca_aro_orden);
    $sql->bindValue(9, $modelo_aro_orden);
    $sql->bindValue(10, $horizontal_aro_orden);
    $sql->bindValue(11, $vertical_aro_orden);
    $sql->bindValue(12, $puente_aro_orden);
    $sql->bindValue(13, $id_usuario);
    $sql->bindValue(14, $observaciones_orden);
    $sql->bindValue(15, $dui);
    $sql->bindValue(16, $estado);
    $sql->bindValue(17, $hoy);
    $sql->bindValue(18, $tipo_lente);
    $sql->bindValue(19, $color_varilla);
    $sql->bindValue(20, $color_frente);
    $sql->bindValue(21, $imagen);
    $sql->bindValue(22, $laboratorio);
    $sql->bindValue(23, $categoria_lente);
    $sql->bindValue(24, $estado_aro);
    $sql->bindValue(25, $dest_aro);
    $sql->bindValue(26, $edad);
    $sql->bindValue(27, $usuario);
    $sql->bindValue(28, $ocupacion);
    $sql->bindValue(29, $avsc);
    $sql->bindValue(30, $avfinal);
    $sql->bindValue(31, $avsc_oi);
    $sql->bindValue(32, $avfinal_oi);
    $sql->bindValue(33, $telefono);
    $sql->execute();

    $sql2 = "insert into rx_orden_lab value(null,?,?,?,?,?,?,?,?,?);";
    $sql2 = $conectar->prepare($sql2);
    $sql2->bindValue(1, $correlativo_op);
    $sql2->bindValue(2, $od_esferas);
    $sql2->bindValue(3, $od_cilindros);
    $sql2->bindValue(4, $od_eje);
    $sql2->bindValue(5, $od_adicion);
    $sql2->bindValue(6, $oi_esferas);
    $sql2->bindValue(7, $oi_cilindros);
    $sql2->bindValue(8, $oi_eje);
    $sql2->bindValue(9, $oi_adicion);
    $sql2->execute();

  }
   ////////////////////LISTAR ORDENES///////////////
public function editar_orden($correlativo_op,$paciente,$fecha_creacion,$od_pupilar,$oipupilar,$odlente,$oilente,$marca_aro_orden,$modelo_aro_orden,$horizontal_aro_orden,$vertical_aro_orden,$puente_aro_orden,$id_usuario,$observaciones_orden,$dui,$od_esferas,$od_cilindros,$od_eje,$od_adicion,$oi_esferas,$oi_cilindros,$oi_eje,$oi_adicion,$tipo_lente,$color_varilla,$color_frente,$categoria_lente,$imagen,$edad,$usuario,$ocupacion,$avsc,$avfinal,$avsc_oi,$avfinal_oi,$telefono){
  $conectar = parent::conexion();
  $edit_ord = "update orden_lab set
    paciente = ?,
    fecha = ?,
    pupilar_od = ?,                                            
    pupilar_oi = ?,
    lente_od = ?,
    lente_oi = ?,
    marca_aro = ?,
    modelo_aro = ?,
    horizontal_aro = ?,
    vertical_aro = ?,
    puente_aro = ?,
    observaciones = ?,
    dui = ?,
    tipo_lente = ?,
    color_varilla=?,
    color_frente=?,
    categoria=?,
    edad=?,
    usuario_lente=?,
    ocupacion = ?,
    avsc =?,
    avfinal =?,
    avsc_oi=?,
    avfinal_oi=?,
    telefono = ?



    where codigo = ?;";

  $edit_ord = $conectar->prepare($edit_ord);
  $edit_ord->bindValue(1, $paciente);
  $edit_ord->bindValue(2, $fecha_creacion);
  $edit_ord->bindValue(3, $od_pupilar);
  $edit_ord->bindValue(4, $oipupilar);
  $edit_ord->bindValue(5, $odlente);
  $edit_ord->bindValue(6, $oilente);
  $edit_ord->bindValue(7, $marca_aro_orden);
  $edit_ord->bindValue(8, $modelo_aro_orden);
  $edit_ord->bindValue(9, $horizontal_aro_orden);
  $edit_ord->bindValue(10, $vertical_aro_orden);
  $edit_ord->bindValue(11, $puente_aro_orden);
  $edit_ord->bindValue(12, $observaciones_orden);
  $edit_ord->bindValue(13, $dui);
  $edit_ord->bindValue(14, $tipo_lente);
  $edit_ord->bindValue(15, $color_varilla);
  $edit_ord->bindValue(16, $color_frente);
  $edit_ord->bindValue(17, $categoria_lente);
  $edit_ord->bindValue(18, $edad);
  $edit_ord->bindValue(19, $usuario);
  $edit_ord->bindValue(20, $ocupacion);
  $edit_ord->bindValue(21, $avsc);
  $edit_ord->bindValue(22, $avfinal);
  $edit_ord->bindValue(23, $avsc_oi);
  $edit_ord->bindValue(24, $avfinal_oi);
  $edit_ord->bindValue(25, $telefono);
  $edit_ord->bindValue(26, $correlativo_op);

  $edit_ord->execute();

  $sql2 = "update rx_orden_lab set
  od_esferas=?,
  od_cilindros=?,
  od_eje=?,
  od_adicion=?,
  oi_esferas=?,
  oi_cilindros=?,
  oi_eje=?,
  oi_adicion=?
  where codigo=?";
  $sql2 = $conectar->prepare($sql2);  
  $sql2->bindValue(1, $od_esferas);
  $sql2->bindValue(2, $od_cilindros);
  $sql2->bindValue(3, $od_eje);
  $sql2->bindValue(4, $od_adicion);
  $sql2->bindValue(5, $oi_esferas);
  $sql2->bindValue(6, $oi_cilindros);
  $sql2->bindValue(7, $oi_eje);
  $sql2->bindValue(8, $oi_adicion);
  $sql2->bindValue(9, $correlativo_op);
  $sql2->execute();
  
}


  public function get_ordenes(){
    $conectar= parent::conexion();
    $sql= "select*from orden_lab order by id_orden DESC;";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function get_ordenes_filter_date($inicio,$fin){
    $conectar= parent::conexion();
    $sql= "select*from orden_lab where fecha between ? and ? order by fecha DESC;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $inicio);
    $sql->bindValue(2, $fin);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function get_data_orden($codigo,$paciente){

    $conectar = parent::conexion();
    $sql = "select o.telefono,o.laboratorio,o.categoria,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.marca_aro,o.modelo_aro,o.horizontal_aro,o.vertical_aro,o.puente_aro,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.color_varilla,o.color_frente,o.img,o.dui,o.edad,o.usuario_lente,o.ocupacion,o.avsc,o.avfinal,o.avsc_oi,o.avfinal_oi from
      orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo where o.codigo = ? and rx.codigo = ? and o.paciente=?;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$codigo);
    $sql->bindValue(2,$codigo);
    $sql->bindValue(3,$paciente);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function eliminar_orden($codigo){
    $conectar= parent::conexion();
    $sql ="delete from rx_orden_lab where codigo=?;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$codigo);
    $sql->execute();

    $sql2 ="delete from orden_lab where codigo=?;";
    $sql2=$conectar->prepare($sql2);
    $sql2->bindValue(1,$codigo);
    $sql2->execute();
  }

  public function show_create_order($codigo){
    $conectar= parent::conexion();
    $sql="select u.nombres,o.fecha_correlativo from orden_lab as o inner join usuarios as u on u.id_usuario=o.id_usuario where o.codigo=?;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$codigo);
    $sql->execute();
    return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function enviar_orden($codigo){
    $conectar= parent::conexion();
    $sql="update orden_lab set estado='1' where codigo=?;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$codigo);
    $sql->execute();
  }
  
   public function get_ordenes_enviadas(){
    $conectar= parent::conexion();
    $sql= "select*from orden_lab where estado='1' order by id_orden ASC;";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resultado= $sql->fetchAll(PDO::FETCH_ASSOC);
  }
 ////////////////////////////////flitrar por fecha    ////
  public function get_ordenes_por_enviar($inicio,$fin){
      $conectar = parent::conexion();
      $sql = "select o.id_orden,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.marca_aro,o.modelo_aro,o.horizontal_aro,o.vertical_aro,o.puente_aro,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion
      from
      orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo where o.estado='0' and fecha between ? and ?  order by o.fecha ASC;";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1,$inicio);
      $sql->bindValue(2,$fin);
      $sql->execute();
      return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }
/////////////////////////////FILTRAR POR LENTE ///////////////////
  public function ordenEnviarLente($lente){
      $conectar = parent::conexion();
      $sql = "select o.id_orden,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.marca_aro,o.modelo_aro,o.horizontal_aro,o.vertical_aro,o.puente_aro,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion
      from
      orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo where o.estado='0' and o.tipo_lente=?  order by o.fecha ASC;";
      $sql=$conectar->prepare($sql);
      $sql->bindValue(1,$lente);
      $sql->execute();
      return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }
//////////////////////////FILTRAR POR FECHA Y LENTE ///////////////////
public function ordenEnviarFechaLente($inicio,$fin,$lente){
  $conectar = parent::conexion();
  $sql = "select o.id_orden,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.marca_aro,o.modelo_aro,o.horizontal_aro,o.vertical_aro,o.puente_aro,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion
      from
      orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo where o.estado='0' and o.tipo_lente=? and fecha between ? and ?  order by o.fecha ASC;";
  $sql=$conectar->prepare($sql);
  $sql->bindValue(1,$lente);
  $sql->bindValue(2,$inicio);
  $sql->bindValue(3,$fin);
  $sql->execute();
  return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
}


    public function get_ordenes_enviar_general(){
      $conectar = parent::conexion();
      $sql = "select o.id_orden,o.codigo,o.paciente,o.fecha,o.pupilar_od,o.pupilar_oi,o.lente_od,o.lente_oi,o.marca_aro,o.modelo_aro,o.horizontal_aro,o.vertical_aro,o.puente_aro,o.id_usuario,o.observaciones,o.dui,o.estado,o.tipo_lente,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion
      from
      orden_lab as o inner join rx_orden_lab as rx on o.codigo=rx.codigo where o.estado='0' order by o.fecha ASC;";
      $sql=$conectar->prepare($sql);
      $sql->execute();

      return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function get_ordenes_env($laboratorio,$cat_lente,$inicio,$fin,$tipo_lente){
    $conectar = parent::conexion();
    $sql = "select o.id_orden,o.codigo,o.paciente,o.laboratorio,o.categoria,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.id_orden,o.tipo_lente,a.fecha,a.observaciones,o.fecha from rx_orden_lab as rx INNER JOIN orden_lab as o on rx.codigo=o.codigo INNER JOIN acciones_orden as a on o.codigo=a.codigo WHERE o.tipo_lente=? and a.tipo_accion='Envio' and o.estado='1' and o.laboratorio=? and o.categoria=? and o.fecha between ? and ? group by o.id_orden order by o.fecha ASC;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$tipo_lente);
    $sql->bindValue(2,$laboratorio);
    $sql->bindValue(3,$cat_lente);
    $sql->bindValue(4,$inicio);
    $sql->bindValue(5,$fin);
    $sql->execute();
    return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

 ################FILTRAR POR BASE #############
    public function getOrdenesEnvBase($laboratorio,$cat_lente){
    $conectar = parent::conexion();
    $sql = "select o.estado,o.id_orden,o.codigo,o.paciente,o.laboratorio,o.categoria,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.id_orden,o.tipo_lente,o.fecha from rx_orden_lab as rx INNER JOIN orden_lab as o on rx.codigo=o.codigo WHERE o.estado='1' and o.laboratorio=? and o.categoria=? order by o.fecha ASC;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$laboratorio);
    $sql->bindValue(2,$cat_lente);
    $sql->execute();
    return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }
###################FILTRAR LENTE###############
  public function getOrdenesEnvLente($laboratorio,$tipo_lente){
    $conectar = parent::conexion();
    $sql = "select o.estado,o.id_orden,o.codigo,o.paciente,o.laboratorio,o.categoria,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.id_orden,o.tipo_lente,o.fecha from rx_orden_lab as rx INNER JOIN orden_lab as o on rx.codigo=o.codigo WHERE o.estado='1' and o.laboratorio=? and o.tipo_lente=? order by o.fecha ASC;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$laboratorio);
    $sql->bindValue(2,$tipo_lente);
    $sql->execute();
    return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }
################## FILTRAR POR BASE Y LENTE #####################
  public function getOrdenesBaseLente($laboratorio,$cat_lente,$tipo_lente){
    $conectar = parent::conexion();
    $sql = "select o.estado,o.id_orden,o.codigo,o.paciente,o.laboratorio,o.categoria,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.id_orden,o.tipo_lente,o.fecha from rx_orden_lab as rx INNER JOIN orden_lab as o on rx.codigo=o.codigo WHERE o.estado='1' and o.laboratorio=? and o.categoria=? and o.tipo_lente=? order by o.fecha ASC;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$laboratorio);
    $sql->bindValue(2,$cat_lente);
    $sql->bindValue(3,$tipo_lente);
    $sql->execute();
    return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }
#####################FILTRAR PR FECHA#################
  public function getOrdenesEnvFechas($laboratorio,$inicio,$hasta){
    $conectar = parent::conexion();
    $sql = "select o.estado,o.id_orden,o.codigo,o.paciente,o.laboratorio,o.categoria,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.id_orden,o.tipo_lente,o.fecha from rx_orden_lab as rx INNER JOIN orden_lab as o on rx.codigo=o.codigo WHERE o.estado='1' and o.laboratorio=? and o.fecha between ? and ? order by o.fecha ASC;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$laboratorio);
    $sql->bindValue(2,$inicio);
    $sql->bindValue(3,$hasta);
    $sql->execute();
    return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }


  public function get_ordenes_env_general(){
    $conectar = parent::conexion();
    $sql = "select o.id_orden,o.codigo,o.paciente,o.laboratorio,o.categoria,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.id_orden,o.tipo_lente,o.fecha,a.observaciones from rx_orden_lab as rx INNER JOIN orden_lab as o on rx.codigo=o.codigo INNER JOIN acciones_orden as a on o.codigo=a.codigo WHERE a.tipo_accion='Envio' and o.estado='1' group by o.id_orden order by a.id_accion desc;";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  ////////////////LENTES ENVIADOS LABORATORIO
    public function getOrdenesEnviadasLab($laboratorio,$cat_lente,$inicio,$fin,$tipo_lente){
    $conectar = parent::conexion();
    $sql = "select o.estado,o.id_orden,o.codigo,o.paciente,o.laboratorio,o.categoria,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.id_orden,o.tipo_lente,o.fecha from rx_orden_lab as rx INNER JOIN orden_lab as o on rx.codigo=o.codigo WHERE (o.estado='2' or o.estado='3') and o.tipo_lente=? and o.laboratorio=? and o.categoria=? and o.fecha between ? and ? order by o.fecha ASC;";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1,$tipo_lente);
    $sql->bindValue(2,$laboratorio);
    $sql->bindValue(3,$cat_lente);
    $sql->bindValue(4,$inicio);
    $sql->bindValue(5,$fin);
    $sql->execute();
    return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }
  
  public function getEnviosGeneral(){
    $conectar = parent::conexion();
    $sql = "select o.estado,o.id_orden,o.codigo,o.paciente,o.laboratorio,o.categoria,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.id_orden,o.tipo_lente,o.fecha from rx_orden_lab as rx INNER JOIN orden_lab as o on rx.codigo=o.codigo  WHERE o.estado='2' or o.estado='3' order by o.fecha DESC;";
    $sql=$conectar->prepare($sql);
    $sql->execute();
    return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);

  }

  public function enviarOrdenes(){
    $conectar = parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H:i:s");
    $detalle_envio = array();
    $detalle_envio = json_decode($_POST["arrayEnvio"]);
    $user = $_POST["user"];
    $destino = $_POST["destino"];
    $categoria = $_POST["categoria_len"];
    $accion = "Envio";
    foreach ($detalle_envio as $k => $v) {
      $codigoOrden = $v->id_item;
      /////////////////Validar si existe orden en tabla acciones
      $sql2 = "select codigo from acciones_orden where codigo=?;";
      $sql2=$conectar->prepare($sql2);
      $sql2->bindValue(1, $codigoOrden);
      $sql2->execute();
      $resultado = $sql2->fetchAll(PDO::FETCH_ASSOC);
      ############REGISTRAR ACCION#############
      if(is_array($resultado) and count($resultado)==0){
        $sql3 = "update orden_lab set estado='1',laboratorio=?,categoria=? where codigo=?;";
        $sql3=$conectar->prepare($sql3);
        $sql3->bindValue(1,$destino);
        $sql3->bindValue(2,$categoria);
        $sql3->bindValue(3,$codigoOrden);
        $sql3->execute();
        ###########################################################
        $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1, $hoy);
        $sql->bindValue(2, $user);
        $sql->bindValue(3, $codigoOrden);
        $sql->bindValue(4, $accion);
        $sql->bindValue(5, $destino);
        $sql->execute();
      }
      
    }//////////////FIN FOREACH 

    }//////////fin metodo enviar ordenes

  public function get_ordenes_procesando(){
    $conectar = parent::conexion();      
    $sql = "select o.codigo,o.paciente,o.laboratorio,rx.od_esferas,rx.od_cilindros,rx.od_eje,rx.od_adicion,rx.oi_esferas,rx.oi_cilindros,rx.oi_eje,rx.oi_adicion,o.id_orden,o.tipo_lente,a.fecha,a.observaciones from rx_orden_lab as rx INNER JOIN orden_lab as o on rx.codigo=o.codigo INNER JOIN acciones_orden as a on o.codigo=a.codigo WHERE a.tipo_accion='Recibido' and o.estado='2';";
    $sql=$conectar->prepare($sql);
    $sql->execute();

    return $resulta = $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  public function enviarLente($codigo,$destino,$usuario){
    $conectar = parent::conexion();
    date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H:i:s");
    $accion = "Envio";
    $sql3 = "update orden_lab set estado='1',laboratorio=? where codigo=?;";
    $sql3=$conectar->prepare($sql3);
    $sql3->bindValue(1,$destino);
    $sql3->bindValue(2,$codigo);
    $sql3->execute();

    $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $hoy);
    $sql->bindValue(2, $usuario);
    $sql->bindValue(3, $codigo);
    $sql->bindValue(4, $accion);
    $sql->bindValue(5, $destino);
    $sql->execute();

  }

  public function editarEnvio($codigo,$dest,$cat,$paciente){
    $conectar = parent::conexion();
    $sql3 = "update orden_lab set laboratorio=?,categoria=? where codigo=? and paciente=?;";
    $sql3=$conectar->prepare($sql3);
    $sql3->bindValue(1,$dest);
    $sql3->bindValue(2,$cat);
    $sql3->bindValue(3,$codigo);
    $sql3->bindValue(4,$paciente);
    $sql3->execute();

  }

    public function resetTables(){
    $conectar = parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H:i:s");
    $accion = "Envio laboratorio";
    $arrayReset = array();
    $arrayReset = json_decode($_POST["array_restart"]);
    $laboratorio = $_POST["laboratorio"];
    $tipo_lente = $_POST["tipo_lente"];
    $base = $_POST["base"];
    $usuario = "Andvas";
    foreach ($arrayReset as $k) {
    $codigoOrden = $k;      
    $sql3 = "update orden_lab set estado='2' where codigo=? and laboratorio=? and tipo_lente=? and categoria=? and estado='1';";
    $sql3=$conectar->prepare($sql3);
    $sql3->bindValue(1,$codigoOrden);
    $sql3->bindValue(2,$laboratorio);
    $sql3->bindValue(3,$tipo_lente);
    $sql3->bindValue(4,$base);

    $sql3->execute();

    $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $hoy);
    $sql->bindValue(2, $usuario);
    $sql->bindValue(3, $codigoOrden);
    $sql->bindValue(4, $accion);
    $sql->bindValue(5, $laboratorio);
    $sql->execute();

      
    }//////////////FIN FOREACH 

    }//////////fin metodo enviar ordenes

     public function resetTablesPrint(){
    $conectar = parent::conexion();
    parent::set_names();
    date_default_timezone_set('America/El_Salvador'); $hoy = date("d-m-Y H:i:s");
    $accion = "Envio laboratorio-print";
    $arrayReset = array();
    $arrayReset = json_decode($_POST["array_restart_print"]);
    $usuario = "Andvas";
    foreach ($arrayReset as $k) {
    $codigoOrden = $k;      
    $sql3 = "update orden_lab set estado='3' where codigo=?;";
    $sql3=$conectar->prepare($sql3);
    $sql3->bindValue(1,$codigoOrden);
    $sql3->execute();

    $sql2 = "select laboratorio from orden_lab where codigo=?;";
    $sql2=$conectar->prepare($sql2);
    $sql2->bindValue(1,$codigoOrden);
    $sql2->execute();

    $resultado = $sql2->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultado as $value) {
      $laboratorio = $value["laboratorio"];
    }


    $sql = "insert into acciones_orden values(null,?,?,?,?,?);";
    $sql=$conectar->prepare($sql);
    $sql->bindValue(1, $hoy);
    $sql->bindValue(2, $usuario);
    $sql->bindValue(3, $codigoOrden);
    $sql->bindValue(4, $accion);
    $sql->bindValue(5, $laboratorio);
    $sql->execute();

      
    }//////////////FIN FOREACH 

    }//////////fin metodo enviar ordenes


   }//Fin de la Clase



