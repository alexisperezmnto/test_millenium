<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


class TablaUsuarios{

	//MOSTRAR LA TABLA DE USUARIOS
	public function mostrarTablaUsuarios(){

		$item = null;
    	$valor = null;

  		$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);	
		
		if(count($usuarios) == 0) {
			echo $datosJson = '{"data": [["","","",""]]}';
			return;
		}

  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($usuarios); $i++){

		  	if($usuarios[$i]["foto"] != '') {
	            $foto =  "<img src='".$usuarios[$i]['foto']."' class='centrarElemento img-thumbnail' width='40px'>";
			} else {
	            $foto = "<img src='vistas/img/usuarios/default/anonymous.png' class='centrarElemento img-thumbnail' width='40px'>";
			}

			$accion = "<i class='fa fa-pen mr-2 btnEditarUsuario' idUsuario='".$usuarios[$i]["id"]."' data-toggle='modal' data-target='#modalEditarUsuario' style='cursor:pointer'></i>".
				"<i class='fa fa-trash btnEliminarUsuario' idUsuario='".$usuarios[$i]["id"]."' fotoUsuario='".$usuarios[$i]['foto']."' style='cursor:pointer'></i>"; 

	    	$datosJson .='[
		      "'.$usuarios[$i]["nombre"].'",
		      "'.$usuarios[$i]["apellido"].'",
		      "'.$foto.'",
		      "'.$accion.'"
		    ],';

		  }

		  $datosJson = substr($datosJson, 0, -1);

		 $datosJson .=   '] 

		 }';
		
		echo $datosJson;


	}

}


$usuarios = new TablausUarios();
$usuarios -> mostrarTablaUsuarios();

