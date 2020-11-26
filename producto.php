<?php 
	include __DIR__."/functions/session_helper.php";
	if (isset($_GET)) {
		if (count($_GET) > 0) {
			if (isset($_GET["action"])) {
				switch ($_GET["action"]) {
					case 'delete':
						$productoJson = file_get_contents(__DIR__."/resources/assets/js/producto.json");
						$productoData = json_decode($productoJson, true);
						$tmpId = (int)$_GET["id"];
						$productoData[$tmpId]["deleted_at"] = date("Y-m-d H:i:s");
						$productoJson = json_encode($productoData, JSON_UNESCAPED_UNICODE);
						file_put_contents(__DIR__."/resources/assets/js/producto.json", $productoJson);
						$response = ["rst" => 1, "msj"=>"Producto Eliminado"];
						echo json_encode($response);
						exit;
						break;
					
					default:
						# code...
						break;
				}
			}
			if (isset($_GET["id"])) {
				$productoJson = file_get_contents(__DIR__."/resources/assets/js/producto.json");
				$productoData = json_decode($productoJson, true);
				$tmpId = $_GET["id"];
				if (isset($productoData[$tmpId])) {
					$productoData[$tmpId]["id"] = $tmpId;
					echo json_encode($productoData[$tmpId]);
					exit;
				}

			}
		}
	}
	if (isset($_POST)) {
		if (count($_POST) > 0) {
			$productoJson = file_get_contents(__DIR__."/resources/assets/js/producto.json");
			$productoData = json_decode($productoJson, true);
			if (isset($_POST["id"]) && $_POST["id"] !="") {
				$tmpId = $_POST["id"];
				$tmpItem = $productoData[$tmpId];
				//print_r($tmpItem);
				$productoData[$tmpId]["codigo"] = $_POST["codigo"];
				$productoData[$tmpId]["nombre_producto"] = $_POST["nombre_producto"];
				$productoData[$tmpId]["marca"] = $_POST["marca"];
				$productoData[$tmpId]["precio"] = $_POST["precio"];
				$productoData[$tmpId]["cantidad"] = $_POST["cantidad"];
			
				$productoData[$tmpId]["updated_at"] = date("Y-m-d H:i:s");
				//print_r($tmpItem); exit;
				$productoJson = json_encode($productoData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/producto.json", $productoJson);
				$response = ["rst" => 1, "msj"=>"Producto Actualizado"];
				echo json_encode($response);
				exit;
			} else {
				$tmpItem = [];
				$tmpItem["codigo"] = $_POST["codigo"];
				$tmpItem["nombre_producto"] = $_POST["nombre_producto"];
				$tmpItem["marca"] = $_POST["marca"];
				$tmpItem["precio"] = $_POST["precio"];
				$tmpItem["cantidad"] = $_POST["cantidad"];
				
				$tmpItem["created_at"] = date("Y-m-d H:i:s");
				$tmpItem["updated_at"] = "";
				$tmpItem["deleted_at"] = "";

				$size = count($productoData);
				$size = $size +1;
				$productoData[$size] = $tmpItem;
				$productoJson = json_encode($productoData, JSON_UNESCAPED_UNICODE);
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
				//echo file_get_contents(__DIR__."/resources/assets/js/producto.json"); exit;
				$productoJson = file_get_contents(__DIR__."/resources/assets/js/producto.json");
				$productoData = json_decode($productoJson, true);
			?>
			<div class="box box-primary content-table">
				<h1>Listado de Productos <div style="width: auto; display: inline-block; float: right;">
					<a href="#" class="btn btn-primary"
						data-toggle="modal"
						data-target="#mdlProducto">
						<i class="fas fa-plus"></i> Agregar</a>
					</div></h1>
			<div class="table-responsive-md">
  				<table id="table-productos" class="table table-striped table-bordered nowrap" style="width:100%">
						<thead>
						    <tr>
						      <th>#</th>
						      <th>Código</th>
						      <th>Nombre del Producto</th>
						      <th>Marca</th>
						      <th>Precio</th>
							  <th>Cantidad</th>
						      <th>U.Act.</th>
						      <th>[]</th>
						    </tr>
						</thead>
						<tbody>
						  		<?php 
						  			//print_r($productoData); exit;
						    		foreach ($productoData as $key => $value) {
						    			$tmpIndex = (int)$key;
						    			if ($value["deleted_at"] == "") {
						    	?>
							    <tr>
							      <th><?php echo $tmpIndex;?></th>
							      <td><?php echo $value["codigo"];?></td>
							      <td><?php echo $value["nombre_producto"];?></td>
							      <td><?php echo $value["marca"];?></td>
							      <td><?php echo $value["precio"];?></td>
								  <td><?php echo $value["cantidad"];?></td>
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
							<?php }
							} ?>
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
			var table = $('#table-productos').DataTable({
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
