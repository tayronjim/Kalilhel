<?php
	function connectdb(){
		$connectdb = new mysqli("localhost", "root", "root", "kalilhel");
		return $connectdb;
	}
	function unconnectdb($connectdb){
		$connectdb->close();
	}
	function recuperaContactos(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT clave, tipoCliente, nombre, email, telefono FROM contactos WHERE tipoCliente=1");
		unconnectdb($mysqli);
		return $resultado;
	}
	function unContacto($clave){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT clave, clave_padre, tipoCliente, nombre, email, telefono FROM contactos WHERE clave=".$clave." or clave_padre=".$clave);
		unconnectdb($mysqli);
		return $resultado;
	}
	function guardaArchivos($cadena){
		$descadena = explode('///', $cadena);
		$clave_cliente = $descadena[0];
        $tipo_documento = $descadena[1];
        $archivo = $descadena[2];
        $descripcion = $descadena[3];
        $explode= explode(".", $archivo);
		$extension=array_pop($explode);
		$nombre_archivo = $tipo_documento."_".$clave_cliente.".".$extension;
		$mysqli = connectdb();
		$resultado = $mysqli->query("INSERT INTO `documentos` (`clave_cliente`, `tipo_documento`, `nombre_archivo`, `descripcion`) VALUES (".$clave_cliente.", '".$tipo_documento."', '".$nombre_archivo."', '".$descripcion."')");
		unconnectdb($mysqli);
		return $resultado;
	}
	function listaArchivos($clave){
		$mysqli = connectdb();
		// $resultado = $mysqli->query("SELECT * FROM documentos WHERE clave_cliente=".$clave." or clave_cliente in (SELECT clave from contactos where clave_padre=".$clave.")");
		$resultado = $mysqli->query("SELECT * FROM documentos WHERE clave_cliente=".$clave);
		unconnectdb($mysqli);
		return $resultado;
	}
?>