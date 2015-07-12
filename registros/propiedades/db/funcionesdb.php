<?php
	function connectdb(){
		$connectdb = new mysqli("localhost", "root", "root", "kalilhel");
		mysqli_set_charset( $connectdb, 'utf8' );
		return $connectdb;
	}
	function unconnectdb($connectdb){
		$connectdb->close();
	}
	function recuperaPropiedades(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT clave, nombre, monto_inquilino FROM propiedades");
		unconnectdb($mysqli);
		return $resultado;
	}
	function unaPropiedad($clave){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT clave, nombre, monto_inquilino FROM propiedades WHERE clave=".$clave);
		unconnectdb($mysqli);
		return $resultado;
	}
	function listadoCaracteristicas(){
		$mysqli = connectdb();
		$resultado = $mysqli->query("SELECT clave, nombre, tipo FROM lista_caracteristicas");
		unconnectdb($mysqli);
		return $resultado;
	}
	function buscaCaractPropiedad($clavePropiedad){
		$mysqli = connectdb();
		$query  = "select carac.clave, lista.nombre,carac.valor,lista.tipo from caracteristicas as carac";
		$query .= " inner join lista_caracteristicas as lista on lista.clave=carac.clave_caracteristica";
		$query .= " where carac.clave_propiedad=".$clavePropiedad;
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function agregaCaract($valores){
		list($claveP, $ClaveC, $valor) = split('@', $valores);
		$query = "INSERT INTO `caracteristicas` (`clave_propiedad`, `clave_caracteristica`, `valor`) VALUES (".$claveP.", ".$ClaveC.", '".$valor."');";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
?>