<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'cargaListadoPropiedades': cargaListadoPropiedades(); break;
		case 'x': x($_POST['clave']); break;

	}
	function cargaListadoPropiedades(){
		$propiedades = recuperaPropiedades();
		while($row = mysqli_fetch_assoc($propiedades)){
			$propiedad[] = $row;
		}
		$struct = array("Propiedades" => $propiedad);
		print json_encode($struct);

	}

	
?>