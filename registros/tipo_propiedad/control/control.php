<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'cargaTipoPropiedad': cargaTipoPropiedad(); break;
		case 'recuperaUnTipoPropiedad': recuperaUnTipoPropiedad($_POST['clave']); break;
		case 'GuardaTipoPropiedad': GuardaTipoPropiedad($_POST['desc'], $_POST['alta'], $_POST['activo']); break;
		case 'ActualizaTipoPropiedad': ActualizaTipoPropiedad($_POST['desc'], $_POST['alta'], $_POST['activo'], $_POST['clave']); break;

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
	function GuardaTipoPropiedad($desc,$alta,$activo){
		$GuardaTipoPropiedad = guardaTipo($desc,$alta,$activo);
		echo $GuardaTipoPropiedad;
	}

	function ActualizaTipoPropiedad($desc,$alta,$activo,$clave){
		$GuardaTipoPropiedad = actualizaTipo($desc,$alta,$activo,$clave);
		echo $GuardaTipoPropiedad;
	}
	
?>