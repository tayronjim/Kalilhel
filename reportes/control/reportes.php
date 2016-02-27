<?php
	require('control.php');
	require('../pdf/fpdf.php');

		
class PDF extends FPDF{
	function Footer(){
		// Posición a 1,5 cm del final
		$this->SetY(-15);
		// Arial itálica 8
		$this->SetFont('Arial','I',8);
		// Color del texto en gris
		$this->SetTextColor(128);
		// Número de página
		$this->Cell(0,10,'Pagina '.$this->PageNo(),0,0,'C');
	}
	// Tabla coloreada
	function imprimeReportePropiedades($header,$data){
		global $title;
		$this->Image('../../css/img/logoKalilhel.png',10,8,23);
		// Arial bold 15
		$this->SetFont('Arial','B',17);
		// Calculamos ancho y posición del título.
		$w = $this->GetStringWidth($title)+6;
			$this->SetY(14);
		$this->SetX((300-$w)/2);

		// Colores de los bordes, fondo y texto
		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		// Ancho del borde (1 mm)
		$this->SetLineWidth(1);
		// Título
		$this->Cell($w,9,$title,1,1,'C',true);
		// Salto de línea
		$this->Ln(10);
	    // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B',9);
	    // Cabecera
	    foreach ($header as $key => $head) {
	    	$y=$this->GetY(); 
	    	$x=$this->GetX();
	    	$this->MultiCell($head->w,7,$head->titulo,1,'C',true);
	    	 
        	
	    	$this->SetXY($x+$head->w,$y);
	    }
	    // $w = array(40, 35, 45, 40);
	    // for($i=0;$i<count($header);$i++)
	        
	    $this->Ln();
	    // Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('Arial','',7);
	    // Datos 
	    $fill = false;
	    $newdata = json_decode($data);
	    foreach($newdata->Reporte as $row)
	    {
	    	$renMensual = ($row->monto/$row->valor_inicial)*100;
	    	$rendAnual = round($renMensual,2)*12;
	    	$recuperado = ($row->valor_inicial - $row->generado);

	        $this->Cell($header->h1->w,6,$row->nombre,'LR',0,'L',$fill);
	        $this->Cell($header->h2->w,6,$row->propietario,'LR',0,'L',$fill);
	        $this->Cell($header->h3->w,6,number_format($row->valor_inicial,2),'LR',0,'R',$fill);
	        $this->Cell($header->h4->w,6,number_format($renMensual,2)." %",'LR',0,'R',$fill);
	        $this->Cell($header->h5->w,6,number_format($rendAnual,2)." %",'LR',0,'R',$fill);
	        $this->Cell($header->h5->w,6,number_format($row->generado,2)."",'LR',0,'R',$fill);
	        $this->Cell($header->h5->w,6,number_format($recuperado,2)."",'LR',0,'R',$fill);
	        $this->Ln();
	        $fill = !$fill;
	    }
	    	$this->Cell($header->h1->w,6,'','LRB',0,'L',$fill);
	        $this->Cell($header->h2->w,6,'','LRB',0,'L',$fill);
	        $this->Cell($header->h3->w,6,'','LRB',0,'R',$fill);
	        $this->Cell($header->h4->w,6,'','LRB',0,'R',$fill);
	        $this->Cell($header->h5->w,6,'','LRB',0,'R',$fill);
	        $this->Cell($header->h5->w,6,'','LRB',0,'R',$fill);
	        $this->Cell($header->h5->w,6,'','LRB',0,'R',$fill);
	        $this->Ln();
	        $fill = !$fill;
	    // Línea de cierre
	    // $this->Cell(array_sum($w),0,'','T');
	}

	function imprimeReporteIncrementos($header,$data){
		global $title;
		$this->Image('../../css/img/logoKalilhel.png',10,8,23);
		// Arial bold 15
		$this->SetFont('Arial','B',17);
		// Calculamos ancho y posición del título.
		$w = $this->GetStringWidth($title)+6;
			$this->SetY(14);
		$this->SetX((300-$w)/2);
		// Colores de los bordes, fondo y texto
		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		// Ancho del borde (1 mm)
		$this->SetLineWidth(1);
		// Título
		$this->Cell($w,9,$title,1,1,'C',true);
		// Salto de línea
		$this->Ln(10);
	    // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B',9);
	    
	    foreach ($header as $key => $head) {
	    	$y=$this->GetY(); 
	    	$x=$this->GetX();
	    	$h = 10;
	    	if ($this->GetStringWidth($head->titulo) > $head->w) {
	    		$h = 5;
	    	}
	    	else $h = 10;
	    	$this->MultiCell($head->w,$h,$head->titulo,1,'C',true);
	    	 
	    	$this->SetXY($x+$head->w,$y);
	    }
	        
	    $this->Ln();
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('Arial','',7);
	    $fill = false;
	    $newdata = json_decode($data);
	    $tablaBordes = "LR";
	    $id=0;
	    foreach($newdata->Reporte as $row)
	    {
	    	$incrementos = $row->incrementos;
	    	if($row->incrementos == null){$incrementos = $row->montoInicial;}

	    	

	        $this->Cell($header->h1->w,6,$row->nombre,$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h2->w,6,$row->propiedad,$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h3->w,6,$row->inicioContrato,$tablaBordes,0,'C',$fill);
	        $this->Cell($header->h4->w,6,$row->fechaTerminoContrato."",$tablaBordes,0,'C',$fill);
	        $this->Cell($header->h5->w,6,$row->fechaRenovacion."",$tablaBordes,0,'C',$fill);
	        
	        $this->Cell($header->h6->w,6,number_format($incrementos,2)."",$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h7->w,6,$row->monedaMonto."",$tablaBordes,0,'C',$fill);
	        $this->Ln();
	        $fill = !$fill;
	        $tablaBordes = "LR";
	    }
	    	$tablaBordes = "LRB";
	    	$this->Cell($header->h1->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h2->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h3->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h4->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h5->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h6->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h7->w,6,'',$tablaBordes,0,'R',$fill);
	        
	        $this->Ln();
	        $fill = !$fill;
	}

	function imprimeReporteRentabilidad($header,$data){
		global $title;
		$this->Image('../../css/img/logoKalilhel.png',10,8,23);
		// Arial bold 15
		$this->SetFont('Arial','B',17);
		// Calculamos ancho y posición del título.
		$w = $this->GetStringWidth($title)+6;
			$this->SetY(14);
		$this->SetX((300-$w)/2);
		// Colores de los bordes, fondo y texto
		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		// Ancho del borde (1 mm)
		$this->SetLineWidth(1);
		// Título
		$this->Cell($w,9,$title,1,1,'C',true);
		// Salto de línea
		$this->Ln(10);
	    // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B',9);
	    
	    foreach ($header as $key => $head) {
	    	$y=$this->GetY(); 
	    	$x=$this->GetX();
	    	$h = 10;
	    	if ($this->GetStringWidth($head->titulo) > $head->w) {
	    		$h = 5;
	    	}
	    	else $h = 10;
	    	$this->MultiCell($head->w,$h,$head->titulo,1,'C',true);
	    	 
	    	$this->SetXY($x+$head->w,$y);
	    }
	        
	    $this->Ln();
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('Arial','',7);
	    $fill = false;
	    $newdata = json_decode($data);
	    $tablaBordes = "LR";
	    $id=0;
	    foreach($newdata->Reporte as $row)
	    {
	    	$incrementos = $row->incrementos;
	    	if($row->incrementos == null){$incrementos = $row->montoInicial;}

	    	$pendiente = $row->valor_inicial - $row->recuperado;
	    	$rentabilidad = ((($row->valorGeneradoInicial + $row->ingresos)/$row->valor_inicial)*100);
	    	

	        $this->Cell($header->h1->w, 6, $row->nombre, $tablaBordes, 0, 'L', $fill);
	        $this->Cell($header->h2->w,6,$row->empresa,$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h3->w,6,$row->descripcion,$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h4->w,6,number_format($row->valor_inicial,2)."",$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h5->w,6,$row->tipo_moneda."",$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h6->w,6,$row->adquisicion."",$tablaBordes,0,'C',$fill);
	        $this->Cell($header->h7->w,6,number_format($row->ingresos,2)."",$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h8->w,6,number_format($row->recuperado,2)."",$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h9->w,6,number_format($pendiente,2)."",$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h10->w,6,number_format($rentabilidad,2)."",$tablaBordes,0,'C',$fill);
	        $this->Ln();
	        $fill = !$fill;
	        $tablaBordes = "LR";
	    }
	    	$tablaBordes = "LRB";
	    	$this->Cell($header->h1->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h2->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h3->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h4->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h5->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h6->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h7->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h8->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h9->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h10->w,6,'',$tablaBordes,0,'R',$fill);
	        
	        $this->Ln();
	        $fill = !$fill;
	}

	function imprimeReportePendientexCliente($header,$data){
		global $title;
		$this->Image('../../css/img/logoKalilhel.png',10,8,23);
		// Arial bold 15
		$this->SetFont('Arial','B',17);
		// Calculamos ancho y posición del título.
		$w = $this->GetStringWidth($title)+6;
			$this->SetY(14);
		$this->SetX((230-$w)/2);
		// Colores de los bordes, fondo y texto
		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		// Ancho del borde (1 mm)
		$this->SetLineWidth(1);
		// Título
		$this->Cell($w,9,$title,1,1,'C',true);
		// Salto de línea
		$this->Ln(10);
	    // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B',11);
	    
	    foreach ($header as $key => $head) {
	    	$y=$this->GetY(); 
	    	$x=$this->GetX();
	    	$h = 10;
	    	if ($this->GetStringWidth($head->titulo) > $head->w) {
	    		$h = 5;
	    	}
	    	else $h = 10;
	    	$this->MultiCell($head->w,$h,$head->titulo,1,'C',true);
	    	 
	    	$this->SetXY($x+$head->w,$y);
	    }
	        
	    $this->Ln();
	    $this->Ln();
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('Arial','',9);
	    $fill = false;
	    $newdata = json_decode($data);
	    $tablaBordes = "LR";
	    $id=0;
	    foreach($newdata->Reporte as $row)
	    {
	    	$incrementos = $row->incrementos;
	    	if($row->incrementos == null){$incrementos = $row->montoInicial;}

	    	$pendiente = $row->valor_inicial - $row->recuperado;
	    	$rentabilidad = ((($row->valorGeneradoInicial + $row->ingresos)/$row->valor_inicial)*100);
	    	
	    	$corte = substr($row->corte,0,4)."-".substr($row->corte,4,7);

	        $this->Cell($header->h1->w, 6, $row->nombre, $tablaBordes, 0, 'L', $fill);
	        $this->Cell($header->h2->w,6, $corte, $tablaBordes,0,'C',$fill);
	        $this->Cell($header->h3->w,6, number_format($row->monto,2), $tablaBordes,0,'R',$fill);
	       
	        $this->Ln();
	        $fill = !$fill;
	        
	    }
	    	$tablaBordes = "LRB";
	    	$this->Cell($header->h1->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h2->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h3->w,6,'',$tablaBordes,0,'R',$fill);
	        
	        
	        $this->Ln();
	        $fill = !$fill;
	}

	function imprimeReporteRentasActuales($header,$data){
		global $title;
		$this->Image('../../css/img/logoKalilhel.png',10,8,23);
		// Arial bold 15
		$this->SetFont('Arial','B',17);
		// Calculamos ancho y posición del título.
		$w = $this->GetStringWidth($title)+6;
			$this->SetY(14);
		$this->SetX((230-$w)/2);
		// Colores de los bordes, fondo y texto
		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		// Ancho del borde (1 mm)
		$this->SetLineWidth(1);
		// Título
		$this->Cell($w,9,$title,1,1,'C',true);
		// Salto de línea
		$this->Ln(10);
	    // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B',11);
	    
	    foreach ($header as $key => $head) {
	    	$y=$this->GetY(); 
	    	$x=$this->GetX();
	    	$h = 10;
	    	if ($this->GetStringWidth($head->titulo) > $head->w) {
	    		$h = 5;
	    	}
	    	else $h = 10;
	    	$this->MultiCell($head->w,$h,$head->titulo,1,'C',true);
	    	 
	    	$this->SetXY($x+$head->w,$y);
	    }
	        
	    $this->Ln();
	    $this->Ln();
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('Arial','',9);
	    $fill = false;
	    $newdata = json_decode($data);
	    $tablaBordes = "LR";
	    $id=0;
	    foreach($newdata->Reporte as $row)
	    {
	    	$incrementos = $row->incrementos;
	    	if($row->incrementos == null){$incrementos = $row->montoInicial;}

	    	$pendiente = $row->valor_inicial - $row->recuperado;
	    	$rentabilidad = ((($row->valorGeneradoInicial + $row->ingresos)/$row->valor_inicial)*100);
	    	
	    	$corte = substr($row->corte,0,4)."-".substr($row->corte,4,7);

	        $this->Cell($header->h1->w, 6, $row->nombre, $tablaBordes, 0, 'L', $fill);
	        $this->Cell($header->h2->w,6, $row->fechaTerminoContrato, $tablaBordes,0,'C',$fill);
	        $this->Cell($header->h3->w,6, number_format($row->montoActual,2), $tablaBordes,0,'R',$fill);
	       
	        $this->Ln();
	        $fill = !$fill;
	        
	    }
	    	$tablaBordes = "LRB";
	    	$this->Cell($header->h1->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h2->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h3->w,6,'',$tablaBordes,0,'R',$fill);
	        
	        
	        $this->Ln();
	        $fill = !$fill;
	}

	function imprimeReportePropiedadesVendidas($header,$data){
		global $title;
		$this->Image('../../css/img/logoKalilhel.png',10,8,23);
		// Arial bold 15
		$this->SetFont('Arial','B',17);
		// Calculamos ancho y posición del título.
		$w = $this->GetStringWidth($title)+6;
			$this->SetY(14);
		$this->SetX((300-$w)/2);
		// Colores de los bordes, fondo y texto
		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		// Ancho del borde (1 mm)
		$this->SetLineWidth(1);
		// Título
		$this->Cell($w,9,$title,1,1,'C',true);
		// Salto de línea
		$this->Ln(10);
	    // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B',9);
	    
	    foreach ($header as $key => $head) {
	    	$y=$this->GetY(); 
	    	$x=$this->GetX();
	    	$h = 10;
	    	if ($this->GetStringWidth($head->titulo) > $head->w) {
	    		$h = 5;
	    	}
	    	else $h = 10;
	    	$this->MultiCell($head->w,$h,$head->titulo,1,'C',true);
	    	 
	    	$this->SetXY($x+$head->w,$y);
	    }
	        
	    $this->Ln();
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('Arial','',7);
	    $fill = false;
	    $newdata = json_decode($data);
	    $tablaBordes = "LR";
	    $id=0;
	    foreach($newdata->Reporte as $row)
	    {
	        $this->Cell($header->h1->w,6,$row->nombre,$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h2->w,6,number_format($row->rentas,2),$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h3->w,6,number_format($row->valor_vendido,2),$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h4->w,6,number_format($row->valor_inicial,2)."",$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h5->w,6,number_format($row->generado,2)."",$tablaBordes,0,'R',$fill);
	        
	        $this->Cell($header->h6->w,6,number_format($porsGenerado,2)." %",$tablaBordes,0,'R',$fill);
	        
	        $this->Ln();
	        $fill = !$fill;
	        $tablaBordes = "LR";
	    }
	    	$tablaBordes = "LRB";
	    	$this->Cell($header->h1->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h2->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h3->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h4->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h5->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h6->w,6,'',$tablaBordes,0,'R',$fill);
	        
	        
	        $this->Ln();
	        $fill = !$fill;
	}
	
	function imprimeReporteClienteRentabiliddad($header,$data){
		global $title;
		$this->Image('../../css/img/logoKalilhel.png',10,8,23);
		// Arial bold 15
		$this->SetFont('Arial','B',17);
		// Calculamos ancho y posición del título.
		$w = $this->GetStringWidth($title)+6;
			$this->SetY(14);
		$this->SetX((300-$w)/2);
		// Colores de los bordes, fondo y texto
		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		// Ancho del borde (1 mm)
		$this->SetLineWidth(1);
		// Título
		$this->Cell($w,9,$title,1,1,'C',true);
		// Salto de línea
		$this->Ln(10);
	    // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B',9);
	    
	    foreach ($header as $key => $head) {
	    	$y=$this->GetY(); 
	    	$x=$this->GetX();
	    	$h = 10;
	    	if ($this->GetStringWidth($head->titulo) > $head->w) {
	    		$h = 5;
	    	}
	    	else $h = 10;
	    	$this->MultiCell($head->w,$h,$head->titulo,1,'C',true);
	    	 
	    	$this->SetXY($x+$head->w,$y);
	    }
	        
	    $this->Ln();
	    $this->Ln();
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('Arial','',7);
	    $fill = false;
	    $newdata = json_decode($data);
	    $tablaBordes = "LR";
	    $id=0;
	    foreach($newdata->Reporte as $row)
	    {
	        $this->Cell($header->h1->w,6,$row->cliente,$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h2->w,6,$row->empresa,$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h3->w,6,number_format($row->monto,2),$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h4->w,6,number_format($row->rentabilMensual,2)."",$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h5->w,6,number_format($row->retabiAnual,2)."",$tablaBordes,0,'R',$fill);
	        
	        
	        
	        $this->Ln();
	        $fill = !$fill;
	        $tablaBordes = "LR";
	    }
	    	$tablaBordes = "LRB";
	    	$this->Cell($header->h1->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h2->w,6,'',$tablaBordes,0,'L',$fill);
	        $this->Cell($header->h3->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h4->w,6,'',$tablaBordes,0,'R',$fill);
	        $this->Cell($header->h5->w,6,'',$tablaBordes,0,'R',$fill);
	        
	        
	        
	        $this->Ln();
	        $fill = !$fill;
	}
}
	
	$reporte = $_GET['reporte'];

	switch ($reporte) {
		case 'propiedades':
			$title="Propiedades";
			reportePropiedades();
			break;
		case 'incrementos':
			$title="Listado de Incrementos";
			reporteListadoIncrementos();
			break;
		case 'rentabilidad':
			$title = 'rentabilidad';
			reporteListadoRentabilidad();
			break;
		case 'pendientexcliente':
			$title = 'Pendiente Facturar por Cliente';
			reporteListadoPendientexCliente();
			break;
		case 'rentasactuales':
			$title = 'Rentas Actuales por Propiedad';
			reporteListadorentasactuales();
			break;
		case 'propiedadesvendidas':
			$title = "Propiedades Vendidas";
			reporteListadoPropiedadesVendidas();
			break;
		case 'clienterentabilidad':
			$title = "Cliente / Rentabilidad";
			reporteListadoClienteRentabilidad();
		default:
			# code...
			break;
	}


	function reportePropiedades(){
		
		$txtFiltroPropiedad = $_GET['filtroPropiedad'];
		$txtFiltroPropietario = $_GET['filtroPropietario'];

		$header=(object) array();
		$header->h1 = (object) array();
		$header->h1->w='50';
		$header->h1->titulo = 'Propiedad';
		$header->h2 = (object) array();
		$header->h2->w='35';
		$header->h2->titulo = 'Propietario';
		$header->h3 = (object) array();
		$header->h3->w='30';
		$header->h3->titulo = 'Adquisicion';
		
		$header->h4 = (object) array();
		$header->h4->w='35';
		$header->h4->titulo = '% Rend. Mensual';
		$header->h5 = (object) array();
		$header->h5->w='35';
		$header->h5->titulo = '% Rend. Anual';
		$header->h6 = (object) array();
		$header->h6->w='35';
		$header->h6->titulo = 'Generado al dia';
		$header->h7 = (object) array();
		$header->h7->w='35';
		$header->h7->titulo = 'Costo por Recuperar';

		$data = filtraTablaPropiedadReturn($txtFiltroPropiedad,$txtFiltroPropietario);
		// print_r($data);

		// require('../../pdf/creaReportes.php');
		$pdf = new PDF('L','mm','A4');
		$title = 'Propiedades';
		$pdf->SetTitle($title);
		$pdf->SetAuthor('Tayron Jimenez');
		// Títulos de las columnas
		// $header = array('País', 'Capital', 'Superficie (km2)', 'Pobl. (en miles)');
		// Carga de datos
		// $data = $pdf->LoadData('tutorial/paises.txt');
		$pdf->SetFont('Arial','',9);
		// $pdf->AddPage();
		// $pdf->BasicTable($header,$data);
		// $pdf->AddPage();
		// $pdf->ImprovedTable($header,$data);
		$pdf->AddPage();
		$pdf->imprimeReportePropiedades($header,$data);
		$pdf->Output();
	}

	function reporteListadoIncrementos(){
		
		$txtFiltroClientes = $_GET['filtroCliente'];
		

		$header=(object) array();
		$header->h1 = (object) array();
		$header->h1->w='90';
		$header->h1->titulo = 'Clientes';
		$header->h2 = (object) array();
		$header->h2->w='65';
		$header->h2->titulo = 'Propiedad';
		$header->h3 = (object) array();
		$header->h3->w='25';
		$header->h3->titulo = 'Fecha Inicio Contrato';
		
		$header->h4 = (object) array();
		$header->h4->w='25';
		$header->h4->titulo = 'Fecha Fin Contrato';
		$header->h5 = (object) array();
		$header->h5->w='25';
		$header->h5->titulo = 'Fecha Renovacion';
		$header->h6 = (object) array();
		$header->h6->w='25';
		$header->h6->titulo = 'Renta Actual';
		$header->h7 = (object) array();
		$header->h7->w='10';
		$header->h7->titulo = '';

		$data = filtraTablaIncrementosReturn($txtFiltroClientes);
		
		$pdf = new PDF('L','mm','A4');
		$title = 'Listado de Incrementos';
		$pdf->SetTitle($title);
		$pdf->SetAuthor('Tayron Jimenez');
		$pdf->SetFont('Arial','',9);
		$pdf->AddPage();
		$pdf->imprimeReporteIncrementos($header,$data);
		$pdf->Output();
	}

	function reporteListadoRentabilidad(){
		
		$txtFiltroEmpresa = $_GET['filtroEmpresa'];
		$txtFiltroClientes = $_GET['filtroCliente'];
		

		$header=(object) array();
		$header->h1 = (object) array();
		$header->h1->w='80';
		$header->h1->titulo = 'Nombre';
		$header->h2 = (object) array();
		$header->h2->w='28';
		$header->h2->titulo = 'Propietario';
		$header->h3 = (object) array();
		$header->h3->w='25';
		$header->h3->titulo = 'Descripcion';
		
		$header->h4 = (object) array();
		$header->h4->w='23';
		$header->h4->titulo = 'Inversion';
		$header->h5 = (object) array();
		$header->h5->w='8';
		$header->h5->titulo = '';
		$header->h6 = (object) array();
		$header->h6->w='20';
		$header->h6->titulo = 'Fecha de Compra';
		$header->h7 = (object) array();
		$header->h7->w='23';
		$header->h7->titulo = 'Ingresos Generados';
		$header->h8 = (object) array();
		$header->h8->w='23';
		$header->h8->titulo = 'Inversion Recuperada';
		$header->h9 = (object) array();
		$header->h9->w='23';
		$header->h9->titulo = 'Pendiente x Recuperar';
		$header->h10 = (object) array();
		$header->h10->w='23';
		$header->h10->titulo = 'Rentabilidad';

		$data = reporteRentabilidadReturn($txtFiltroClientes,$txtFiltroEmpresa);
		
		$pdf = new PDF('L','mm','A4');
		$title = 'Listado de Incrementos';
		$pdf->SetTitle($title);
		$pdf->SetAuthor('Tayron Jimenez');
		$pdf->SetFont('Arial','',9);
		$pdf->AddPage();
		$pdf->imprimeReporteRentabilidad($header,$data);
		$pdf->Output();
	}

	function reporteListadoPendientexCliente(){
		
	

		$header=(object) array();
		$header->h1 = (object) array();
		$header->h1->w='60';
		$header->h1->titulo = 'Cliente';
		$header->h2 = (object) array();
		$header->h2->w='30';
		$header->h2->titulo = 'Mes';
		$header->h3 = (object) array();
		$header->h3->w='29';
		$header->h3->titulo = 'Monto de Renta';

		$data = reportePendFactClientesReturn();
		
		$pdf = new PDF();
		$title = 'Listado de Incrementos';
		$pdf->SetTitle($title);
		$pdf->SetAuthor('Tayron Jimenez');
		$pdf->SetFont('Arial','',9);
		$pdf->AddPage();
		$pdf->imprimeReportePendientexCliente($header,$data);
		$pdf->Output();
	}

	function reporteListadorentasactuales(){

		$header=(object) array();
		$header->h1 = (object) array();
		$header->h1->w='80';
		$header->h1->titulo = 'Propiedad';
		$header->h2 = (object) array();
		$header->h2->w='32';
		$header->h2->titulo = 'Fin de Contrato';
		$header->h3 = (object) array();
		$header->h3->w='29';
		$header->h3->titulo = 'Monto de Renta';

		$data = reporteMontoXPropiedadReturn();
		
		$pdf = new PDF();
		$title = 'Listado de Incrementos';
		$pdf->SetTitle($title);
		$pdf->SetAuthor('Tayron Jimenez');
		$pdf->SetFont('Arial','',9);
		$pdf->AddPage();
		$pdf->imprimeReporteRentasActuales($header,$data);
		$pdf->Output();
	}

	function reporteListadoPropiedadesVendidas(){
		
		$txtfiltroPropiedad = $_GET['filtroPropiedad'];
		

		$header=(object) array();
		$header->h1 = (object) array();
		$header->h1->w='90';
		$header->h1->titulo = 'Propiedad';
		$header->h2 = (object) array();
		$header->h2->w='65';
		$header->h2->titulo = 'Suma de Rentas Generadas';
		$header->h3 = (object) array();
		$header->h3->w='26';
		$header->h3->titulo = 'Monto de Venta';
		
		$header->h4 = (object) array();
		$header->h4->w='25';
		$header->h4->titulo = 'Costo de Adquisicion';
		$header->h5 = (object) array();
		$header->h5->w='25';
		$header->h5->titulo = 'Cantidad Generada';
		$header->h6 = (object) array();
		$header->h6->w='25';
		$header->h6->titulo = '% Generado';
		

		$data = reporteVendidasReturn($txtfiltroPropiedad);
		
		$pdf = new PDF('L','mm','A4');
		$title = 'Listado de Incrementos';
		$pdf->SetTitle($title);
		$pdf->SetAuthor('Tayron Jimenez');
		$pdf->SetFont('Arial','',9);
		$pdf->AddPage();
		$pdf->imprimeReportePropiedadesVendidas($header,$data);
		$pdf->Output();
	}

	function reporteListadoClienteRentabilidad(){
		
		$filtrocliente = $_GET['filtrocliente'];
		$filtroPropietario = $_GET['filtroPropietario'];
		

		$header=(object) array();
		$header->h1 = (object) array();
		$header->h1->w='90';
		$header->h1->titulo = 'Cliente';
		$header->h2 = (object) array();
		$header->h2->w='65';
		$header->h2->titulo = 'Propietario';
		$header->h3 = (object) array();
		$header->h3->w='26';
		$header->h3->titulo = 'Generado (Acumulado)';
		$header->h4 = (object) array();
		$header->h4->w='25';
		$header->h4->titulo = 'Rentabilidad Mensual';
		$header->h5 = (object) array();
		$header->h5->w='25';
		$header->h5->titulo = 'Rentabilidad Anual';
		
		

		$data = reporteClienteRentabilidadReturn($filtrocliente,$filtroPropietario);
		
		$pdf = new PDF('L','mm','A4');
		$title = 'Listado de Incrementos';
		$pdf->SetTitle($title);
		$pdf->SetAuthor('Tayron Jimenez');
		$pdf->SetFont('Arial','',9);
		$pdf->AddPage();
		$pdf->imprimeReporteClienteRentabiliddad($header,$data);
		$pdf->Output();
	}

?>