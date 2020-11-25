<?php namespace App\Master\Controllers;

use App\Master\Models\Producto;

class ProductoController
{
	public function list($request = [])
	{
		$list = Producto::get()->toArray();
		return json_encode($list, JSON_UNESCAPED_UNICODE);
	}


}