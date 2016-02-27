<?php
	include("../../connect_db/connect_db.php");
	
	function repIncrementos($txtfiltronombre){
		$filtro = "";
		if($txtfiltronombre != ''){$filtro = " where contactos.nombre LIKE '%".$txtfiltronombre."%'";}
		$query ="SELECT fechas.clave_renta,propiedades.`nombre` as propiedad, contactos.`nombre`, fechas.`inicioContrato`, fechas.`fechaTerminoContrato`, fechas.fechaRenovacion,renta.`montoInicial`, cortes.`monto` as incrementos, renta.monedaMonto
				from fechas_contratos as fechas
					left join propiedades_renta as renta on renta.`id` = fechas.`clave_renta`
					left join cortes on cortes.`claveRenta` = fechas.clave_Renta and cortes.corte = DATE_FORMAT(fechas.fechaRenovacion, '%Y%m')
					left join contactos on contactos.`clave`=renta.`clave_arrendatario`
					left join propiedades on propiedades.`clave`=renta.`clave_propiedad`
				".$filtro."
				group by fechas.id 
				order by clave_renta,fechas.id;";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}

	function repPendFactClientes($filtroFecha){
		// $filtroFecha = "and cortes.corte = DATE_FORMAT(NOW(), '%Y%m')";
		// $filtroFecha = "";
		$query ="SELECT cortes.corte, rentas.clave_arrendatario, contactos.nombre, cortes.monto
				from cortes 
					inner join propiedades_renta as rentas on cortes.`claveRenta`=rentas.`id` 
					left join contactos on contactos.clave = rentas.`clave_arrendatario`
				where cortes.facturado=0 ".$filtroFecha." 
				group by contactos.nombre, cortes.corte
				order by contactos.nombre, cortes.corte;";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}

	function repMontoXPropiedad(){
		$query ="SELECT renta.id, renta.clave_propiedad, propiedades.nombre,renta.fechaTerminoContrato, renta.montoActual 
				from propiedades_renta as renta
					inner join propiedades on propiedades.`clave` = renta.`clave_propiedad`;";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function repVendidas($txtfiltroPropiedad){
		$filtro = "";
		if($txtfiltroPropiedad != ''){$filtro = " and propiedades.nombre LIKE '%".$txtfiltroPropiedad."%'";}
		$query ="SELECT propiedades.clave, propiedades.nombre, propiedades.valor_inicial, propiedades.valor_vendido, SUM(cortes.`monto`) as rentas from propiedades left join cortes on cortes.clavePropiedad = propiedades.clave where propiedades.estatus=6 ".$filtro." group by propiedades.clave;";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function repPropiedad($txtFiltroPropiedad,$txtFiltroPropietario){
		$query ="SELECT prop.`clave`, prop.`nombre`, propietario.nombre as `propietario`, (prop.`valor_inicial` * prop.cambio) as valor_inicial, SUM(cortes.`monto`) as generado, cortes.`monto`
				from `propiedades` as prop
					left join cortes on cortes.`clavePropiedad`= prop.`clave`
					left join propietario on propietario.`clave` = prop.`propietario`
				WHERE prop.`nombre` LIKE '%".$txtFiltroPropiedad."%' and `propietario` LIKE '%".$txtFiltroPropietario."%'
				GROUP BY prop.clave;";
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function repRentabilidad($txtFiltroCliente,$txtFiltroEmpresa){
		$query ="SELECT cliente.`clave`,cliente.`nombre`,propietario.`nombre` as empresa,tipo.`descripcion`,propiedad.`valor_inicial`,propiedad.`tipo_moneda`,propiedad.`adquisicion`, (SELECT SUM(cortes.`monto`) from cortes where cortes.`claveRenta`=renta.`id`) as ingresos,SUM(cortes.`monto`) as recuperado,propiedad.`valorGeneradoInicial` ,renta.id as rentaID
				from `propiedades_renta` as renta
					left join contactos as cliente on cliente.`clave`=renta.`clave_arrendatario`
					left join `propiedades` as propiedad on propiedad.`clave` = renta.`clave_propiedad`
					left join `propietario` on propietario.`clave` = propiedad.`propietario`
					left join `tipo_propiedad` as tipo on tipo.`id` = propiedad.`tipo_propiedad`
					left join cortes on propiedad.`clave` =cortes.`clavePropiedad`
				WHERE (renta.`clave_estatus` = 2 OR renta.`clave_estatus` = 4 OR renta.`clave_estatus` = 1) AND cliente.`nombre` LIKE '%".$txtFiltroCliente."%' AND propietario.`nombre` LIKE '%".$txtFiltroEmpresa."%' 
				GROUP BY cliente.`clave`,propiedad.`clave`;";
		
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
	function repClienteRentabilidad($txtFiltroCliente,$txtFiltroEmpresa){
		$query ="SELECT renta.`clave_arrendatario`,contactos.`nombre` as cliente, propietario.`nombre` as empresa, SUM(cortes.monto) as monto, renta.`montoActual`/propiedades.`valor_inicial`*100 as rentabilMensual, renta.`montoActual`/propiedades.`valor_inicial`*100*12 as retabiAnual
				from cortes 
					left join `propiedades_renta` as renta on renta.`id` = cortes.`claveRenta`
					left join contactos on renta.`clave_arrendatario` = contactos.`clave`
					left join propiedades on propiedades.`clave` = renta.`clave_propiedad`
					left join propietario on propiedades.`propietario` = propietario.`clave`
				where cortes.`claveRenta` IN (select id from `propiedades_renta` where `propiedades_renta`.`clave_arrendatario` = renta.`clave_arrendatario`) AND contactos.`nombre` LIKE '%".$txtFiltroCliente."%' AND propietario.`nombre` LIKE '%".$txtFiltroEmpresa."%'
				group by renta.`clave_arrendatario`;";
		
		$mysqli = connectdb();
		$resultado = $mysqli->query($query);
		unconnectdb($mysqli);
		return $resultado;
	}
?>