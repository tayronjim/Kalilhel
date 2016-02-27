<?php 
	include("../../../connect_db/connect_db.php");

	function recuperaPropiedades(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT propiedades.clave, propiedades.fechaRegistro,propiedades.adquisicion, propiedades.nombre, `tipo_propiedad`.`descripcion` as tipo ,`propietario`.`nombre` as propietario, propiedades.monto_inquilino 
									FROM propiedades
									left join propietario on propietario.`clave` = propiedades.`propietario`
									left join `tipo_propiedad` on `tipo_propiedad`.`id` = propiedades.`tipo_propiedad` order by propiedades.nombre");
		unconnectdb($mysqli);
		return $resultado;
	}
	function unaPropiedad($clave){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT * FROM propiedades WHERE clave=".$clave);
		unconnectdb($mysqli);
		return $resultado;
	}
	function recuperaTiposPropiedad(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT * FROM tipo_propiedad where activo = 1");
		unconnectdb($mysqli);
		return $resultado;
	}

	function recuperaPropietarios(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT * FROM propietario");
		unconnectdb($mysqli);
		return $resultado;
	}

	function recuperaEstados(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT * FROM estados");
		unconnectdb($mysqli);
		return $resultado;
	}

	function listadoCaracteristicas(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT id, clave, nombre, tipo FROM lista_caracteristicas");
		unconnectdb($mysqli);
		return $resultado;
	}
	function buscaCaractPropiedad($clavePropiedad){
		$mysqli = connectdb();
		$query  = "select lista.id as id, carac.clave, lista.nombre,carac.valor,lista.tipo from caracteristicas as carac";
		$query .= " inner join lista_caracteristicas as lista on lista.clave=carac.clave_caracteristica";
		$query .= " where carac.clave_propiedad=".$clavePropiedad;
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function agregaPropiedad($cadena){
		$datos = explode(')+(',$cadena);

		$nombre = 			$datos[0];
		$tipo =				$datos[1];
		$propietario =		$datos[2];
		$pagaM =			$datos[3];
		$direccion =		$datos[4];
		$nExt = 			$datos[5];
		$nInt = 			$datos[6];
		$colonia = 			$datos[7];
		$cp =				$datos[8];
		$ciudad =			$datos[9];
		$estado =			$datos[10];
		$valorInicial= 		$datos[11];
		$moneda =			$datos[12];
		$cambio =			$datos[13];
		$fechaAdquisicion=	$datos[14];
		$valorRActual =		$datos[15];
		$montoInquilino=	$datos[16];
		$valorGInicial= 	$datos[18];

		$siguienteClave = ultimaClaveMasUno();



		$query="INSERT INTO `propiedades` (`fechaRegistro`, `clave`, `nombre`, `tipo_propiedad`, `propietario`, `paga_mantenimiento`, `direccion`, `ext`, `int`, `colonia`, `cp`, `ciudad`, `estado`, `valor_inicial`, `tipo_moneda`, `cambio`, `adquisicion`, `valor_actual`, `monto_inquilino`,`valorGeneradoInicial`)
			VALUES (NOW(), ".$siguienteClave.", '".$nombre."', ".$tipo.", ".$propietario.", ".$pagaM.", '".$direccion."', '".$nExt."', '".$nInt."', '".$colonia."', '".$cp."', '".$ciudad."', ".$estado.", ".$valorInicial.", '".$moneda."', ".$cambio.", '".$fechaAdquisicion."', ".$valorRActual.", ".$montoInquilino.",".$valorGInicial.")";
		// echo $query;
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		echo $query;
	}
	function actualizaPropiedad($cadena){
		$datos = explode(')+(',$cadena);

		$nombre = 			$datos[0];
		$tipo =				$datos[1];
		$propietario =		$datos[2];
		$pagaM =			$datos[3];
		$direccion =		$datos[4];
		$nExt = 			$datos[5];
		$nInt = 			$datos[6];
		$colonia = 			$datos[7];
		$cp =				$datos[8];
		$ciudad =			$datos[9];
		$estado =			$datos[10];
		$valorInicial= 		$datos[11];
		$moneda =			$datos[12];
		$cambio =			$datos[13];
		$fechaAdquisicion=	$datos[14];
		$valorRActual =		$datos[15];
		$montoInquilino=	$datos[16];
		$clave=				$datos[17];
		$valorGInicial= 	$datos[18];

		$query = "UPDATE `propiedades` SET   `nombre`='".$nombre."', `tipo_propiedad`=".$tipo.", `propietario`=".$propietario.", `paga_mantenimiento`=".$pagaM.", `direccion`='".$direccion."', `ext`='".$nExt."', `int`='".$nInt."', `colonia`='".$colonia."', `cp`='".$cp."', `ciudad`='".$ciudad."', `estado`=".$estado.", `valor_inicial`=".$valorInicial.", `tipo_moneda`='".$moneda."', `cambio`=".$cambio.", `valorGeneradoInicial`=".$valorGInicial.", `valor_actual`=".$valorRActual.", `adquisicion`='".$fechaAdquisicion."' where clave= ".$clave;

		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $query;
	}
	function agregaCaract($valores){
		list($claveP, $ClaveC, $valor) = explode('@', $valores);
		$query = "INSERT INTO `caracteristicas` (`clave_propiedad`, `clave_caracteristica`, `valor`) VALUES (".$claveP.", ".$ClaveC.", '".$valor."');";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function buscaRegArchivo($cadena){
		$descadena = explode('///', $cadena);
		$clave_propiedad = $descadena[0];
        $tipo_documento = $descadena[1];
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT count(id) as cuenta from documentos where clave_propiedad=".$clave_propiedad." and tipo_documento='".$tipo_documento."'");
		unconnectdb($mysqli);
		return $resultado;
	}

	function actualizaArchivos($cadena){
		$descadena = explode('///', $cadena);
		$clave_propiedad = $descadena[0];
        $tipo_documento = $descadena[1];
        $archivo = $descadena[2];
        $descripcion = $descadena[3];
        $explode= explode(".", $archivo);
		$extension=array_pop($explode);
		$nombre_archivo = $tipo_documento."_".$clave_propiedad.".".$extension;
		$mysqli = connectdb();
		$resultado = $mysqli->query("UPDATE `documentos` SET `nombre_archivo`='".$nombre_archivo."', `descripcion` ='".$descripcion."' where `clave_propiedad`=".$clave_propiedad." and tipo_documento='".$tipo_documento."'");
		unconnectdb($mysqli);
		return $resultado;
	}

	function guardaArchivos($cadena){
		$descadena = explode('///', $cadena);
		$clave_propiedad = $descadena[0];
        $tipo_documento = $descadena[1];
        $archivo = $descadena[2];
        $descripcion = $descadena[3];
        $explode= explode(".", $archivo);
		$extension=array_pop($explode);
		$nombre_archivo = $tipo_documento."_".$clave_propiedad.".".$extension;
		$mysqli = connectdb();
		$resultado = $mysqli->query("INSERT INTO `documentos` (`clave_propiedad`, `tipo_documento`, `nombre_archivo`, `descripcion`) VALUES (".$clave_propiedad.", '".$tipo_documento."', '".$nombre_archivo."', '".$descripcion."')");
		unconnectdb($mysqli);
		return $resultado;
	}
	function listaArchivos($clave){
		$mysqli = connectdb();
		// $resultado = $mysqli->query("SELECT * FROM documentos WHERE clave_cliente=".$clave." or clave_cliente in (SELECT clave from contactos where clave_padre=".$clave.")");
		$resultado = $mysqli->query("SELECT * FROM documentos WHERE clave_propiedad=".$clave);
		unconnectdb($mysqli);
		return $resultado;
	}
	function ultimaClaveMasUno(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT MAX(clave)+1 as clave from propiedades");
		$row = mysqli_fetch_object($resultado);
		unconnectdb($mysqli);
		return $row->clave;
	}
	function eliminaProp($clave,$valor){
		$query = "UPDATE propiedades set estatus = 6, valor_vendido = ".$valor." where clave =".$clave;
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
?>