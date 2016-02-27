<?php
	// $clave = 0;
	// $query = "SELECT clave_renta, fechaRenovacion from `fechas_contratos` where `fechaRenovacion` != 'NULL'  order by clave_renta,`fechaRenovacion` desc ;";
	// $mysqli = connectdb();
	// $resultado = $mysqli->query($query);

	// while($res = mysqli_fetch_object($resultado)){
	// 	if($clave != $res->clave_renta){
	// 		inserta($res);
	// 	}
	// 	$clave = $res->clave_renta;
	// }

	// unconnectdb($mysqli);
	
	// function inserta($res){
	// 	$query = "UPDATE propiedades_renta set fechaRenovacion='".$res->fechaRenovacion."' where id=".$res->clave_renta;
	// 	$mysql = connectdb();
	// $resultado = $mysql->query($query);

	// unconnectdb($mysql);
	// }
	

	function connectdb(){
		$connectdb = new mysqli("localhost", "root", "", "kalilhel");
		mysqli_set_charset( $connectdb, 'utf8' );
		return $connectdb;
	}
	function unconnectdb($connectdb){
		$connectdb->close();
	}
?>