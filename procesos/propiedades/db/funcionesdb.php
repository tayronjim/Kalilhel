<?php
	include("../../../connect_db/connect_db.php");
	// function connectdb(){
	// 	$connectdb = new mysqli("localhost", "root", "root", "kalilhel");
	// 	return $connectdb;
	// }
	function unconnectdb($connectdb){
		$connectdb->close();
	}
	function recuperaPropiedades(){
		$mysqli = connectdb();
		$query = "SELECT enrenta.*, prop.nombre as propiedad, contactos.nombre as arrendatario FROM propiedades_renta as enrenta";
		$query .= " inner join propiedades as prop";
		$query .= " on prop.clave = enrenta.clave_propiedad";
		$query .= " LEFT join contactos";
		$query .= " on contactos.clave = enrenta.`clave_arrendatario`";
	
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function filtraBuscaPropiedades($txtfiltronombre,$txtfiltrotipo){
		$mysqli = connectdb();
		$filtro1 = "WHERE 1";
		if($txtfiltronombre != ""){$filtro1 .= " AND nombre LIKE '%".$txtfiltronombre."%'";}
		if($txtfiltrotipo != ""){$filtro1 .= " AND tipo_propiedad IN (SELECT clave_propiedad FROM tipo_propiedad WHERE descripcion LIKE '%".$txtfiltrotipo."%')";}
		$query = "SELECT `propiedades`.*, `tipo_propiedad`.`descripcion` as tipo from propiedades left join tipo_propiedad on tipo_propiedad.`clave_propiedad`=propiedades.`tipo_propiedad` ".$filtro1;
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function filtroBuscaArrendatario($txtfiltronombre){
		$mysqli = connectdb();
		$query = "SELECT clave,nombre,rfc FROM contactos WHERE nombre LIKE '%".$txtfiltronombre."%'";
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function saveRenta($cadena){
		$campos = explode(').(',$cadena);
			$clavePropiedad = $campos[0];
			$claveArrendatario = $campos[1];
			$inicioContrato = $campos[2];
			$duracionContrato = $campos[3];
			$montoInicial = $campos[4];
			$montoDeposito = $campos[5];
			$tiempoGracia = $campos[6];
			$regresaDeposito = $campos[7];
			$pagaMantenimiento = $campos[8];
			$montoMantenimiento = $campos[9];
			$areaConcepto = $campos[10];
			$areaObservaciones = $campos[11];
		$mysqli = connectdb();
		$query = "INSERT INTO `propiedades_renta` (`clave_propiedad`, `clave_arrendatario`, `inicioContrato`, `duracion`, `montoInicial`, `montoActual`, `deposito`, `regresaDeposito`, `gracia`, `mantenimiento`, `montoMantenimiento`, `consepto`, `observaciones`, `clave_estatus`) ";
		$query .= "VALUES ($clavePropiedad, $claveArrendatario, '$inicioContrato', $duracionContrato, $montoInicial, $montoInicial, $montoDeposito, $regresaDeposito, $tiempoGracia, $pagaMantenimiento, $montoMantenimiento, '$areaConcepto', '$areaObservaciones', 2)";
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function registroRenta($clave){
		$mysqli = connectdb();
		$query = "select * from propiedades_renta where id = ".$clave;
		
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	
?>