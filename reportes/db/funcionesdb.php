<?php
	include("../../connect_db/connect_db.php");
	
	function repIncrementos($txtfiltronombre){
		$filtro = "";
		if($txtfiltronombre != ''){$filtro = " where contactos.nombre LIKE '%".$txtfiltronombre."%'";}
		$query ="SELECT fechas.clave_renta, contactos.`nombre`, fechas.`inicioContrato`, fechas.`fechaTerminoContrato`, fechas.fechaRenovacion,renta.`montoInicial`, cortes.`monto` as incrementos
				from fechas_contratos as fechas
					left join propiedades_renta as renta on renta.`id` = fechas.`clave_renta`
					left join cortes on cortes.`claveRenta` = fechas.clave_Renta and cortes.corte = DATE_FORMAT(fechas.fechaRenovacion, '%Y%m')
					left join contactos on contactos.`clave`=renta.`clave_arrendatario`
				".$filtro." order by clave_renta;";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}

	function repPendFactClientes($filtroFecha){
		// $filtroFecha = "and cortes.corte = DATE_FORMAT(NOW(), '%Y%m')";
		// $filtroFecha = "";
		$query ="SELECT cortes.corte, rentas.clave_arrendatario, contactos.nombre, cortes.monto
				from cortes 
					inner join propiedades_renta as rentas on cortes.`clavePropiedad`=rentas.`clave_propiedad` 
					left join contactos on contactos.clave = rentas.`clave_arrendatario`
				where cortes.facturado=0 ".$filtroFecha." 
				group by contactos.nombre, cortes.corte
				order by contactos.nombre, cortes.corte;";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}

	function repMontoXPropiedad(){
		$query ="SELECT renta.id, renta.clave_propiedad, propiedades.nombre,renta.fechaTerminoContrato, renta.montoActual 
				from propiedades_renta as renta
					left join propiedades on propiedades.`clave` = renta.`clave_propiedad`;";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function repVendidas($txtfiltroPropiedad){
		$filtro = "";
		if($txtfiltroPropiedad != ''){$filtro = " and propiedades.nombre LIKE '%".$txtfiltroPropiedad."%'";}
		$query ="SELECT propiedades.clave, propiedades.nombre, propiedades.valor_inicial, propiedades.valor_vendido, SUM(cortes.`monto`) as rentas from propiedades left join cortes on cortes.clavePropiedad = propiedades.clave where propiedades.estatus=6 ".$filtro." group by propiedades.clave;";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function repPropiedad(){
		$query ="SELECT prop.`clave`, prop.`nombre`, propietario.nombre as `propietario`, prop.`valor_inicial`, SUM(cortes.`monto`) as generado
				from `propiedades` as prop
					left join cortes on cortes.`clavePropiedad`= prop.`clave`
					left join propietario on propietario.`clave` = prop.`propietario`
				GROUP BY prop.clave;";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
?>