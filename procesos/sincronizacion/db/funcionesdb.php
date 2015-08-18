<?php
include("../../../connect_db/connect_db.php");
class Database{

}
	
	function insertaClientes($clientes){
		$fechaRegistro = arrglaFecha($clientes->fechaRegistro);
		$mysqli = connectdb();
		$queryComprueba = $mysqli->query("SELECT id from contactos where clave =".$clientes->clave);
		$count = mysqli_num_rows($queryComprueba);
		// echo "->".$count."<-";
		if($count>0){
			$query = "UPDATE `contactos` SET `fechaRegistro`='".$fechaRegistro."', `clave`=".$clientes->clave.", `clave_contacto`=0, `clave_padre`=0, `tipoCliente`=1, `nombre`='".$clientes->nombre."', `email`='".$clientes->Email."', `telefonoCasa`='".$clientes->telefonoCasa."', `telefonoCel`='".$clientes->telefonoCel."', `telefonoOficina`='".$clientes->telefonoOficina."', `rfc`='".$clientes->rfc."', `direccion`='".$clientes->direccion."', `ext`='".$clientes->ext."', `int`='".$clientes->int."', `colonia`='".$clientes->colonia."', `cp`='".$clientes->cp."', `ciudad`='".$clientes->ciudad."', `estado`='".$clientes->estado."',  `moroso`='".$clientes->moroso."', `metododepago`='".$clientes->metododepago."' where clave =".$clientes->clave;
		}
		else{
			$query = "INSERT INTO `contactos` (`fechaRegistro`, `clave`, `clave_contacto`, `clave_padre`, `tipoCliente`, `nombre`, `email`, `telefonoCasa`, `telefonoCel`, `telefonoOficina`, `rfc`, `direccion`, `ext`, `int`, `colonia`, `cp`, `ciudad`, `estado`,  `moroso`, `metododepago`)
					VALUES ('".$fechaRegistro."', ".$clientes->clave.", 0, 0, 1, '".$clientes->nombre."', '".$clientes->Email."', '".$clientes->telefonoCasa."', '".$clientes->telefonoCel."', '".$clientes->telefonoOficina."', '".$clientes->rfc."', '".$clientes->direccion."', '".$clientes->ext."', '".$clientes->int."', '".$clientes->colonia."', '".$clientes->cp."', '".$clientes->ciudad."', '".$clientes->estado."', '".$clientes->moroso."', '".$clientes->metododepago."')";
		
		}
		$resultadoClientes = $mysqli->query($query);
		unconnectdb($mysqli);
		
		return $resultadoClientes;
	}

	function insertaContactos($subvalue,$fechaRegistro){
		// $ = arrglaFecha($fechaRegistro);
		switch ($subvalue->tipoCliente) {
			case "CONTACTO": $tipoCliente=2; break;
			case "FIADOR": $tipoCliente=3; break;
			
			default: $tipoCliente=2; break;
		}
		
		$mysqli = connectdb();
		$queryComprueba = $mysqli->query("SELECT count(id) from contactos where clave_contacto =".$subvalue->clave_contacto.";");
		$count = mysqli_num_rows($queryComprueba);
		if($count>0){
			$query = "UPDATE `contactos` SET `fechaRegistro`='".$fechaRegistro."', `clave`= 0, `clave_contacto`=".$subvalue->clave_contacto.", `clave_padre`=".$subvalue->clave_padre.", `tipoCliente`=".$tipoCliente.", `nombre`='".$subvalue->nombre."', `email`='".$subvalue->Email."', `telefonoCasa`='".$subvalue->telefonoCasa."', `telefonoCel`='".$subvalue->telefonoCel."', `telefonoOficina`='".$subvalue->telefonoOficina."', `direccion`='".$subvalue->direccion."', `ext`='".$subvalue->ext."', `int`='".$subvalue->int."', `colonia`='".$subvalue->colonia."', `cp`='".$subvalue->cp."', `ciudad`='".$subvalue->ciudad."', `estado`='".$subvalue->estado."' where clave =".$subvalue->clave_contacto;
		}
		else{
			$query = "INSERT INTO `contactos` (`fechaRegistro`, `clave`, `clave_contacto`, `clave_padre`, `tipoCliente`, `nombre`, `email`, `telefonoCasa`, `telefonoCel`, `telefonoOficina`, `rfc`, `direccion`, `ext`, `int`, `colonia`, `cp`, `ciudad`, `estado`,  `moroso`, `metododepago`)
					VALUES ('".$fechaRegistro."', 0, ".$subvalue->clave_contacto.", ".$subvalue->clave_padre.", ".$tipoCliente.", '".$subvalue->nombre."', '".$subvalue->Email."', '".$subvalue->telefonoCasa."', '".$subvalue->telefonoCel."', '".$subvalue->telefonoOficina."', 'xxxxxxxxxxxx', '".$subvalue->direccion."', '".$subvalue->ext."', '".$subvalue->int."', '".$subvalue->colonia."', '".$subvalue->cp."', '".$subvalue->ciudad."', '".$subvalue->estado."', 'NULL', 'NULL')";
		
		}
		$resultado = $mysqli->query($query);
		// echo $query;
		unconnectdb($mysqli);
		return $resultado;
	}

	function insertaPropiedades($propiedad){
		$fechaRegistro 			= "";
		$clave 					= $propiedad->Propiedad;
		$nombre 				= $propiedad->NombrePropiedad;
		$tipo_propiedad 		= $propiedad->TipodePropiedadTipodepropiedadCodigo; //TipodePropiedadTipodepropiedadDescripcion
		$propietario 			= $propiedad->PropietarioPropietariosCodigo; //PropietarioPropietariosNombre
		$paga_mantenimiento 	= $propiedad->Pagamantenimiento;
		$direccion 				= $propiedad->DireccionCalle;
		$ext 					= $propiedad->DireccionNumExt;
		$int 					= $propiedad->DireccionNumInt;
		$colonia 				= $propiedad->Direcciond8;
		$cp 					= $propiedad->Direcciond4;
		$ciudad 				= $propiedad->Direcciond7;
		$estado 				= $propiedad->Direcciond6; //Direcciond5

		$mysqli = connectdb();
		$query = "INSERT INTO `propiedades` (`fechaRegistro`, `clave`, `nombre`, `tipo_propiedad`, `propietario`, `paga_mantenimiento`, `direccion`, `ext`, `int`, `colonia`, `cp`, `ciudad`, `estado`)
			VALUES ('".$fechaRegistro."', ".$clave.", '".$nombre."', ".$tipo_propiedad.", '".$propietario."', '".$paga_mantenimiento."', '".$direccion."', '".$ext."', '".$int."', '".$colonia."', ".$cp.", '".$ciudad."', '".$estado."');";
		$resultado = $mysqli->query($query);
		 // echo $query;
		unconnectdb($mysqli);
		return $resultado;
	}

	function registraEvento($modulo, $accion){
		
		$mysqli = connectdb();
		$query = "INSERT INTO `registro_actualizacion` (`modulo`,`accion`, `fechaSincronizacion`) VALUES ('".$modulo."','".$accion."',NOW());";
		$resultadoReg = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultadoReg;
	}

	function generaRentas($arrRentas){
		$fechaRegistro = explode(' ', $arrRentas->fechaRegistro);
		$fechaTermino = explode(' ', $arrRentas->fechaTermino);
		$fechaInicioFacturacion = explode(' ', $arrRentas->fechaInicioFacturacion);
		$fechaFactura = explode(' ', $arrRentas->factura[0]['fecha']);
		$montoInicial = str_replace(',','',$arrRentas->montoInicial);
		$montoActual = str_replace(',','',$arrRentas->montoActual);
		$montoFactura = str_replace(',','',$arrRentas->factura[0]['monto']);

		$query = "INSERT INTO `propiedades_renta` (`fechaRegistro`, `clave_propiedad`, `clave_arrendatario`, `inicioContrato`, `duracion`, `tipoDuracion`, `montoInicial`, `montoActual`, `deposito`, `regresaDeposito`, `gracia`, `inicioFacturacion`, `mantenimiento`, `montoMantenimiento`, `consepto`, `clave_estatus`, `fechaTerminoContrato`)
				VALUES
				('".arrglaFecha($fechaRegistro[0])."', ".$arrRentas->renta['propiedad'].", ".$arrRentas->renta['cliente'].", '".arrglaFecha($fechaRegistro[0])."', ".$arrRentas->duracion.", 'meses', ".$montoInicial.", ".$montoActual.", 0, 0, 0, '".arrglaFecha($fechaInicioFacturacion[0])."', 0, 0, '".$arrRentas->concepto."', 1, '".arrglaFecha($fechaTermino[0])."');";
		$mysqli = connectdb();
		$resultadoReg = $mysqli->query($query);
		// $lastID = $mysqli->insert_id;
		unconnectdb($mysqli);
		return $resultadoReg;
	}

	function buscaUltimaRenta(){
		$query = "select id from propiedades_renta order by id desc limit 1;";
		$mysqli = connectdb();
		$resultadoReg = $mysqli->query($query);
		unconnectdb($mysqli);
		$res = mysqli_fetch_object($resultadoReg);
		return $res->id;
	}

	function generaCortes($value,$ultimoIdRenta,$propiedad){
		// print_r($propiedad);
		$fechaFactura = explode(' ', $value['fecha']);
		$montoFactura = str_replace(',','',$value['monto']);
		// print_r($value->factura);

		$query = "INSERT INTO `cortes` (`claveRenta`, `clavePropiedad`, `fechaCorte`, `facturado`, `factura`, `monto`, `pagado`, `fechaPago`, `corte`)
				VALUES (".$ultimoIdRenta.", ".$propiedad.", '".arrglaFecha($fechaFactura[0])."', 1, '".$value['folio']."',".$montoFactura.", 0, NULL, DATE_FORMAT('".arrglaFecha($fechaFactura[0])."', '%Y%m'))";
		$mysqli = connectdb();
		$resultadoReg = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultadoReg;
		// echo $query;

	}

	function ultimaSinc(){
		$mysqli = connectdb();
		$query = "SELECT max(fechaSincronizacion) as fechaSincronizacion FROM registro_actualizacion";
		$resultadoReg = $mysqli->query($query);
		$fecha = mysqli_fetch_object($resultadoReg); 
		unconnectdb($mysqli);
		return $fecha->fechaSincronizacion;
	}

	function actualizaCosto($obj){
		$mysqli = connectdb();
		$monto = str_replace(',','',$obj->factura['monto']);
		$query = "UPDATE cortes set monto = ". $monto ." where factura = ". $obj->factura['folio'] ;
		$res = $mysqli->query($query);
		unconnectdb($mysqli);
		return $query;
	}

?>