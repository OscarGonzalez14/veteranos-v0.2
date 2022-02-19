<?php ob_start();
use Dompdf\Dompdf;
//use Dompdf\Options;

require_once '../dompdf/autoload.inc.php';
$correlativo = $_POST['correlativos_acc'];

require_once '../modelos/Reporteria.php';
$reporteria = new Reporteria();

$data = $reporteria->getItemsReporteOrdenes($correlativo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>.::Reportes::.</title>
	<style>
	body{
      font-family: Helvetica, Arial, sans-serif;
      font-size: 12px;
    }
    html{
	    margin-top: 5px;
	    margin-left: 20px;
	    margin-right:10px; 
	    margin-bottom: 0px;
    }
    }
	</style>
</head>
<body>

<table style="width: 100%;margin-top:2px">
<tr>
<td width="25%" style="width: 10%;margin:0px">
	<img src='../dist/img/inabve.jpg'  width="100" height="70"/ style="margin-top: 7px">
	<img src='../dist/img/lenti_logo.png' width="80" height="60"/></td>
</td>
	
<td width="55%" style="width: 75%;margin:0px">
<table style="width:100%">
  <tr>
    <td  style="text-align: center;margin-top: 0px;color:#0088b6;font-size:15px;font-family: Helvetica, Arial, sans-serif;"><b>ORDEN DE ENVIOS</b></td>
  </tr>
</table><!--fin segunda tabla-->
</td>
<td width="20%" style="width: 30%;margin:0px">
<table>
  <tr>
    <td style="text-align:right; font-size:12px"><strong>ORDEN</strong></td>
  </tr>
  <tr>
    <td style="color:red;text-align:right; font-size:14px"><strong >No.&nbsp;<span><?php echo $correlativo; ?></strong></td>
  </tr>
</table><!--fin segunda tabla-->
</td> <!--fin segunda columna-->
</tr>
</table>
	
</body>
</html>

<?php

$salida_html = ob_get_contents();

ob_end_clean();
$dompdf = new Dompdf();
$dompdf->loadHtml($salida_html);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();
$dompdf->stream('document', array('Attachment'=>'0'));
?>