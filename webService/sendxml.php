<?php

function mandaXML($url,$post_string){

  $header  = "POST hms.hsplatform.com/webservice HTTP/1.0 \r\n";
  $header .= "Content-type: text/xml; charset=UTF-8 \r\n";
  $header .= "Content-length: ".strlen($post_string)." \r\n";
  $header .= "Content-transfer-encoding: text \r\n";
  $header .= 'SOAPAction: "http://hms.hsplatform.com/webservice" \r\n';
  // $header .= "Connection: close \r\n\r\n"; 
  $header .= $post_string;


  // $header = "POST hms.hsplatform.com/webservice HTTP/1.0 \r\n";
  // $header .= "Host: hms.hsplatform.com/webservice \r\n";
  // $header .= "User-Agent: NuSOAP/0.7.3 (1.114) \r\n";
  // $header .= "Content-Type: text/xml; charset=UTF-8 \r\n";
  // $header .= "Content-length: ".strlen($post_string)." \r\n";
  // $header .= 'SOAPAction: "http://hms.hsplatform.com/webservice" \r\n';
  // // $header .= "Connection: close \r\n\r\n"; 
  // $header .= $post_string;

  // $header  = "POST HTTP/1.0 \r\n";
  // $header .= "Content-type: text/xml \r\n";
  // $header .= "Content-length: ".strlen($post_string)." \r\n";
  // $header .= "Content-transfer-encoding: text \r\n";
  // $header .= "Connection: close \r\n\r\n"; 
  // $header .= $post_string;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 4);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $header);

  $data = curl_exec($ch); 
  // echo $data;

  if(curl_errno($ch))
      print curl_error($ch);
  else{
    curl_close($ch);
  }
  return $data;
      
}

$url = "http://hms.hsplatform.com/webservice";

$post_string = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:tns="http://PLATAFORMA.hsplatform.com/webservice/?wsdl">
  <SOAP-ENV:Body>
    <tns:recibeTipoPropiedad xmlns:tns="http://hms.hsplatform.com/webservice/?wsdl">
      <Key>rtp123</Key>
      <Action>1</Action>
      <clave_propiedad>7</clave_propiedad>
      <descripcion>Tipo subido 1</descripcion>
      <activo>true</activo>
    </tns:recibeTipoPropiedad>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';

$respuesta = mandaXML($url,$post_string);
// echo $respuesta;
// Host: PLATAFORMA.hsplatform.com/webservice
// User-Agent: NuSOAP/0.7.3 (1.114)

// SOAPAction: "http://PLATAFORMA.hsplatform.com/webservice"

  

?>