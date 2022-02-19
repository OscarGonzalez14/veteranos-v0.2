<?php

$correlativo = $_POST['correlativos_acc'];

require_once '../modelos/Reporteria.php';
$reporteria = new Reporteria();

$data = $reporteria->getItemsReporteOrdenes($correlativo);