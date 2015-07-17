<?php
	$xmlClientes = simplexml_load_file("xml/xml20150716_ClientesXML.xml");

	   foreach ($xmlClientes as $xml) {
	    
	      $arrayClientes[]=$xml;
	     
	    }
	 print_r($arrayClientes[0]);
13.Oct.14 17:35:04
$interval = $datetime1->diff($datetime2);

	  
	 
    
?>


//////  SQL  /////

id 					.[IDCliente] => 11 
clave 				.[Clave] => 0 
clave_padre			.---
tipoCliente 		.[TipodeContacto] => 
nombre 				.[RazonSocial] => HIGH MANAGEMENT SOLUTIONS 
Email 				.[Email] => paul@hmsolutions.mx 
telefono 			.
rfc 				.[RFC] => Array ( [0] => HSO120813B92 
direccion 			.[DireccionCalle] => Array ( [0] => CERRADA VALLE DE LA PLATA
ext 				.[DireccionNumExt] => Array ( [0] => 12 
int 				.[DireccionNumInt] => Array ( [0] => 
cp 					.[Direcciond4] => Array ( [0] => 76269 
colonia				.[Direcciond8] => Array ( [0] => LA PRADERA
ciudad 				.[Direcciond7] => Array ( [0] => EL MARQUES
estado 				.[Direcciond5] => Array ( [0] => QUERETARO
moroso 				.[Moroso] => 
metododepago 		.[Metododepago] => NO IDENTIFICADO 
					.[NombreNombre] => 
					.[NombreApellidoPaterno] => 
					.[NombreApellidoMaterno] => 
					.[email] => 
					.[TipodeContacto] => 
					.[TelefonoCasaClaveLD] => 
					.[TelefonoCasaTelefono] => 
					.[MovilClaveLD] => 
					.[MovilTelefono] => 
					.[TelefonoTrabajoClaveLD] => 
					.[TelefonoTrabajoTelefono] => S
					.[UltimaModificacion] => 13.Oct.14 17:35:04

/////  XML  /////

SimpleXMLElement Object ( 
	[IDCliente] => 11 
	[Fechaderegistro] => 01.Oct.13 
	[Activo] => Si 
	[RazonSocial] => HIGH MANAGEMENT SOLUTIONS 
	[RFC] => Array ( 
		[0] => HSO120813B92 
		[1] => SimpleXMLElement Object ( ) 
	) 
	[DireccionCalle] => Array ( 
		[0] => CERRADA VALLE DE LA PLATA 
		[1] => SimpleXMLElement Object ( ) 
	) 
	[DireccionNumExt] => Array ( 
		[0] => 12 [1] => SimpleXMLElement Object ( ) 
	) 
	[DireccionNumInt] => Array ( 
		[0] => SimpleXMLElement Object ( ) 
		[1] => SimpleXMLElement Object ( ) 
	) 
	[Direcciond4] => Array ( 
		[0] => 76269 
		[1] => SimpleXMLElement Object ( ) 
	) [Direcciond3] => Array ( 
		[0] => SimpleXMLElement Object ( ) 
		[1] => SimpleXMLElement Object ( ) 
	) 
	[Direcciond8] => Array ( 
		[0] => LA PRADERA [1] => SimpleXMLElement Object ( ) 
	) 
	[Direcciond7] => Array ( [0] => EL MARQUES [1] => SimpleXMLElement Object ( ) ) 
	[Direcciond6] => Array ( [0] => SimpleXMLElement Object ( ) [1] => SimpleXMLElement Object ( ) ) 
	[Direcciond5] => Array ( [0] => QUERETARO [1] => SimpleXMLElement Object ( ) ) 
	[Direcciond10] => Array ( [0] => MÉXICO [1] => SimpleXMLElement Object ( ) ) 
	[Email] => paul@hmsolutions.mx 
	[UltimaModificacion] => 13.Oct.14 17:35:04 
	[Metododepago] => NO IDENTIFICADO 
	[Nodecuenta] => 1234 
	[Banco] => SimpleXMLElement Object ( ) 
	[PaginaWeb] => SimpleXMLElement Object ( ) 
	[VentasaCredito] => No 
	[DiasdeCredito] => 30 
	[Descuento] => % 
	[IVA] => Si 
	[FactorIVA] => 1 
	[PermiteFacturar] => Si 
	[FechadeActualizacion] => 13.Oct.14 17:35:04 
	[Moroso] => SimpleXMLElement Object ( ) 
	[Factura] => SimpleXMLElement Object ( ) 
	[Clave] => 0 
	[NombreNombre] => SimpleXMLElement Object ( ) 
	[NombreApellidoPaterno] => SimpleXMLElement Object ( ) 
	[NombreApellidoMaterno] => SimpleXMLElement Object ( ) 
	[email] => SimpleXMLElement Object ( ) 
	[TipodeContacto] => SimpleXMLElement Object ( ) 
	[TelefonoCasaClaveLD] => SimpleXMLElement Object ( ) 
	[TelefonoCasaTelefono] => SimpleXMLElement Object ( ) 
	[MovilClaveLD] => SimpleXMLElement Object ( ) 
	[MovilTelefono] => SimpleXMLElement Object ( ) 
	[TelefonoTrabajoClaveLD] => SimpleXMLElement Object ( ) 
	[TelefonoTrabajoTelefono] => SimpleXMLElement Object ( ) )














SimpleXMLElement Object ( [IDCliente] => 45 [Fechaderegistro] => 01.Oct.13 [Activo] => Si [RazonSocial] => 7-ELEVEN MEXICO SA DE CV [RFC] => Array ( [0] => SEM980701STA [1] => SimpleXMLElement Object ( ) ) [DireccionCalle] => Array ( [0] => AV. MUNICH [1] => SimpleXMLElement Object ( ) ) 
[DireccionNumExt] => Array ( [0] => 195 [1] => SimpleXMLElement Object ( ) ) [DireccionNumInt] => Array ( [0] => B [1] => SimpleXMLElement Object ( ) ) [Direcciond4] => Array ( [0] => 66450 [1] => SimpleXMLElement Object ( ) ) 
[Direcciond3] => Array ( [0] => SimpleXMLElement Object ( ) [1] => SimpleXMLElement Object ( ) ) [Direcciond8] => Array ( [0] => CUAUHTÉMOC [1] => SimpleXMLElement Object ( ) ) [Direcciond7] => Array ( [0] => SAN NICOLÁS DE LOS GARZA [1] => SimpleXMLElement Object ( ) ) [Direcciond6] => Array ( [0] => SAN NICOLÁS DE LOS GARZA [1] => SimpleXMLElement Object ( ) ) [Direcciond5] => Array ( [0] => NUEVO LEÓN [1] => SimpleXMLElement Object ( ) ) [Direcciond10] => Array ( [0] => MÉXICO [1] => MÉXICO ) 
[Email] => luis.valle@7-eleven.com.mx [UltimaModificacion] => 16.Jul.15 18:58:57 [Metododepago] => TRANSFERENCIA ELECTRÓNICA DE FONDOS [Nodecuenta] => 4051 [Banco] => BANAMEX [PaginaWeb] => SimpleXMLElement Object ( ) [VentasaCredito] => No [DiasdeCredito] => 0 [Descuento] => % [IVA] => Si [FactorIVA] => 1 [PermiteFacturar] => Si [FechadeActualizacion] => 16.Jul.15 18:58:57 [Moroso] => SimpleXMLElement Object ( ) [Factura] => SimpleXMLElement Object ( ) 
[Clave] => 1 
[NombreNombre] => N1 
[NombreApellidoPaterno] => AP1 
[NombreApellidoMaterno] => AM1 
[email] => SimpleXMLElement Object ( ) 
[TipodeContacto] => CONTACTO 
[TelefonoCasaClaveLD] => SimpleXMLElement Object ( ) [TelefonoCasaTelefono] => SimpleXMLElement Object ( ) 
[MovilClaveLD] => SimpleXMLElement Object ( ) [MovilTelefono] => SimpleXMLElement Object ( ) 
[TelefonoTrabajoClaveLD] => SimpleXMLElement Object ( ) [TelefonoTrabajoTelefono] => SimpleXMLElement Object ( ) )














