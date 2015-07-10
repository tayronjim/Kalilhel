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
	function recuperaClientes(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT * FROM contactos");
		unconnectdb($mysqli);
		return $resultado;
	}
?>