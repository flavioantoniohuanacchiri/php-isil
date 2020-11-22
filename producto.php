<?php 
	include __DIR__."/functions/session_helper.php";
	if (isset($_GET)) {
		if (count($_GET) > 0) {
			if (isset($_GET["id"])) {
				$productoJson = file_get_contents(__DIR__."/resources/assets/js/producto.json");
				$productosData = json_decode($productoJson, true);
				$tmpId = $_GET["id"];
				if (isset($productosData[$tmpId])) {
					$productosData[$tmpId]["id"] = $tmpId;
					echo json_encode($productosData[$tmpId]);
					exit;
				}

			}
		}
	}
	if (isset($_POST)) {
		if (count($_POST) > 0) {
			$productoJson = file_get_contents(__DIR__."/resources/assets/js/producto.json");
			$productosData = json_decode($productoJson, true);
			if (isset($_POST["id"]) && $_POST["id"] !="") {
				$tmpId = $_POST["id"];
				$tmpItem = $productosData[$tmpId];
				//print_r($tmpItem);
				$productosData[$tmpId]["codigo"] = $_POST["codigo"];
				$productosData[$tmpId]["descripcion"] = $_POST["descripcion"];
				$productosData[$tmpId]["modelo"] = $_POST["modelo"];
				$productosData[$tmpId]["color"] = $_POST["color"];
				$productosData[$tmpId]["stock"] = $_POST["stock"];
				$productosData[$tmpId]["estado"] = $_POST["estado"];
				$productosData[$tmpId]["updated_at"] = date("Y-m-d H:i:s");
				//print_r($tmpItem); exit;
				$productoJson = json_encode($productosData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/producto.json", $productoJson);
				$response = ["rst" => 1, "msj"=>"Producto Actualizado"];
				echo json_encode($response);
				exit;
			} else {
				$tmpItem = [];
				$tmpItem["codigo"] = $_POST["codigo"];
				$tmpItem["descripcion"] = $_POST["descripcion"];
				$tmpItem["modelo"] = $_POST["modelo"];
				$tmpItem["color"] = $_POST["color"];
				$tmpItem["stock"] = $_POST["stock"];
				$tmpItem["estado"] = $_POST["estado"];
				$tmpItem["created_at"] = date("Y-m-d H:i:s");
				$tmpItem["updated_at"] = "";
				$tmpItem["deleted_at"] = "";

				$size = count($productosData);
				$size = $size +1;
				$productosData[$size] = $tmpItem;
				$productoJson = json_encode($productosData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/producto.json", $productoJson);
				$response = ["rst" => 1, "msj"=>"Producto Creado"];
				echo json_encode($response);
				exit;
			}
			$response = ["rst" => 2, "msj"=>"Error"];
			echo json_encode($response);
			exit;
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include __DIR__."/resources/views/includes/head.phtml";
		?>
		<title>Productos</title>
	</head>
	<body>
		<?php
			include __DIR__."/resources/views/includes/header.phtml";
		?>
		<div class="container">
			<?php 
				//echo file_get_contents(__DIR__."/resources/assets/js/usuario.json"); exit;
				$productoJson = file_get_contents(__DIR__."/resources/assets/js/producto.json");
				$productosData = json_decode($productoJson, true);
			?>
			<div class="box box-primary content-table">
				<h1>Listado de Productos <div style="width: auto; display: inline-block; float: right;">
					<a href="#" class="btn btn-primary"
						data-toggle="modal"
						data-target="#mdlProducto">
						<i class="fas fa-plus"></i> Agregar</a>
					</div></h1>
			<div class="table-responsive-md">
  				<table id="table-usuarios" class="table table-striped table-bordered nowrap" style="width:100%">
						<thead>
						    <tr>
						      <th>#</th>
						      <th>Codigo</th>
						      <th>Descripcion</th>
						      <th>Modelo</th>
						      <th>Color</th>
							  <th>Stock</th>
						      <th>Estado</th>
						      <th>U.Act.</th>
						      <th>[]</th>
						    </tr>
						</thead>
						<tbody>
						  		<?php 
						  			//print_r($usuariosData); exit;
						    		foreach ($productosData as $key => $value) {
						    			$tmpIndex = $key;
						    			//$tmpIndex = $tmpIndex+1;
						    	?>
							    <tr>
							      <th><?php echo $tmpIndex;?></th>
							      <td><?php echo $value["codigo"];?></td>
							      <td><?php echo $value["descripcion"];?></td>
							      <td><?php echo $value["modelo"];?></td>
							      <td><?php echo $value["color"];?></td>
							      <td><?php echo $value["stock"];?></td>
							      <td><?php echo $value["estado"];?></td>
							      <td><?php echo $value["updated_at"];?></td>
							      <td>
							      	<a href="#"
							      		data-toggle="modal"
							      		data-target="#mdlProducto"
							      		class="btn btn-primary"
							      		data-id="<?php echo $key;?>">
							      		<i class="fas fa-pencil-alt"></i>
							      	</a>
							      	<a class="btn btn-danger btn-delete" data-id="<?php echo $key;?>">
							      		<i class="fas fa-trash"></i>
							      	</a>
							      </td>
							    </tr>
							<?php } ?>
						</tbody>
				</table>
			</div>
			</div>
			
		</div>
		<?php 
			include __DIR__."/resources/views/modal/mdl_producto.phtml";
		?>
		<?php
			include __DIR__."/resources/views/includes/script.phtml";
			include __DIR__."/resources/views/includes/loading.phtml";
		?>
		<script type="text/javascript">
			var table = $('#table-usuarios').DataTable({
			   	"language": {
			        "url": "/Spanish.json"
			    },
			    responsive: true
			});
			$(document).ready(function() {
			    
			 
			    //new $.fn.dataTable.FixedHeader( table );
			} );
		</script>
		<script type="text/javascript" src="js/web/producto.js"></script>
	</body>
</html>
