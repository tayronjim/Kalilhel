<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'cargaListadoPropiedad': cargaListadoPropiedad(); break;
		case 'recuperaUnaPropiedad': recuperaUnaPropiedad($_POST['clave']); break;
		case 'listaCaracteristicas': listaCaracteristicas(); break;
		case 'buscaCaracteristicas': buscaCaracteristicas($_POST['clavePropiedad']); break;
		case 'agregaCaracteristica': agregaCaracteristica($_POST['valores']); break;
		case 'almacenaArchivos': almacenaArchivos($_POST['cadena']); break;
		case 'muestraArchivos': muestraArchivos($_POST['clave']); break;
		case 'guardaRegistro': guardaRegistro($_POST['cadena']); break;
			# code...
			break;
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
	function almacenaArchivos($cadena){
		$archivos = guardaArchivos($cadena);
		echo $archivos;
	}
	function muestraArchivos($clave){
		$listaArchivos = listaArchivos($clave);
		$filasArchivos = "";
		while($row = mysqli_fetch_object($listaArchivos)){
			$filasArchivos .= '<tr><td>'.$row->tipo_documento.'</td><td>'.$row->descripcion.'</td><td><a href="../../../uploads/propiedades/'.$row->nombre_archivo.'" target="_BLANK">Abrir Archivo</a></td></tr>';
		}
		print $filasArchivos;
	}
	function guardaRegistro($cadena){
		// $datos = explode(').(',$cadena);
		$respAgregaPropiedad = agregaPropiedad($cadena);
	}
?>