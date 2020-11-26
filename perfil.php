<?php 
	include __DIR__."/functions/session_helper.php";
	if (isset($_GET)) {
		if (count($_GET) > 0) {
			if (isset($_GET["action"])) {
				switch ($_GET["action"]) {
					case 'delete':
						$perfilJson = file_get_contents(__DIR__."/resources/assets/js/perfil.json");
						$perfilesData = json_decode($perfilJson, true);
						$tmpId = (int)$_GET["id"];
						$perfilesData[$tmpId]["deleted_at"] = date("Y-m-d H:i:s");
						$perfilJson = json_encode($perfilesData, JSON_UNESCAPED_UNICODE);
						file_put_contents(__DIR__."/resources/assets/js/perfil.json", $perfilJson);
						$response = ["rst" => 1, "msj"=>"Perfil Eliminado"];
						echo json_encode($response);
						exit;
						break;
					
					default:
						# code...
						break;
				}
			}
			if (isset($_GET["id"])) {
				$perfilJson = file_get_contents(__DIR__."/resources/assets/js/perfil.json");
				$perfilesData = json_decode($perfilJson, true);
				$tmpId = $_GET["id"];
				if (isset($perfilesData[$tmpId])) {
					$perfilesData[$tmpId]["id"] = $tmpId;
					echo json_encode($perfilesData[$tmpId]);
					exit;
				}

			}
		}
	}
	if (isset($_POST)) {
		if (count($_POST) > 0) {
			$perfilJson = file_get_contents(__DIR__."/resources/assets/js/perfil.json");
			$perfilesData = json_decode($perfilJson, true);
			if (isset($_POST["id"]) && $_POST["id"] !="") {
				$tmpId = $_POST["id"];
				$tmpItem = $perfilesData[$tmpId];
				//print_r($tmpItem);
				$perfilesData[$tmpId]["perfil"] = $_POST["perfil"];
				$perfilesData[$tmpId]["descripcion"] = $_POST["descripcion"];
				$perfilesData[$tmpId]["estado"] = $_POST["estado"];

				$perfilesData[$tmpId]["updated_at"] = date("Y-m-d H:i:s");
				//print_r($tmpItem); exit;
				$perfilJson = json_encode($perfilesData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/perfil.json", $perfilJson);
				$response = ["rst" => 1, "msj"=>"Perfil Actualizado"];
				echo json_encode($response);
				exit;
			} else {
				$tmpItem = [];
				$tmpItem["perfil"] = $_POST["perfil"];
				$tmpItem["descripcion"] = $_POST["descripcion"];
				$tmpItem["estado"] = $_POST["estado"];
				
				$tmpItem["created_at"] = date("Y-m-d H:i:s");
				$tmpItem["updated_at"] = "";
				$tmpItem["deleted_at"] = "";

				$size = count($perfilesData);
				$size = $size +1;
				$perfilesData[$size] = $tmpItem;
				$perfilJson = json_encode($perfilesData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/perfil.json", $perfilJson);
				$response = ["rst" => 1, "msj"=>"Perfil Creado"];
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
		<title>perfiles</title>
	</head>
	<body>
		<?php
			include __DIR__."/resources/views/includes/header.phtml";
		?>
		<div class="container">
			<?php 
				$perfilJson = file_get_contents(__DIR__."/resources/assets/js/perfil.json");
				$perfilesData = json_decode($perfilJson, true);
			?>
			<div class="box box-primary content-table">
				<h1>Listado de Perfiles <div style="width: auto; display: inline-block; float: right;">
					<a href="#" class="btn btn-primary"
						data-toggle="modal"
						data-target="#mdlPerfil">
						<i class="fas fa-plus"></i> Agregar</a>
					</div></h1>
			<div class="table-responsive-md">
  				<table id="table-perfiles" class="table table-striped table-bordered nowrap" style="width:100%">
						<thead>
						    <tr>
						      <th>#</th>
						      <th>Perfil</th>
						      <th>Descripción</th>
						      <th>Estado</th>
						      <th>U.Act.</th>
						      <th>[]</th>
						    </tr>
						</thead>
						<tbody>
						  		<?php 
						  			//print_r($perfilesData); exit;
						    		foreach ($perfilesData as $key => $value) {
						    			$tmpIndex = (int)$key;
						    			if ($value["deleted_at"] == "") {
						    	?>
							    <tr>
							      <th><?php echo $tmpIndex;?></th>
							      <td><?php echo $value["perfil"];?></td>
							      <td><?php echo $value["descripcion"];?></td>
							      <td><?php echo $value["estado"];?></td>
							      <td><?php echo $value["updated_at"];?></td>						
							      <td>
							      	<a href="#"
							      		data-toggle="modal"
							      		data-target="#mdlPerfil"
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
			include __DIR__."/resources/views/modal/mdl_perfil.phtml";
		?>
		<?php
			include __DIR__."/resources/views/includes/script.phtml";
			include __DIR__."/resources/views/includes/loading.phtml";
		?>
		<script type="text/javascript">
			var table = $('#table-perfiles').DataTable({
			   	"language": {
			        "url": "/Spanish.json"
			    },
			    responsive: true
			});
			$(document).ready(function() {
			    
			 
			    //new $.fn.dataTable.FixedHeader( table );
			} );
		</script>
		<script type="text/javascript" src="js/web/perfil.js"></script>
	</body>
</html>
