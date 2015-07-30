<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'reporteIncrementos': reporteIncrementos(); break;
		case 'reportePendFactClientes': reportePendFactClientes($_POST['filtro']); break;
		case 'reporteMontoXPropiedad': reporteMontoXPropiedad(); break;
		case 'reporteVendidas': reporteVendidas(); break;
		case 'reportePropiedad': reportePropiedad(); break;
		case 'filtraTablaIncrementos': filtraTablaIncrementos($_POST['txtfiltronombre']); break;
		case 'filtraTablaVendidas': filtraTablaVendidas($_POST['txtfiltroPropiedad']); break;

	}
	function reporteIncrementos(){
		$rep = repIncrementos('');
		// print_r($contacto);
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
		// id,clave_arrendatario,fechaTerminoContrato,fechaRenovacion,montoActual
	}

	function reportePendFactClientes($filtro){
		
		$arrFiltro = explode('_', $filtro);
		switch ($arrFiltro[0]) {
			case '1': $qFiltro = "";
				break;
			case '2': $qFiltro = " AND cortes.corte = DATE_FORMAT(NOW(), '%Y%m')";
				break;
			case '3': $qFiltro = " and DATE_FORMAT(cortes.fechaCorte, '%Y') = DATE_FORMAT(NOW(), '%Y')";
				break;
			case '4': $qFiltro = " and DATE_FORMAT(cortes.fechaCorte, '%Y%m%d') = DATE_FORMAT('".$arrFiltro[1]."', '%Y%m%d')";
				break;
			case '5': $qFiltro = " and (DATE_FORMAT(cortes.fechaCorte, '%Y%m%d') >= DATE_FORMAT('".$arrFiltro[1]."', '%Y%m%d') AND DATE_FORMAT(cortes.fechaCorte, '%Y%m%d') <= DATE_FORMAT('".$arrFiltro[2]."', '%Y%m%d'))";
				break;
			
			default:
				$qFiltro = "";
				break;
		}
		
		$rep = repPendFactClientes($qFiltro);
		// print_r($contacto);
		$var = array();
		while ($row = $rep->fetch_array()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}

	function reporteMontoXPropiedad(){
		$rep = repMontoXPropiedad();
		// print_r($contacto);
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}
	
	function reporteVendidas(){
		$rep = repVendidas('');
		// print_r($contacto);
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}

	function reportePropiedad(){
		$rep = repPropiedad();
		// print_r($contacto);
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}
	function filtraTablaIncrementos($txtfiltronombre){
		$rep = repIncrementos($txtfiltronombre);
		// print_r($contacto);
		$res = "";
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}
	function filtraTablaVendidas($txtfiltroPropiedad){
		$rep = repVendidas($txtfiltroPropiedad);
		// print_r($contacto);
		$res = "";
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}
?>