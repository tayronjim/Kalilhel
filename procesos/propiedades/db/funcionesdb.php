<?php
	include("../../../connect_db/connect_db.php");
	
	
	function recuperaPropiedades(){
		$mysqli = connectdb();
		$query = "SELECT enrenta.*, prop.nombre as propiedad, contactos.nombre as arrendatario FROM propiedades_renta as enrenta";
		$query .= " inner join propiedades as prop";
		$query .= " on prop.clave = enrenta.clave_propiedad";
		$query .= " LEFT join contactos";
		$query .= " on contactos.clave = enrenta.`clave_arrendatario`";
		$query .= " WHERE enrenta.clave_estatus = 2 or enrenta.clave_estatus = 4";
	
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
		$lastID = lastID();
		$claveID = $lastID->fetch_object();

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
			$finContrato = $campos[12];
			$fechaRenovacion = $campos[13];
			// $claveID = $campos[15];
		$mysqli = connectdb();

		$query = "INSERT INTO `propiedades_renta` (`fechaRegistro`,`clave_propiedad`, `clave_arrendatario`, `inicioContrato`, `duracion`, `montoInicial`, `montoActual`, `deposito`, `regresaDeposito`, `gracia`, `mantenimiento`, `montoMantenimiento`, `consepto`, `observaciones`, `clave_estatus`,`fechaTerminoContrato`) ";
		$query .= "VALUES (NOW(),".$clavePropiedad.", ".$claveArrendatario.", '".$inicioContrato."', ".$duracionContrato.", ".$montoInicial.", ".$montoInicial.", ".$montoDeposito.", ".$regresaDeposito.", ".$tiempoGracia.", ".$pagaMantenimiento.", ".$montoMantenimiento.", '".$areaConcepto."', '".$areaObservaciones."', 2,'".$finContrato."')";
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		insertaHistorial($claveID->id,$inicioContrato,$finContrato,$fechaRenovacion);
		// return $cadena;
		return $resultado;
	}
	function registroRenta($clave){
		$mysqli = connectdb();
		$query = "SELECT enrenta.*, prop.nombre as propiedad, contactos.nombre as arrendatario, `tipo_propiedad`.`descripcion` as tipo ";
		$query .= "FROM propiedades_renta as enrenta ";
		$query .= "inner join propiedades as prop ";
		$query .= "on prop.clave = enrenta.clave_propiedad ";
		$query .= "LEFT join contactos ";
		$query .= "on contactos.clave = enrenta.`clave_arrendatario` ";
		$query .= "LEFT JOIN tipo_propiedad on tipo_propiedad.`clave_propiedad`=prop.`tipo_propiedad` ";
		$query .= "where enrenta.id = ".$clave;
		
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function updateTerminaContrato($claveID){
		$mysqli = connectdb();
		$query = "UPDATE `propiedades_renta` SET clave_estatus = 5, fechaRenovacion=NULL, fechaTerminoContrato=NOW() WHERE id=".$claveID;
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function updateContrato($cadena){
		$campos = explode(').(',$cadena);

		$inicioContrato = $campos[2];
		$finContrato = $campos[12];
		$fechaRenovacion = $campos[13];
		$montoActual = $campos[14];
		$observaciones = $campos[11];
		$mantenimiento = $campos[8];
		$montoMantenimiento = $campos[9];
		$consepto = $campos[10];
		$claveID = $campos[15];
		$checkRenovar = $campos[16];

		$mysqli = connectdb();
		$query = "UPDATE `propiedades_renta` SET fechaTerminoContrato = '".$finContrato."', fechaRenovacion='".$fechaRenovacion."', montoActual = ".$montoActual.", mantenimiento = ".$mantenimiento.", montoMantenimiento = ".$montoMantenimiento.", consepto = '".$consepto."', observaciones = '".$observaciones."' WHERE id=".$claveID;
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		if($checkRenovar=="1"){insertaHistorial($claveID,$inicioContrato,$finContrato,$fechaRenovacion);}
		return $query;
		// return $resultado;
		
		// norma ., servicio  de datos de la instancia esta detenido 
	
	}
	function lastID(){
		$query = "SELECT max(id)+1 as id from `propiedades_renta`;";
		$resultado = queryGeneral($query);
		return $resultado;	
	}

	function insertaHistorial($claveID,$inicioContrato,$finContrato,$fechaRenovacion){
		$query = "INSERT INTO `fechas_contratos` (`clave_renta`, `inicioContrato`, `fechaTerminoContrato`, `fechaRenovacion`)
				VALUES (".$claveID.", '".$inicioContrato."', '".$finContrato."','".$fechaRenovacion."')";
		$resultado = queryGeneral($query);
		return $resultado;	
	}

	function queryGeneral($query){
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	
?>