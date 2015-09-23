<?php
	require('control.php');
	
	$reporte = $_GET['reporte'];

	switch ($reporte) {
		case 'propiedades':
			reportePropiedades();
			break;
		
		default:
			# code...
			break;
	}

	function reportePropiedades(){
		require('../pdf/fpdf.php');
		$txtFiltroPropiedad = $_GET['filtroPropiedad'];
		$txtFiltroPropietario = $_GET['filtroPropietario'];

		$header=(object) array();
		$header->h1 = (object) array();
		$header->h1->w='60';
		$header->h1->titulo = 'Propiedad';
		$header->h2 = (object) array();
		$header->h2->w='35';
		$header->h2->titulo = 'Propietario';
		$header->h3 = (object) array();
		$header->h3->w='40';
		$header->h3->titulo = 'Costo<br>de Adquisición';
		$header->h4 = (object) array();
		$header->h4->w='35';
		$header->h4->titulo = '% Rend. Mensual';
		$header->h5 = (object) array();
		$header->h5->w='35';
		$header->h5->titulo = '% Rend. Anual';
		$header->h6 = (object) array();
		$header->h6->w='35';
		$header->h6->titulo = 'Generado al día';
		$header->h7 = (object) array();
		$header->h7->w='35';
		$header->h7->titulo = 'Costo por Recuperar';

		$data = filtraTablaPropiedad($txtFiltroPropiedad,$txtFiltroPropietario);
		// print_r($dataJSON);

		// require('../../pdf/creaReportes.php');
		$pdf = new PDF();
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


class PDF extends FPDF
{

	// Tabla coloreada
	function imprimeReportePropiedades($header,$data)
	{
	    // Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B');
	    // Cabecera
	    foreach ($header as $key => $head) {
	    	$this->Cell($head->w,7,$head->titulo,1,0,'C',true);
	    }
	    // $w = array(40, 35, 45, 40);
	    // for($i=0;$i<count($header);$i++)
	        
	    $this->Ln();
	    // Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('');
	    // Datos
	    $fill = false;
	    foreach($data->Reporte as $row)
	    {
	        $this->Cell($header->h1->w,6,$row->nombre,'LR',0,'L',$fill);
	        $this->Cell($header->h2->w,6,$row->propietario,'LR',0,'L',$fill);
	        $this->Cell($header->h3->w,6,number_format($row->valor_inicial),'LR',0,'R',$fill);
	        $this->Cell($header->h4->w,6,number_format($row->generado),'LR',0,'R',$fill);
	        $this->Cell($header->h5->w,6,number_format($row->monto),'LR',0,'R',$fill);
	        $this->Ln();
	        $fill = !$fill;
	    }
	    // Línea de cierre
	    // $this->Cell(array_sum($w),0,'','T');
	}

}
?>