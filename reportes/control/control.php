<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'reporteIncrementos': reporteIncrementos(); break;
		case 'reportePendFactClientes': reportePendFactClientes($_POST['filtro']); break;
		case 'reporteMontoXPropiedad': reporteMontoXPropiedad(); break;
		case 'reporteVendidas': reporteVendidas(); break;
		case 'reportePropiedad': reportePropiedad(); break;
		case 'reporteRentabilidad': reporteRentabilidad(); break;
		case 'reporteClienteRentabilidad': reporteClienteRentabilidad(); break;
		case 'filtraTablaIncrementos': filtraTablaIncrementos($_POST['txtfiltronombre']); break;
		case 'filtraTablaVendidas': filtraTablaVendidas($_POST['txtfiltroPropiedad']); break;
		case 'filtraTablaPropiedad': filtraTablaPropiedad($_POST['txtFiltroPropiedad'],$_POST['txtFiltroPropietario']); break;
		case 'filtraTablaRentabilidad': filtraTablaRentabilidad($_POST['txtFiltroCliente'],$_POST['txtFiltroEmpresa']); break;
		case 'filtraTablaClienteRentabilidad': filtraTablaClienteRentabilidad($_POST['txtFiltroCliente'],$_POST['txtFiltroEmpresa']); break;
		

		

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
		$rep = repPropiedad('','');
		// print_r($contacto);
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}

	function reporteRentabilidad(){
		$rep = repRentabilidad('','');
		// print_r($contacto);
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}

	function reporteClienteRentabilidad(){
		$rep = repClienteRentabilidad('','');
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
	function filtraTablaPropiedad($txtFiltroPropiedad,$txtFiltroPropietario){
		$rep = repPropiedad($txtFiltroPropiedad,$txtFiltroPropietario);
		// print_r($contacto);
		$res = "";
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}
	function filtraTablaRentabilidad($txtFiltroCliente,$txtFiltroEmpresa){
		$rep = repRentabilidad($txtFiltroCliente,$txtFiltroEmpresa);
		// print_r($contacto);
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}
	function filtraTablaClienteRentabilidad($txtFiltroCliente,$txtFiltroEmpresa){
		$rep = repClienteRentabilidad($txtFiltroCliente,$txtFiltroEmpresa);
		// print_r($contacto);
		while ($row = $rep->fetch_object()){
		    $var[] = $row;
		}
		$struct = array("Reporte" => $var);
		print json_encode($struct);
	}
	
?>