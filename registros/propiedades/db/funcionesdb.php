<?php
	function connectdb(){
		$connectdb = new mysqli("localhost", "root", "root", "kalilhel");
		mysqli_set_charset( $connectdb, 'utf8' );
		return $connectdb;
	}
	function unconnectdb($connectdb){
		$connectdb->close();
	}
	function recuperaPropiedades(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT clave, nombre, monto_inquilino FROM propiedades");
		unconnectdb($mysqli);
		return $resultado;
	}
	function unaPropiedad($clave){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT clave, nombre, monto_inquilino FROM propiedades WHERE clave=".$clave);
		unconnectdb($mysqli);
		return $resultado;
	}
	function listadoCaracteristicas(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT clave, nombre, tipo FROM lista_caracteristicas");
		unconnectdb($mysqli);
		return $resultado;
	}
	function buscaCaractPropiedad($clavePropiedad){
		$mysqli = connectdb();
		$query  = "select carac.clave, lista.nombre,carac.valor,lista.tipo from caracteristicas as carac";
		$query .= " inner join lista_caracteristicas as lista on lista.clave=carac.clave_caracteristica";
		$query .= " where carac.clave_propiedad=".$clavePropiedad;
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function agregaPropiedad($cadena){
		$datos = explode(').(',$cadena);

		$tipo =			$datos[0];
		$propietario =	$datos[1];
		$pagaM =		$datos[2];
		$direccion =	$datos[3];
		$nExt = 		$datos[4];
		$nInt = 		$datos[5];
		$cp =			$datos[6];
		$ciudad =		$datos[7];
		$estado =		$datos[8];
		$valorGInicial= $datos[9];
		$moneda =		$datos[10];
		$cambio =		$datos[11];
		$fechaAdquisicion=$datos[12];
		$valorRActual =	$datos[13];
		$montoInquilino=$datos[14];

		$query="INSERT INTO `propiedades` (`fechaRegistro`, `clave`, `nombre`, `tipo_propiedad`, `propietario`, `paga_mantenimiento`, `direccion`, `ext`, `int`, `colonia`, `cp`, `ciudad`, `estado`, `valor_inicial`, `tipo_moneda`, `cambio`, `adquisicion`, `valor_actual`, `monto_inquilino`)
VALUES
	('0000-00-00', 1, 'PATRIOTISMO', 1, 1, 0, 'AV. MUNICH', '823', 'PB', 'INSURGENTES,MIXCOAC', 3920, 'BENITO JUAREZ', 0, NULL, NULL, NULL, NULL, NULL, NULL);
 ";
	}
	function agregaCaract($valores){
		list($claveP, $ClaveC, $valor) = split('@', $valores);
		$query = "INSERT INTO `caracteristicas` (`clave_propiedad`, `clave_caracteristica`, `valor`) VALUES (".$claveP.", ".$ClaveC.", '".$valor."');";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function guardaArchivos($cadena){
		$descadena = explode('///', $cadena);
		$clave_propiedad = $descadena[0];
        $tipo_documento = $descadena[1];
        $archivo = $descadena[2];
        $descripcion = $descadena[3];
        $explode= explode(".", $archivo);
		$extension=array_pop($explode);
		$nombre_archivo = $tipo_documento."_".$clave_propiedad.".".$extension;
		$mysqli = connectdb();
		$resultado = $mysqli->query("INSERT INTO `documentos` (`clave_propiedad`, `tipo_documento`, `nombre_archivo`, `descripcion`) VALUES (".$clave_propiedad.", '".$tipo_documento."', '".$nombre_archivo."', '".$descripcion."')");
		unconnectdb($mysqli);
		return $resultado;
	}
	function listaArchivos($clave){
		$mysqli = connectdb();
		// $resultado = $mysqli->query("SELECT * FROM documentos WHERE clave_cliente=".$clave." or clave_cliente in (SELECT clave from contactos where clave_padre=".$clave.")");
		$resultado = $mysqli->query("SELECT * FROM documentos WHERE clave_propiedad=".$clave);
		unconnectdb($mysqli);
		return $resultado;
	}
?>