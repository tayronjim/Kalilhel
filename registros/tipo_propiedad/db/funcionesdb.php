<?php
	function connectdb(){
		$connectdb = new mysqli("localhost", "root", "root", "kalilhel");
		return $connectdb;
	}
	function unconnectdb($connectdb){
		$connectdb->close();
	}
	
	function recuperaTiposPropiedad(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT * FROM tipo_propiedad");
		unconnectdb($mysqli);
		return $resultado;
	}
	function unTipoPropiedad($clave){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT * FROM tipo_propiedad WHERE clave_propiedad=".$clave);
		unconnectdb($mysqli);
		return $resultado;
	}
?>