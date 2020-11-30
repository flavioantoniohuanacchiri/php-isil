<?php namespace App\Master\Controllers;

use App\Master\Models\Producto;

class ProductoController
{
	public function list($request = [])
	{
		$list = Producto::get()->toArray();
		return json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	public function show($productoId = "")
	{
		$producto = Producto::find($productoId);
		return json_encode($producto, JSON_UNESCAPED_UNICODE);
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
			$obj->nombre = $request["nombre"];
			$obj->descripcion = $request["descripcion"];
			$obj->estado = $request["estado"];
			$obj->save();
			$msj = "producto Creado";
			if ($id !="") {
				$msj = "producto Editado";
			}
			return json_encode(["rst" => 1, "msj" => $msj]);
		} catch (Exception $e) {
			return json_encode(["rst" => 2, "msj" => "Error en BD.".$e->getMessage()]);
		}
	}
	public function destroy($productoId = "")
	{
		$obj = Producto::find($productoId);
		if (is_null($obj)) {
			return json_encode(["rst" => 2, "msj" => "producto No Existe o ya Fue Eliminado"]);
		}
		$obj->delete();
		return json_encode(["rst" => 1, "msj" => "producto Eliminado"]);
	}
}