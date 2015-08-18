<?php
	include "../db/funcionesdb.php";
	$funsion = $_POST['funsion'];
	// $funsion = "sincClientes";
	switch ($funsion) {
		case 'sincClientes': sincClientes(); break;
		case 'sincPropiedades': sincPropiedades(); break;
		case 'syncRentas': syncRentas(); break;
		case 'actualizaCostos': actualizaCostos(); break;
			
		
		default:
			# code...
			break;
	}
	function sincClientes(){

		
		$xmlClientes = simplexml_load_file("http://hms.hsplatform.com/xml/?xml=vNdUWEYLaCfZsH9A_ClientesXML");
		if($xmlClientes != ""){
			$objeto = (object) array();

			    foreach ($xmlClientes as $xml){

			    	$arrendatario = (object) array(
						'a'.$xml->IDCliente => (object) array(
							'fechaRegistro' => $xml->Fechaderegistro,
							'clave' => $xml->IDCliente,
							'tipoCliente' => '1',
							'nombre' => $xml->RazonSocial,
							'Email' => $xml->Email,
							'telefonoCasa' => '('.$xml->TelefonoCasaClaveLD.')'.$xml->TelefonoCasaTelefono,
							'telefonoCel' => '('.$xml->MovilClaveLD.')'.$xml->MovilTelefono,
							'telefonoOficina' => '('.$xml->TelefonoTrabajoClaveLD.')'.$xml->TelefonoTrabajoTelefono,
							'rfc' => $xml->RFC,
							'direccion' => $xml->DireccionPrincipalCalle,
							'ext' => $xml->DireccionPrincipalNumExt,
							'int' => $xml->DireccionPrincipalNumInt,
							'cp' => $xml->DireccionPrincipald4,
							'colonia' => $xml->DireccionPrincipald8,
							'ciudad' => $xml->DireccionPrincipald7,
							'estado' => $xml->DireccionPrincipald5,
							'moroso' => $xml->Moroso,
							'metododepago' => $xml->Metododepago,
							'contacto' => (object) array(
								'c'.$xml->Clave => (object) array(
									'clave_contacto' => $xml->Clave,
									'clave_padre' => $xml->IDCliente,
									'tipoCliente' => $xml->TipodeContacto,
									'nombre' => $xml->NombreNombre." ".$xml->NombreApellidoPaterno." ".$xml->NombreApellidoMaterno,
									'Email' => $xml->email,
									'telefonoCasa' => "(".$xml->TelefonoCasaClaveLD.") ".$xml->TelefonoCasaTelefono,
									'telefonoCel' => "(".$xml->MovilClaveLD.") ".$xml->MovilTelefono,
									'telefonoOficina' => "(".$xml->TelefonoTrabajoClaveLD.") ".$xml->TelefonoTrabajoTelefono,
									'direccion' => $xml->DireccionContactoCalle,
									'ext' => $xml->DireccionContactoNumExt,
									'int' => $xml->DireccionContactoNumInt,
									'cp' => $xml->DireccionContactod4,
									'colonia' => $xml->DireccionContactod8,
									'ciudad' => $xml->DireccionContactod7,
									'estado' => $xml->DireccionContactod5,
								),
							),
							'ultimaFecha' => $xml->UltimaModificacion
						)
					);
		 			$arrayClientes[]=$arrendatario;
		 			// $clientesJSON = json_encode($arrayClientes);
					
				}

			    $regFlag = 0;
			    // registraEvento("clientes","descarga",$clientes->ultimaFecha);
			    // print_r($arrayClientes);
				foreach ($arrayClientes as $key => $reg) {
					
					foreach ($reg as $key2 => $value) {
						
						// $clientesJSON = json_encode($value);
						$ultimaSinc = ultimaSinc();
						$nuevaUltimaFecha = arrglaFecha($value->ultimaFecha);
						$fecha1 = new DateTime($nuevaUltimaFecha);

						$fecha2 = new DateTime($ultimaSinc);
						$interval = $fecha1->diff($fecha2); // fecha2 - fecha1
						
						if($interval->invert=="1"){ // [invert] => 0 [y] => 0 [m] => 0 [d] => 0 [h] => 1 [i] => 0 [s] => 0 
							$resultado = insertaClientes($value);
							if($resultado == 1) $regFlag=1;

							foreach ($value->contacto as $key3 => $subvalue) {
								if($subvalue->clave_contacto != '0'){
									$res=insertaContactos($subvalue,arrglaFecha($value->fechaRegistro));
									if($res == 1) $regFlag=1;
									// if($res == 1 && $regFlag==1){
									// 	// registraEvento("contactos","descarga");
									// 	$regFlag=0;
									// }
								}
								
							}
							
						}
		
					}
						
				}
				if($regFlag==1){
					$r = registraEvento("clientes","descarga");
					$regFlag=0;
				}
				
				// print_r($arrendatario);
				// echo "-----------";
				echo "LISTO";
		}
		else{ echo "FAIL"; }
			
		
	}

	function sincPropiedades(){
		$regFlag = 0;
		$xmlPropiedades = simplexml_load_file("http://hms.hsplatform.com/xml/?xml=Hhu2VqT3t4qj6nTQ_PropiedadesXML");

		foreach ($xmlPropiedades as $key => $value) {
			$resultado = insertaPropiedades($value);
			if($resultado == 1) $regFlag=1;
		}
		if($regFlag==1){
			$r = registraEvento("propiedades","descarga");
			$regFlag=0;
		}
		
		// fechaRegistro
		// clave 				.Propiedad
		// nombre 				.NombrePropiedad
		// tipo_propiedad 		.TipodePropiedadTipodepropiedadCodigo TipodePropiedadTipodepropiedadDescripcion
		// propietario 		.PropietarioPropietariosCodigo PropietarioPropietariosNombre
		// paga_mantenimiento 	.Pagamantenimiento
		// direccion 			.DireccionCalle
		// ext 				.DireccionNumExt
		// int 				.DireccionNumInt
		// colonia 			.Direcciond8
		// cp 					.Direcciond4
		// ciudad 				.Direcciond7
		// estado 				.Direcciond6 Direcciond5
		// valor_inicial
		// tipo_moneda
		// cambio
		// adquisicion
		// valor_actual
		// monto_inquilino

	}

	function actualizaCostos(){
		$xmlRentas = simplexml_load_file("xml/xml20150815_HISTORICO.xml");
		foreach ($xmlRentas as $key => $xml) {
			$obj = (object) array(
				'factura' => array( 
						'folio' => $xml->Folio, 
						'fecha' => $xml->Fecha, 
						'monto' => $xml->ImportetotalMonto, 
						'concepto' => $xml->Conceptocompleto
					
				)
			);
			echo actualizaCosto($obj);
		}

	}

	function syncRentas(){
		$regFlag = 0;
		$duracion = 1;
		$xmlRentas = simplexml_load_file("xml/xml20150808_HISTORICO.xml");
		
		$var = 1;
		$arrRentas1 = array();
		foreach ($xmlRentas as $key => $xml) {
			if ($var == 1) {
				$duracion = 1;
				$obj = (object) array(
					'renta' => array(
						'cliente' => $xml->IDCliente, 
						'propiedad' => $xml->PropiedadesPropiedadesPropiedad
					),
					'fechaRegistro' => $xml->Fecha,
					'fechaInicioFacturacion' => $xml->Fecha,
					'fechaTermino' => $xml->Fecha,
					'montoInicial' => $xml->ImportetotalMonto,
					'montoActual' => $xml->ImportetotalMonto,
					'pagaMantenimiento' => $xml->Pagamantenimiento,
					'concepto' => $xml->Conceptocompleto,
					'duracion' => $duracion,
					'factura' => array( [ 
							'folio' => $xml->Folio, 
							'fecha' => $xml->Fecha, 
							'monto' => $xml->ImportetotalMonto, 
							'concepto' => $xml->Conceptocompleto
						]
						
					)
				);
				$var = 0;

			}
			else{ 
				if(intval($xml->IDCliente) == $obj->renta['cliente'] && intval($xml->PropiedadesPropiedadesPropiedad) == $obj->renta['propiedad']){
					$duracion ++;
					$obj->fechaTermino = $xml->Fecha;
					$obj->montoActual = $xml->ImportetotalMonto;
					$obj->duracion = $duracion;
					$obj->concepto = $xml->Conceptocompleto;
					$obj->factura[] = array(
								'folio' => $xml->Folio, 
								'fecha' => $xml->Fecha, 
								'monto' => $xml->ImportetotalMonto, 
								'concepto' => $xml->Conceptocompleto );
					
				}
				else{
					$var = 1;
					$arrRentas1[] = $obj;

				} 
			
				

			// $obj->factura[] = array(
			// 			'folio' => $xml->Folio, 
			// 			'fecha' => $xml->Fecha, 
			// 			'monto' => $xml->ImportetotalMonto, 
			// 			'concepto' => $xml->Conceptocompleto);
			
			}
		}
		foreach ($arrRentas1 as $key => $arrRentas) {
			generaRentas($arrRentas);
			$ultimoIdRenta = buscaUltimaRenta();
			foreach ($arrRentas->factura as $key2 => $value) {
				// print_r($arrRentas->renta['propiedad']);
				generaCortes($value,$ultimoIdRenta,$arrRentas->renta['propiedad']);
			}
		}
		// $fechaRegistro = explode(' ', $arrRentas[0]->fechaRegistro);
		// $fechaTermino = explode(' ', $arrRentas[0]->fechaTermino);
		// $fechaInicioFacturacion = explode(' ', $arrRentas[0]->fechaInicioFacturacion);
		// $fechaFactura = explode(' ', $arrRentas[0]->factura[0]['fecha']);
		// $montoInicial = str_replace(',','',$arrRentas[0]->montoInicial);
		// $montoActual = str_replace(',','',$arrRentas[0]->montoActual);
		// $montoFactura = str_replace(',','',$arrRentas[0]->factura[0]['monto']);
		// print_r($arrRentas[0]->factura[0]['fecha']);
		// $q = [0]->factura[0]['fecha'];
		// print_r($fechaFactura);
		

		

		// $query = "INSERT INTO `propiedades_renta` (`fechaRegistro`, `clave_propiedad`, `clave_arrendatario`, `inicioContrato`, `duracion`, `tipoDuracion`, `montoInicial`, `montoActual`, `deposito`, `regresaDeposito`, `gracia`, `inicioFacturacion`, `mantenimiento`, `montoMantenimiento`, `consepto`, `clave_estatus`, `fechaTerminoContrato`)
		// 		VALUES
		// 		('".arrglaFecha($fechaRegistro[0])."', ".$arrRentas[0]->renta['propiedad'].", ".$arrRentas[0]->renta['cliente'].", '".arrglaFecha($fechaRegistro[0])."', ".$arrRentas[0]->duracion.", 'meses', ".$montoInicial.", ".$montoActual.", 0, 0, 0, '".$fechaInicioFacturacion."', 0, 0, '".$arrRentas[0]->concepto."', 1, '".arrglaFecha($fechaTermino[0])."');";
		
		// $query = "select max(id) from propiedades_renta";

		// $query = "INSERT INTO `cortes` (`claveRenta`, `clavePropiedad`, `fechaCorte`, `facturado`, `factura`, `monto`, `pagado`, `fechaPago`, `corte`)
		// 		VALUES ('renta->id', ".$arrRentas[0]->renta['propiedad'].", '".arrglaFecha($fechaFactura[0])."', 1, '".$arrRentas[0]->factura[0]['folio']."',".$montoFactura.", 0, NULL, DATE_FORMAT('".arrglaFecha($fechaFactura[0])."', '%Y%m'))";
		




		// echo $query;
		// {fechaRegistro, inicioFacturacion} - Fecha
		// Folio
		// IDCliente
		// ClienteClientesKalilhelRazonSocial
		// clave_propiedad - PropiedadesPropiedadesPropiedad
		// mantenimiento - Pagamantenimiento
		// consepto - Conceptocompleto
		// {montoInicial, montoActual} - ImportetotalMonto
		// clave_estatus - 
		// fechaTerminoContrato - 
	}
			
	function arrglaFecha($fechaMal){
		$fechaXML = "13.Oct.14 17:35:04";
		$s = explode(' ', $fechaMal);
		$fecha = explode('.',$s[0]);
		$dia = $fecha[0];
		$mesLetra = $fecha[1];
		$anio4d = "20".$fecha[2];
		// echo $interval->format('%R%a')+0;
		switch ($mesLetra) {
			case 'Ene': $mes = '01'; break;
			case 'Feb': $mes = '02'; break;
			case 'Mar': $mes = '03'; break;
			case 'Abr': $mes = '04'; break;
			case 'May': $mes = '05'; break;
			case 'Jun': $mes = '06'; break;
			case 'Jul': $mes = '07'; break;
			case 'Ago': $mes = '08'; break;
			case 'Sep': $mes = '09'; break;
			case 'Oct': $mes = '10'; break;
			case 'Nov': $mes = '11'; break;
			case 'Dic': $mes = '12'; break;
			
			default:
				$mes = '01';
				break;
		}
		if(isset($s[1])){
			return $anio4d."-".$mes."-".$dia." ".$s[1];
		}
		return $anio4d."-".$mes."-".$dia;
			
	}
?>