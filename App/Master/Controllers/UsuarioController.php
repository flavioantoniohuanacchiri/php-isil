<?php namespace App\Master\Controllers;

use App\Master\Models\Usuario;

class UsuarioController
{
	public function list($request = [])
	{
		$list = Usuario::get()->toArray();
		return json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	public function show($usuarioId = "")
	{
		$usuario = Usuario::find($usuarioId);
		return json_encode($usuario, JSON_UNESCAPED_UNICODE);
	}
	public function save($request = [])
	{
		try {
			$id = isset($request["id"])? $request["id"] : "";
			$obj = null;
			if ($id == "") {
				$obj = new Usuario;
				$obj->save();
			} else {
				$obj = Usuario::find($id);
			}
			$obj->nombres = $request["nombres"];
			$obj->ape_paterno = $request["ape_paterno"];
			$obj->ape_materno = $request["ape_materno"];
			$obj->sexo = $request["sexo"];
			$obj->save();
			$msj = "Usuario Creado";
			if ($id !="") {
				$msj = "Usuario Editado";
			}
			return json_encode(["rst" => 1, "msj" => $msj]);
		} catch (Exception $e) {
			return json_encode(["rst" => 2, "msj" => "Error en BD.".$e->getMessage()]);
		}
	}
	public function destroy($usuarioId = "")
	{
		$obj = Usuario::find($usuarioId);
		if (is_null($obj)) {
			return json_encode(["rst" => 2, "msj" => "Usuario No Existe o ya Fue Eliminado"]);
		}
		$obj->delete();
		return json_encode(["rst" => 1, "msj" => "Usuario Eliminado"]);
	}
}