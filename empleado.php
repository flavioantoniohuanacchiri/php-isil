<?php 
	include __DIR__."/functions/session_helper.php";
	if (isset($_GET)) {
		if (count($_GET) > 0) {
			if (isset($_GET["action"])) {
				switch ($_GET["action"]) {
					case 'delete':
						$empleadoJson = file_get_contents(__DIR__."/resources/assets/js/empleado.json");
						$empleadoData = json_decode($empleadoJson, true);
						$tmpId = $_GET["id"];
						$empleadoData[$tmpId]["deleted_at"] = date("Y-m-d H:i:s");
						$empleadoJson = json_encode($empleadoData, JSON_UNESCAPED_UNICODE);
						file_put_contents(__DIR__."/resources/assets/js/empleado.json", $empleadoJson);
						$response = ["rst" => 1, "msj"=>"Empleado Eliminado"];
						echo json_encode($response);
						exit;
						break;
					
					default:
						# code...
						break;
				}
			}
			if (isset($_GET["id"])) {
				$empleadoJson = file_get_contents(__DIR__."/resources/assets/js/empleado.json");
				$empleadoData = json_decode($empleadoJson, true);
				$tmpId = $_GET["id"];
				if (isset($empleadoData[$tmpId])) {
					$empleadoData[$tmpId]["id"] = $tmpId;
					echo json_encode($empleadoData[$tmpId]);
					exit;
				}

			}
		}
	}
	if (isset($_POST)) {
		if (count($_POST) > 0) {
			$empleadoJson = file_get_contents(__DIR__."/resources/assets/js/empleado.json");
			$empleadoData = json_decode($empleadoJson, true);
			if (isset($_POST["id"]) && $_POST["id"] !="") {
				$tmpId = $_POST["id"];
				$tmpItem = $empleadoData[$tmpId];
				//print_r($tmpItem);
				$empleadoData[$tmpId]["nombres"] = $_POST["nombres"];
				$empleadoData[$tmpId]["ape_paterno"] = $_POST["ape_paterno"];
				$empleadoData[$tmpId]["ape_materno"] = $_POST["ape_materno"];
				$empleadoData[$tmpId]["sexo"] = $_POST["sexo"];
				$empleadoData[$tmpId]["estado"] = $_POST["estado"];
			
				$empleadoData[$tmpId]["updated_at"] = date("Y-m-d H:i:s");
				//print_r($tmpItem); exit;
				$empleadoJson = json_encode($empleadoData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/empleado.json", $empleadoJson);
				$response = ["rst" => 1, "msj"=>"Empleado Actualizado"];
				echo json_encode($response);
				exit;
			} else {
				$tmpItem = [];
				$tmpItem["nombres"] = $_POST["nombres"];
				$tmpItem["ape_paterno"] = $_POST["ape_paterno"];
				$tmpItem["ape_materno"] = $_POST["ape_materno"];
				$tmpItem["sexo"] = $_POST["sexo"];
				$tmpItem["estado"] = $_POST["estado"];
					
				$tmpItem["created_at"] = date("Y-m-d H:i:s");
				$tmpItem["updated_at"] = "";
				$tmpItem["deleted_at"] = "";

				$size = count($empleadoData);
				$size = $size +1;
				$empleadoData[$size] = $tmpItem;
				$empleadoJson = json_encode($empleadoData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/empleado.json", $empleadoJson);
				$response = ["rst" => 1, "msj"=>"Empleado Creado"];
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
		<title>Empleados</title>
	</head>
	<body>
		<?php
			include __DIR__."/resources/views/includes/header.phtml";
		?>
		<div class="container">
			<?php 
				//echo file_get_contents(__DIR__."/resources/assets/js/empleado.json"); exit;
				$empleadoJson = file_get_contents(__DIR__."/resources/assets/js/empleado.json");
				$empleadoData = json_decode($empleadoJson, true);
			?>
			<div class="box box-primary content-table">
				<h1>Listado de Empleados <div style="width: auto; display: inline-block; float: right;">
					<a href="#" class="btn btn-primary"
						data-toggle="modal"
						data-target="#mdlempleado">
						<i class="fas fa-plus"></i> Agregar</a>
					</div></h1>
			<div class="table-responsive-md">
  				<table id="table-empleados" class="table table-striped table-bordered nowrap" style="width:100%">
						<thead>
						    <tr>
						      <th>#</th>
						      <th>Nombres</th>
						      <th>Ape Paterno</th>
						      <th>Ape Materno</th>
						      <th>Sexo</th>
							  <th>Estado</th>
						      <th>U.Act.</th>
						      <th>[]</th>
						    </tr>
						</thead>
						<tbody>
						  		<?php 
						  			//print_r($empleadoData); exit;
						    		foreach ($empleadoData as $key => $value) {
						    			$tmpIndex = (int)$key;
						    			if ($value["deleted_at"] == "") {
						    	?>
							    <tr>
							      <th><?php echo $tmpIndex;?></th>
							      <td><?php echo $value["nombres"];?></td>
							      <td><?php echo $value["ape_paterno"];?></td>
							      <td><?php echo $value["ape_materno"];?></td>
							      <td><?php echo $value["sexo"];?></td>
								  <td><?php echo $value["estado"];?></td>
							      <td><?php echo $value["updated_at"];?></td>
							      <td>
							      	<a href="#"
							      		data-toggle="modal"
							      		data-target="#mdlempleado"
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
			include __DIR__."/resources/views/modal/mdl_empleado.phtml";
		?>
		<?php
			include __DIR__."/resources/views/includes/script.phtml";
			include __DIR__."/resources/views/includes/loading.phtml";
		?>
		<script type="text/javascript">
			var table = $('#table-empleados').DataTable({
			   	"language": {
			        "url": "/Spanish.json"
			    },
			    responsive: true
			});
			$(document).ready(function() {
			    
			 
			    //new $.fn.dataTable.FixedHeader( table );
			} );
		</script>
		<script type="text/javascript" src="js/web/empleado.js"></script>
	</body>
</html>
