<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'cargaTipoContacto': cargaTipoContacto(); break;
		case 'recuperaUnContacto': recuperaUnContacto($_POST['clave']); break;

	}

	function cargaTipoContacto(){
		$contactos = recuperaContactos();
		// print_r($contacto);
		while ($row = mysqli_fetch_assoc($contactos)){
		    $contacto[] = $row;
		}
		$struct = array("Contacto" => $contacto);
		print json_encode($struct);
	}

	function recuperaUnContacto($clave){
		$unContacto = unContacto($clave);
		while($row = mysqli_fetch_assoc($unContacto)){
			$contacto[$row["tipoCliente"]] = $row;
		}
		$struct = array("Contacto" => $contacto);
		print json_encode($struct);
	}
?>