<?php namespace App\Master\Controllers;

use App\Master\Models\Producto;

class ProductoController
{
	public function list($request = [])
	{
		$list = Producto::get()->toArray();
		return json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	public function show($ProductoId = "")
	{
		$Producto = Producto::find($ProductoId);
		return json_encode($Producto, JSON_UNESCAPED_UNICODE);
	}
	public function save($request = [])
	{
		try {
			$id = isset($request["id"])? $request["id"] : "";
			$obj = null;
			if ($id == "") {
				$obj = new Producto;
				$obj->save();
			} else {
				$obj = Producto::find($id);
			}
			$obj->nombres = $request["nombre"];
			$obj->ape_paterno = $request["descripcion"];
			$obj->ape_materno = $request["estado"];
			$obj->save();
			$msj = "Producto Creado";
			if ($id !="") {
				$msj = "Producto Editado";
			}
			return json_encode(["rst" => 1, "msj" => $msj]);
		} catch (Exception $e) {
			return json_encode(["rst" => 2, "msj" => "Error en BD.".$e->getMessage()]);
		}
	}
	public function destroy($ProductoId = "")
	{
		$obj = Producto::find($ProductoId);
		if (is_null($obj)) {
			return json_encode(["rst" => 2, "msj" => "Producto No Existe o ya Fue Eliminado"]);
		}
		$obj->delete();
		return json_encode(["rst" => 1, "msj" => "Producto Eliminado"]);
	}
}