<?php
$fecha1 = new DateTime("2014-10-13 17:35:04");
$fecha2 = new DateTime("2015-07-16");
$interval = $fecha1->diff($fecha2);
// $interval = $fecha2->diff($fecha1);
$fechaXML = "13.Oct.14 17:35:04";
$s = explode(' ', $fechaXML);
$fecha = explode('.',$s[0]);
$dia = $fecha[0];
$mesLetra = $fecha[1];
$anio2d = $fecha[2];
// echo $interval->format('%R%a')+0;
switch ($mesLetra) {
	case 'Ene': $mes = '01'; break;
	case 'Feb': $mes = '02'; break;
	case 'Mar': $mes = '03'; break;
	case 'Abr': $mes = '04'; break;
	case 'May': $mes = '05'; break;
	case 'Jun': $mes = '06'; break;
	case 'Jul': $mes = '07'; break;
	case 'Ago': $mes = '08'; break;
	case 'Sep': $mes = '09'; break;
	case 'Oct': $mes = '10'; break;
	case 'Nov': $mes = '11'; break;
	case 'Dic': $mes = '12'; break;
	
	default:
		# code...
		break;
}
echo $anio2d."-".$mes."-".$dia;

    
?>

























