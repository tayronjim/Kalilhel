<?php 
	require_once("../db/funcionesdb.php");
	$funcion = $_POST["funcion"];
	switch($funcion){
		case 'cargaListadoPropiedades': cargaListadoPropiedades(); break;
		case 'filtraPropiedades': filtraPropiedades($_POST['txtfiltronombre'],$_POST['txtfiltrotipo']); break;
		case 'filtraArrendatario': filtraArrendatario($_POST['txtfiltronombre']); break;
		case 'guardaRenta': guardaRenta($_POST['cadena']); break;
		case 'recuperaRegistro': recuperaRegistro($_POST['clave']); break;
		case 'terminaContrato': terminaContrato($_POST['clave']); break;
		case 'actualizaRenta': actualizaRenta($_POST['cadena']); break;

	}
	function cargaListadoPropiedades(){
		$propiedades = recuperaPropiedades();
		while($row = mysqli_fetch_assoc($propiedades)){
			$propiedad[] = $row;
		}
		$struct = array("Propiedades" => $propiedad);
		print json_encode($struct);

	}
	function filtraPropiedades($txtfiltronombre,$txtfiltrotipo){
		$propiedades = filtraBuscaPropiedades($txtfiltronombre,$txtfiltrotipo);
		$resultado = "<tbody>";
		while($row = mysqli_fetch_object($propiedades)){
			$resultado .= "<tr onclick='propiedadSeleccionada(`".$row->clave."`,`".$row->tipo." - ".$row->nombre."`)'><td>".$row->nombre."</td><td>".$row->tipo."</td><td>".$row->direccion."</td></tr>";
		}
		$resultado .= "</tbody>";
		echo $resultado;
	}
	function filtraArrendatario($txtfiltronombre){
		$propiedades = filtroBuscaArrendatario($txtfiltronombre);
		$resultado = "";
		while($row = mysqli_fetch_object($propiedades)){
			$resultado .= "<tr onclick='arrendatarioSeleccionado(`".$row->clave."`,`".$row->nombre."`)'><td>".$row->nombre."</td><td>".$row->rfc."</td></tr>";
		}
		echo $resultado;
	}
	function guardaRenta($cadena){
		$respuesta = saveRenta($cadena);
		echo $respuesta;
	}
	function actualizaRenta($cadena){
		$respuesta = updateContrato($cadena);
		echo $respuesta;
	}
	function recuperaRegistro($clave){
		$res = registroRenta($clave);
		$resultado = "";
		while($row = mysqli_fetch_object($res)){
			$datetime1 = date_create($row->fechaTerminoContrato);
			$datetime2 = date_create(date("Y-m-d"));
			$interval = date_diff($datetime1, $datetime2);
			$dif = $interval->format('%R%a');
			$resultado .= $row->id.").(".$row->clave_propiedad.").(".$row->clave_arrendatario.").(".$row->inicioContrato.").(".$row->duracion.").(".$row->montoInicial.").(".$row->montoActual.").(".$row->deposito.").(".$row->regresaDeposito.").(".$row->gracia.").(".$row->mantenimiento.").(".$row->montoMantenimiento.").(".$row->consepto.").(".$row->observaciones.").(".$row->clave_estatus.").(".$row->propiedad.").(".$row->arrendatario.").(".$row->tipo.").(".$row->fechaRenovacion.").(".$row->fechaTerminoContrato.").(".$dif.").(".$row->inicioFacturacion.").(".$row->monedaMonto.").(".$row->monedaDep.").(".$row->monedaMant;
		}
		echo $resultado;

	}
	function terminaContrato($claveID){
		$resultado = updateTerminaContrato($claveID);
		return $resultado;
	}
	
?>
