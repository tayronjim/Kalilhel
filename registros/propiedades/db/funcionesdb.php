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