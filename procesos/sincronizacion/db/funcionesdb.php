<?php
include("../../../connect_db/connect_db.php");
class Database{

}
	
	function insertaClientes($clientes){
		$fechaRegistro = arrglaFecha($clientes->fechaRegistro);
		$mysqli = connectdb();
		$queryComprueba = $mysqli->query("SELECT id from contactos where clave =".$clientes->clave);
		$count = mysqli_num_rows($queryComprueba);
		echo "->".$count."<-";
		if($count>0){
			$query = "UPDATE `contactos` SET `fechaRegistro`='".$fechaRegistro."', `clave`=".$clientes->clave.", `clave_contacto`=0, `clave_padre`=0, `tipoCliente`=1, `nombre`='".$clientes->nombre."', `email`='".$clientes->email."', `telefonoCasa`='".$clientes->telefonoCasa."', `telefonoCel`='".$clientes->telefonoCel."', `telefonoOficina`='".$clientes->telefonoOficina."', `rfc`='".$clientes->rfc."', `direccion`='".$clientes->direccion."', `ext`='".$clientes->ext."', `int`='".$clientes->int."', `colonia`='".$clientes->colonia."', `cp`='".$clientes->cp."', `ciudad`='".$clientes->ciudad."', `estado`='".$clientes->estado."',  `moroso`='".$clientes->moroso."', `metododepago`='".$clientes->metododepago."' where clave =".$clientes->clave;
		}
		else{
			$query = "INSERT INTO `contactos` (`fechaRegistro`, `clave`, `clave_contacto`, `clave_padre`, `tipoCliente`, `nombre`, `email`, `telefonoCasa`, `telefonoCel`, `telefonoOficina`, `rfc`, `direccion`, `ext`, `int`, `colonia`, `cp`, `ciudad`, `estado`,  `moroso`, `metododepago`)
					VALUES ('".$fechaRegistro."', ".$clientes->clave.", 0, 0, 1, '".$clientes->nombre."', '".$clientes->email."', '".$clientes->telefonoCasa."', '".$clientes->telefonoCel."', '".$clientes->telefonoOficina."', '".$clientes->rfc."', '".$clientes->direccion."', '".$clientes->ext."', '".$clientes->int."', '".$clientes->colonia."', '".$clientes->cp."', '".$clientes->ciudad."', '".$clientes->estado."', '".$clientes->moroso."', '".$clientes->metododepago."')";
		
		}
		$resultadoClientes = $mysqli->query($query);
		unconnectdb($mysqli);
		
		return $resultadoClientes;
	}

	function insertaContactos($subvalue,$fechaRegistro){
		$fechaRegistro = arrglaFecha($fechaRegistro);
		if($subvalue->tipoCliente=="CONTACTO")$tipoCliente=2;
		if($subvalue->tipoCliente=="FIADOR")$tipoCliente=3;
		
		$mysqli = connectdb();
		$queryComprueba = $mysqli->query("SELECT count(id) from contactos where clave_contacto =".$subvalue->clave_contacto.";");
		$count = mysqli_num_rows($queryComprueba);
		if($count>0){
			$query = "UPDATE `contactos` SET `fechaRegistro`='".$fechaRegistro."', `clave`= 0, `clave_contacto`=".$subvalue->clave_contacto.", `clave_padre`=".$subvalue->clave_padre.", `tipoCliente`=".$tipoCliente.", `nombre`='".$subvalue->nombre."', `email`='".$subvalue->email."', `telefonoCasa`='".$subvalue->telefonoCasa."', `telefonoCel`='".$subvalue->telefonoCel."', `telefonoOficina`='".$subvalue->telefonoOficina."', `rfc`='".$subvalue->rfc."', `direccion`='".$subvalue->direccion."', `ext`='".$subvalue->ext."', `int`='".$subvalue->int."', `colonia`='".$subvalue->colonia."', `cp`='".$subvalue->cp."', `ciudad`='".$subvalue->ciudad."', `estado`='".$subvalue->estado."',  `moroso`='".$subvalue->moroso."', `metododepago`='".$subvalue->metododepago."' where clave =".$clientes->clave;
		}
		else{
			$query = "INSERT INTO `contactos` (`fechaRegistro`, `clave`, `clave_contacto`, `clave_padre`, `tipoCliente`, `nombre`, `email`, `telefonoCasa`, `telefonoCel`, `telefonoOficina`, `rfc`, `direccion`, `ext`, `int`, `colonia`, `cp`, `ciudad`, `estado`,  `moroso`, `metododepago`)
					VALUES ('".$fechaRegistro."', 0, ".$subvalue->clave_contacto.", ".$subvalue->clave_padre.", ".$tipoCliente.", '".$subvalue->nombre."', '".$subvalue->email."', '".$subvalue->telefonoCasa."', '".$subvalue->telefonoCel."', '".$subvalue->telefonoOficina."', 'xxxxxxxxxxxx', '".$subvalue->direccion."', '".$subvalue->ext."', '".$subvalue->int."', '".$subvalue->colonia."', '".$subvalue->cp."', '".$subvalue->ciudad."', '".$subvalue->estado."', 'NULL', 'NULL')";
		
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

	function registraEvento($modulo, $accion, $fecha){
		$fechaEvento = arrglaFecha($fecha);
		$mysqli = connectdb();
		$query = "INSERT INTO `registro_actualizacion` (`modulo`,`accion`, `fechaSincronizacion`) VALUES ('".$modulo."','".$accion."',NOW())";
		$resultadoReg = $mysqli->query($query);
		unconnectdb($mysqli);
	}

	function ultimaSinc(){
		$mysqli = connectdb();
		$query = "SELECT max(fechaSincronizacion) as fechaSincronizacion FROM registro_actualizacion";
		$resultadoReg = $mysqli->query($query);
		$fecha = mysqli_fetch_object($resultadoReg); 
		unconnectdb($mysqli);
		return $fecha->fechaSincronizacion;
	}

?>