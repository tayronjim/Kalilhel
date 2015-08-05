<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'cargaContacto': cargaContacto(); break;
		case 'recuperaUnContacto': recuperaUnContacto($_POST['clave']); break;
		case 'almacenaArchivos': almacenaArchivos($_POST['cadena']); break;
		case 'muestraArchivos': muestraArchivos($_POST['clave']); break;
		case 'cargaEstados': cargaEstados(); break;

	}

	function cargaContacto(){
		$contactos = recuperaContactos();
		// print_r($contacto);
		while ($row = mysqli_fetch_assoc($contactos)){
		    $contacto[] = $row;
		}
		$struct = array("Contacto" => $contacto);
		print json_encode($struct);
	}
 
	function cargaEstados(){
		$res = "";
		$estados = cargaListaEstados();
		while($row = mysqli_fetch_object($estados)){
			$res .= "<option value='".$row->id."'>".$row->estado."</option>";
		}
		echo $res;
	}

	function recuperaUnContacto($clave){
		$unContacto = unContacto($clave);
		while($row = mysqli_fetch_assoc($unContacto)){
			$contacto[$row["tipoCliente"]] = $row;
		}
		$struct = array("Contacto" => $contacto);
		print json_encode($struct);
	}
	function almacenaArchivos($cadena){
		$registro = buscaRegArchivo($cadena);
		$cuenta = $registro->fetch_object();
		if($cuenta->cuenta > 0){
			$archivos = actualizaArchivos($cadena);
		}
		else{
			$archivos = guardaArchivos($cadena);
		}
		echo $archivos;
	}
	function muestraArchivos($clave){
		$listaArchivos = listaArchivos($clave);
		$filasArchivos = "<tbody>";
		while($row = mysqli_fetch_object($listaArchivos)){
			$filasArchivos .= '<tr id="tr'.$row->tipo_documento.'"><td width="150px">'.$row->tipo_documento.'</td><td width="250px">'.$row->descripcion.'</td><td><a href="../../../uploads/contactos/'.$row->nombre_archivo.'" target="_BLANK">Abrir Archivo</a></td></tr>';
		}
		$filasArchivos .= "</tbody>";
		print $filasArchivos;
	}
?>