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
?>