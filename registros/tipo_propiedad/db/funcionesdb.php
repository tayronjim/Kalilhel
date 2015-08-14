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
		$resultado = $mysqli->query("SELECT * FROM tipo_propiedad WHERE id=".$clave);
		unconnectdb($mysqli);
		return $resultado;
	}
	function guardaTipo($desc,$alta,$activo){
		$query = "INSERT INTO `tipo_propiedad` (`descripcion`, `fechaAlta`, `activo`) VALUES ('".$desc."', '".$alta."', ".$activo.");";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $query;
	}


	function actualizaTipo($desc,$alta,$activo,$clave){
		$query = "UPDATE `tipo_propiedad` SET `descripcion`='".$desc."', `fechaAlta`='".$alta."', `activo`=".$activo." WHERE id = ".$clave;
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $query;
	}
?>