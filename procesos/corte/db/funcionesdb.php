<?php
	include("../../../connect_db/connect_db.php");
	
	function listadoFacturasRenta(){
		// este mes -> select inicioContrato from `propiedades_renta` where DATE_FORMAT(inicioContrato, '%Y-%m-01')< DATE_FORMAT(NOW(), '%Y-%m-01') AND DATE_FORMAT(NOW(), '%Y-%m-01')< DATE_FORMAT(fechaTerminoContrato, '%Y-%m-01');
		// hoy -> select inicioContrato from `propiedades_renta` where DATE_FORMAT(inicioContrato, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d') AND NOW()< fechaTerminoContrato;

		$query="select *,CONCAT(DATE_FORMAT(NOW(), '%Y-%m'),DATE_FORMAT(`propiedades_renta`.inicioFacturacion, '-%d')) as fcorte from `propiedades_renta` where DATE_FORMAT(inicioContrato, '%Y-%m-01')< DATE_FORMAT(NOW(), '%Y-%m-01') AND DATE_FORMAT(NOW(), '%Y-%m-01')< DATE_FORMAT(fechaTerminoContrato, '%Y-%m-01')";
		$resultado = queryGeneral($query);
		return $resultado;
	}
	 function listadoFacturasCorte(){
	 	$query="select * from `cortes` where corte = DATE_FORMAT(NOW(),'%Y%m');";
		$resultado = queryGeneral($query);
		return $resultado;
	 }

	function buscaCortes(){
		$query = "select count(id) as cuenta from cortes where corte = DATE_FORMAT(NOW(), '%Y%m')";
		$resultado = queryGeneral($query);
		return $resultado;
	}
	function insertaCorte($info){
		$query = "INSERT INTO `cortes` (`claveRenta`, `clavePropiedad`, `fechaCorte`, `facturado`, `factura`, `pagado`, `fechaPago`, `corte`)
				VALUES (".$info->id.", ".$info->clave_propiedad.", CONCAT(DATE_FORMAT(NOW(), '%Y-%m'),DATE_FORMAT('".$info->inicioFacturacion."', '-%d')), 0, '', 0, NULL, DATE_FORMAT(NOW(), '%Y%m'))";
		$resultado = queryGeneral($query);
		return $resultado;	
	}
	function cambiosCorte($cadena){
		foreach ($cadena as $key => $value) {
			// echo $key;
			// if($value['pagado']=='true'){$pagado = 1;}if($value['pagado']=='false'){$pagado = 0;}
			$query = "UPDATE cortes SET pagado=".$value['pagadoCheck']." ,fechaPago=".$value['pagadoFecha']." WHERE claveRenta=".$key;
			$resultado = queryGeneral($query);
			echo $query;
		}
		// $query = "UPDATE cortes SET pagado=1 ,fechaPago='2015-07-22' WHERE id=17";
		// $resultado = queryGeneral($query);
		// return $resultado;
	}
	function queryGeneral($query){
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
?>