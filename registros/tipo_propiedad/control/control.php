<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'cargaTipoPropiedad': cargaTipoPropiedad(); break;
		case 'recuperaUnTipoPropiedad': recuperaUnTipoPropiedad($_POST['clave']); break;

	}
	function cargaTipoPropiedad(){
		$tipoPropiedad = recuperaTiposPropiedad();
		// print_r($contacto);
		while ($row = mysqli_fetch_assoc($tipoPropiedad)){
		    $propiedad[] = $row;
		}
		$struct = array("Propiedad" => $propiedad);
		print json_encode($struct);
	}
	function recuperaUnTipoPropiedad($clave){
		$unTipoPropiedad = unTipoPropiedad($clave);
		while($row = mysqli_fetch_assoc($unTipoPropiedad)){
			$propiedad[] = $row;
		}
		$struct = array("Propiedad" => $propiedad);
		print json_encode($struct);
	}
	
?>