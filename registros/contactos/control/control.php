<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'cargaTipoCliente': cargaTipoCliente(); break;

	}

	function cargaTipoCliente(){
		$clientes = recuperaClientes();
		// print_r($clientes);
		while ($row = mysqli_fetch_assoc($clientes)) {
		    $customer[] = $row;
		}

		$struct = array("Customer" => $customer);
		print json_encode($struct);
		// echo $struct;
	}
?>