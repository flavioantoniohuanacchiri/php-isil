<?php 
	include __DIR__."/functions/session_helper.php";
	if (isset($_GET)) {
		if (count($_GET) > 0) {
			if (isset($_GET["action"])) {
				switch ($_GET["action"]) {
					case 'delete':
						$categoriaJson = file_get_contents(__DIR__."/resources/assets/js/categoria.json");
						$categoriasData = json_decode($categoriaJson, true);
						$tmpId = $_GET["id"];
						$categoriasData[$tmpId]["deleted_at"] = date("Y-m-d H:i:s");
						$categoriaJson = json_encode($categoriasData, JSON_UNESCAPED_UNICODE);
						file_put_contents(__DIR__."/resources/assets/js/categoria.json", $categoriaJson);
						$response = ["rst" => 1, "msj"=>"Catregoría Eliminada"];
						echo json_encode($response);
						exit;
						break;
					
					default:
						# code...
						break;
				}
			} elseif (isset($_GET["id"])) {
				$categoriaJson = file_get_contents(__DIR__."/resources/assets/js/categoria.json");
				$categoriasData = json_decode($categoriaJson, true);
				$tmpId = $_GET["id"];
				if (isset($categoriasData[$tmpId])) {
					$categoriasData[$tmpId]["id"] = $tmpId;
					echo json_encode($categoriasData[$tmpId]);
					exit;
				}

			}
		}
	}
	if (isset($_POST)) {
		if (count($_POST) > 0) {
			$categoriaJson = file_get_contents(__DIR__."/resources/assets/js/categoria.json");
			$categoriasData = json_decode($categoriaJson, true);
			if (isset($_POST["id"]) && $_POST["id"] !="") {
				$tmpId = $_POST["id"];
				$tmpItem = $categoriasData[$tmpId];
				//print_r($tmpItem);
				$productosData[$tmpId]["codigo"] = $_POST["codigo"];
				$productosData[$tmpId]["descripcion"] = $_POST["descripcion"];
				$productosData[$tmpId]["estado"] = $_POST["estado"];
				$productosData[$tmpId]["updated_at"] = date("Y-m-d H:i:s");
				//print_r($tmpItem); exit;
				$categoriaJson = json_encode($categoriasData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/categoria.json", $categoriaJson);
				$response = ["rst" => 1, "msj"=>"Categoría Actualizada"];
				echo json_encode($response);
				exit;
			} else {
				$tmpItem = [];
				$tmpItem["codigo"] = $_POST["codigo"];
				$tmpItem["descripcion"] = $_POST["descripcion"];
				$tmpItem["estado"] = $_POST["estado"];
				$tmpItem["created_at"] = date("Y-m-d H:i:s");
				$tmpItem["updated_at"] = "";
				$tmpItem["deleted_at"] = "";

				$size = count($categoriasData);
				$size = $size +1;
				$categoriasData[$size] = $tmpItem;
				$categoriaJson = json_encode($categoriasData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/categoria.json", $categoriaJson);
				$response = ["rst" => 1, "msj"=>"Categoría Creada"];
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
				$categoriaJson = file_get_contents(__DIR__."/resources/assets/js/categoria.json");
				$categoriasData = json_decode($categoriaJson, true);
			?>
			<div class="box box-primary content-table">
				<h1>Listado de Categorias <div style="width: auto; display: inline-block; float: right;">
					<a href="#" class="btn btn-primary"
						data-toggle="modal"
						data-target="#mdlCategoria">
						<i class="fas fa-plus"></i> Agregar</a>
					</div></h1>
			<div class="table-responsive-md">
  				<table id="table-categorias" class="table table-striped table-bordered nowrap" style="width:100%">
						<thead>
						    <tr>
						      <th>#</th>
						      <th>Codigo</th>
						      <th>Descripcion</th>
						      <th>Estado</th>
						      <th>U.Act.</th>
						      <th>[]</th>
						    </tr>
						</thead>
						<tbody>
						  		<?php 
						  			//print_r($usuariosData); exit;
						    		foreach ($categoriasData as $key => $value) {
						    			$tmpIndex = $key;
						    			//$tmpIndex = $tmpIndex+1;

						    			if ($value["deleted_at"] == "") {
						    	?>
							    <tr>
							      <th><?php echo $tmpIndex;?></th>
							      <td><?php echo $value["codigo"];?></td>
							      <td><?php echo $value["descripcion"];?></td>
							      <td><?php echo $value["estado"];?></td>
							      <td><?php echo $value["updated_at"];?></td>
							      <td>
							      	<a href="#"
							      		data-toggle="modal"
							      		data-target="#mdlCategoria"
							      		class="btn btn-primary"
							      		data-id="<?php echo $key;?>">
							      		<i class="fas fa-pencil-alt"></i>
							      	</a>
							      	<a class="btn btn-danger btn-delete" data-id="<?php echo $key;?>">
							      		<i class="fas fa-trash"></i>
							      	</a>
							      </td>
							    </tr>
							<?php }} ?>
						</tbody>
				</table>
			</div>
			</div>
			
		</div>
		<?php 
			include __DIR__."/resources/views/modal/mdl_categoria.phtml";
		?>
		<?php
			include __DIR__."/resources/views/includes/script.phtml";
			include __DIR__."/resources/views/includes/loading.phtml";
		?>
		<script type="text/javascript">
			var table = $('#table-categorias').DataTable({
			   	"language": {
			        "url": "/Spanish.json"
			    },
			    responsive: true
			});
			$(document).ready(function() {
			    
			 
			    //new $.fn.dataTable.FixedHeader( table );
			} );
		</script>
		<script type="text/javascript" src="js/web/categoria.js"></script>
	</body>
</html>