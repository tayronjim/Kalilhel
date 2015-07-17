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
		$resultado = "";
		while($row = mysqli_fetch_object($propiedades)){
			$resultado .= "<tr onclick='propiedadSeleccionada(`".$row->clave."`,`".$row->tipo." - ".$row->nombre."`)'><td>".$row->nombre."</td><td>".$row->tipo."</td><td>".$row->direccion."</td></tr>";
		}
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
	function recuperaRegistro($clave){
		$res = registroRenta($clave);
		$resultado = "";
		while($row = mysqli_fetch_object($res)){
			$resultado .= $row->id.").(".$row->clave_propiedad.").(".$row->clave_arrendatario.").(".$row->inicioContrato.").(".$row->duracion.").(".$row->montoInicial.").(".$row->montoActual.").(".$row->deposito.").(".$row->regresaDeposito.").(".$row->gracia.").(".$row->mantenimiento.").(".$row->montoMantenimiento.").(".$row->consepto.").(".$row->observaciones.").(".$row->clave_estatus.").(".$row->propiedad.").(".$row->arrendatario.").(".$row->tipo.").(".$row->fechaRenovacion;
		}
		echo $resultado;

	}
	function terminaContrato($claveID){
		$resultado = updateTerminaContrato($claveID);
		return $resultado;
	}
	
?>
