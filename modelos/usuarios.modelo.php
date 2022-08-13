<?php

require_once "conexion.php";

class ModeloUsuarios{

	//MOSTRAR USUARIOS
	static public function mdlMostrarUsuarios($tabla, $item, $valor) {

		if($item != null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();	
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY nombre ASC");
			$stmt -> execute();
			return $stmt -> fetchAll();	
		}
		
		$stmt -> close();
		$stmt = null;
	}

	//REGISTRAR USUARIOS
	static public function mdlRegistrarUsuario($tabla, $datos) {
		$connection = Conexion::conectar();
		$stmt = $connection -> prepare("INSERT INTO $tabla(nombre,apellido,foto)	
            VALUES (:nombre, :apellido, :foto)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

		if($stmt->execute()) {
			$last_id = $connection->lastInsertId();
			$response = ["last_id" => $last_id, "message" => "ok"];
			return $response;
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	//EDITAR USUARIOS
	static public function mdlEditarUsuario($tabla, $datos) {
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, apellido = :apellido, foto = :foto WHERE id = :id");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	//ACTUALIZAR RUTA IMAGEN 
	static public function mdlActualizarRutaImagen($tabla, $datos) {
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET foto = :foto WHERE id = :id");
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	//ELIMINAR USUARIOS
	static public function mdlBorrarUsuario($tabla, $datos) {
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);
		if($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}
}