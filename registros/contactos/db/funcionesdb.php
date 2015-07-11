<?php
	function connectdb(){
		$connectdb = new mysqli("localhost", "root", "root", "kalilhel");
		return $connectdb;
	}
	function unconnectdb($connectdb){
		$connectdb->close();
	}
	function tipoCliente(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT * FROM tipo_cliente");
		unconnectdb($mysqli);
		return $resultado;
	}
	function recuperaContactos(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT clave, nombre, email, telefono FROM contactos");
		unconnectdb($mysqli);
		return $resultado;
	}
	function unContacto($clave){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT nombre, email, telefono FROM contactos WHERE clave=".$clave);
		unconnectdb($mysqli);
		return $resultado;
	}
?>