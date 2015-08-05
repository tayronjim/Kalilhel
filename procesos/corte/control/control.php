<?php
	include ('../db/funcionesdb.php');
	$funsion = $_POST['funsion'];
	switch ($funsion) {
		case 'listaFacturas': listaFacturas(); break;
		case 'subeCambios': subeCambios($_POST['cadena']); break;

		
		default:
			# code...
			break;
	}

	function listaFacturas(){
		
		$resultado = "";
		$cantidadCortes =mysqli_fetch_object(buscaCortes());
		if($cantidadCortes->cuenta == '0'){
			$res = listadoFacturasRenta();
			while ($row = mysqli_fetch_object($res)) {
				$resultado .= "<tr id=renta_".$row->id."><td>".$row->id."</td><td>".$row->clave_propiedad."</td><td>".$row->fcorte."</td><td>Facturado<input type='checkbox'></td><td>No. Factura</td><td>Pagado<input type='checkbox'></td><td>Fecha de Pago</td></tr>";
				insertaCorte($row);
				
			}
		}
		else{
			$res = listadoFacturasCorte();
			while ($row = mysqli_fetch_object($res)) {
				$checked1 = "";
				$checked2 = "";
				if($row->facturado=='1'){$checked1 = 'checked';}
				if($row->pagado=='1'){$checked2 = 'checked';}
				$resultado .= "<tr id=renta_".$row->claveRenta."><td value='".$row->claveRenta."'>".$row->claveRenta."</td><td value='".$row->propiedad."'>".$row->propiedad."</td><td>".$row->fechaCorte."</td><td>Facturado: <input type='checkbox' ".$checked1." disabled ></td><td>".$row->factura."</td><td>Pagado: <input class='checkPagado' type='checkbox' ".$checked2."></td><td><input type='date' class='fechaPagado' value='".$row->fechaPago."'></td></tr>";
			}
		}
		
		echo $resultado;
	}
	function subeCambios($cadena){

		
		$resultado = cambiosCorte($cadena);
		echo $resultado;
	}
?>