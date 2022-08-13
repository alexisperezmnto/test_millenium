<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


class AjaxUsuarios {
	
	//EDITAR USUARIO
	public $idUsuario;

	public function ajaxEditarUsuario() {

		$item = "id";
		$valor = $this->idUsuario;
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		echo json_encode($respuesta);

	}
	
	//ELIMINAR USUARIO
	public $eliminarUsuario;
	public $fotoUsuario;

	public function ajaxEliminarUsuario() {
		$valor1 = $this->eliminarUsuario;
		$valor2 = $this->fotoUsuario;
		$respuesta = ControladorUsuarios::ctrBorrarUsuario($valor1, $valor2);

		echo json_encode($respuesta);
	}

	//MOSTRAR USUARIOS 
	public function ajaxMostrarUsuarios() {
		$item = null;
		$valor = null;
		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		echo json_encode($respuesta); 
	}

}


//EDITAR USUARIO
if(isset($_POST['idUsuario'])) {
	$editar = new AjaxUsuarios();
	$editar -> idUsuario = $_POST['idUsuario'];
	$editar -> ajaxEditarUsuario();
}

//ELIMINAR USUARIO 
if(isset($_POST['eliminarUsuario'])) {
	
	$eliminarUsuario = new AjaxUsuarios();
	$eliminarUsuario -> eliminarUsuario = $_POST['eliminarUsuario'];
	$eliminarUsuario -> fotoUsuario = $_POST['fotoUsuario'];
	$eliminarUsuario -> ajaxEliminarUsuario();
}

//MOSTRAR USUARIOS 
if(isset($_POST['usuarios'])) {
	$usuarios = new AjaxUsuarios();
	$usuarios -> ajaxMostrarUsuarios();
}
