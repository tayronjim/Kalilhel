<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'cargaListadoPropiedad': cargaListadoPropiedad(); break;
		case 'recuperaUnaPropiedad': recuperaUnaPropiedad($_POST['clave']); break;
		case 'listaCaracteristicas': listaCaracteristicas(); break;
		case 'buscaCaracteristicas': buscaCaracteristicas($_POST['clavePropiedad']); break;
		case 'agregaCaracteristica': agregaCaracteristica($_POST['valores']); break;
	}

	function cargaListadoPropiedad(){
		$propiedades = recuperaPropiedades();
		while ($row = mysqli_fetch_assoc($propiedades)){
		    $propiedad[] = $row;
		}
		$struct = array("Propiedad" => $propiedad);
		print json_encode($struct);
	}
	function recuperaUnaPropiedad($clave){
		$unaPropiedad = unaPropiedad($clave);
		while($row = mysqli_fetch_assoc($unaPropiedad)){
			$propiedad[] = $row;
		}
		$struct = array("Propiedad" => $propiedad);
		print json_encode($struct);
	}
	function listaCaracteristicas(){
		$listaCaracteristica = listadoCaracteristicas();
		$caracteristicas = "";
		while($row = mysqli_fetch_object($listaCaracteristica)){
			$caracteristicas .= '<option value="'.$row->clave.'">'.$row->nombre.'</option>';
		}
		print $caracteristicas;
	}
	function buscaCaracteristicas($clavePropiedad){
		$listaCaracteristica = buscaCaractPropiedad($clavePropiedad);
		$caracteristicas = "";
		while($row = mysqli_fetch_object($listaCaracteristica)){
			$caracteristicas .= '<tr id="carac_'.$row->clave.'"><td>'.$row->nombre.'</td><td>'.$row->valor.'</td></tr>';
		}
		print $caracteristicas;
	}
	function agregaCaracteristica($valores){
		$agregaCaracteristica = agregaCaract($valores);
		
	}
?>