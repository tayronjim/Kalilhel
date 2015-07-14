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
	
?>