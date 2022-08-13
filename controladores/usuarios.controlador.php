<?php

session_start();

class ControladorUsuarios {

	//MOSTRAR USUARIO
	static public function ctrMostrarUsuarios($item,$valor) {

		$tabla = 'usuarios';
		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);

		return $respuesta;


	}

	//ELIMINAR USUARIO
	static public function ctrBorrarUsuario($valor1, $valor2) {

		$tabla = "usuarios";
		$datos = $valor1;

		if($valor2 != "") {
			unlink('../'.$valor2);
			rmdir('../vistas/img/usuarios/'.$valor1);
		}

		$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

		if($respuesta == 'ok') {
			return 'ok';
		} else {
			return 'error';
		}
	}
}