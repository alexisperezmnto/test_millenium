<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


//GUARDAR USUARIO
if(isset($_POST['nombre'])) {
	if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nombre']) &&
		preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['apellido'])) {	

		$tabla = "usuarios";

		$datos = array("nombre" => $_POST['nombre'],
						"apellido" => $_POST['apellido'],
						"foto" => '');
		
		$respuesta = ModeloUsuarios::mdlRegistrarUsuario($tabla, $datos);
		
		if($respuesta["message"] == 'ok') { 

			//GUARDAR IMAGEN
			$ruta = '';

			if(isset($_FILES['nuevaFoto']['tmp_name']) && $_FILES['nuevaFoto']['tmp_name'] != "") {
				list($ancho, $alto) = getimagesize($_FILES['nuevaFoto']['tmp_name']);

				$nuevoAncho = 500;
				$nuevoAlto = 500;

				$directorio = '../vistas/img/usuarios/'.$respuesta["last_id"];

				mkdir($directorio, 0755);

				if($_FILES['nuevaFoto']['type'] == 'image/jpeg') {

					$aleatorio = mt_rand(100,999);
					$ruta  = $directorio.'/'.$aleatorio.'.jpg';

					$origen = imagecreatefromstring(file_get_contents($_FILES['nuevaFoto']['tmp_name']));
					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);

					$ruta = substr($ruta, 3);
				}


				if($_FILES['nuevaFoto']['type'] == 'image/png') {

					$aleatorio = mt_rand(100,999);
					$ruta  = $directorio.'/'.$aleatorio.'.png';
					
					$origen = imagecreatefromstring(file_get_contents($_FILES['nuevaFoto']['tmp_name']));
					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);

					$ruta = substr($ruta, 3);
				}

				$datos = array("id" => $respuesta["last_id"],
						"foto" => $ruta);
		
				$respuesta = ModeloUsuarios::mdlActualizarRutaImagen($tabla, $datos);
			}

			echo 'ok'; 
		}

	} else { 
		echo 'error'; 
	}
}


//EDITAR USUARIO
if(isset($_POST['idUsuario'])) {
	if(preg_match('/^[0-9]+$/', $_POST['idUsuario']) &&
		preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarNombre']) &&
		preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['editarApellido'])) {

		//VALIDAR IMAGEN
		$ruta = $_POST['fotoActual'];
		
		if(isset($_FILES['editarFoto']['tmp_name']) && !empty($_FILES["editarFoto"]["tmp_name"])) {
			list($ancho, $alto) = getimagesize($_FILES['editarFoto']['tmp_name']);

			$nuevoAncho = 500;
			$nuevoAlto = 500;

			$aleatorio = mt_rand(100,999);
			$directorio = '../vistas/img/usuarios/'.$_POST['idUsuario'];

			if(!empty($ruta)) {
				unlink('../'.$ruta);
			} else {
				mkdir($directorio, 0755);
			}

			

			if($_FILES['editarFoto']['type'] == 'image/jpeg') {

				$aleatorio = mt_rand(100,999);
				$ruta  = $directorio.'/'.$aleatorio.'.jpg';

				$origen = imagecreatefromstring(file_get_contents($_FILES['editarFoto']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagejpeg($destino, $ruta);

				$ruta = substr($ruta, 3);
			}


			if($_FILES['editarFoto']['type'] == 'image/png') {

				$aleatorio = mt_rand(100,999);
				$ruta  = $directorio.'/'.$aleatorio.'.png';

				$origen = imagecreatefromstring(file_get_contents($_FILES['editarFoto']['tmp_name']));
				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

				imagepng($destino, $ruta);

				$ruta = substr($ruta, 3);
			}
		}

		$tabla = "usuarios";

		$datos = array("id" => $_POST['idUsuario'],
						"nombre" => $_POST['editarNombre'],
						"apellido" => $_POST['editarApellido'],
						"foto" => $ruta); 

		$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

		if($respuesta == 'ok') {
			echo 'ok';
		}

	} else {
			echo 'error';
	}

}
