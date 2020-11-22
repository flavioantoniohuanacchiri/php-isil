<?php 
	include __DIR__."/functions/session_helper.php";
	if (isset($_GET)) {
		if (count($_GET) > 0) {
			if (isset($_GET["action"])) {
				switch ($_GET["action"]) {
					case 'delete':
						$empleadosJson = file_get_contents(__DIR__."/resources/assets/js/ajax_data_empleado.json");
						$empleadosData = json_decode($empleadosJson, true);
						$tmpId = $_GET["id"];
						$empleadosData[$tmpId]["deleted_at"] = date("Y-m-d H:i:s");
						$empleadosJson = json_encode($empleadosData, JSON_UNESCAPED_UNICODE);
						file_put_contents(__DIR__."/resources/assets/js/ajax_data_empleado.json", $empleadosJson);
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
				$empleadosJson = file_get_contents(__DIR__."/resources/assets/js/ajax_data_empleado.json");
				$empleadosData = json_decode($empleadosJson, true);
				$tmpId = $_GET["id"];
				if (isset($empleadosData[$tmpId])) {
					$empleadosData[$tmpId]["id"] = $tmpId;
					echo json_encode($empleadosData[$tmpId]);
					exit;
				}

			}
		}
	}
	if (isset($_POST)) {
		if (count($_POST) > 0) {
			$empleadosJson = file_get_contents(__DIR__."/resources/assets/js/ajax_data_empleado.json");
			$empleadosData = json_decode($empleadosJson, true);
			if (isset($_POST["id"]) && $_POST["id"] !="") {
				$tmpId = $_POST["id"];
				$tmpItem = $empleadosData[$tmpId];
				//print_r($tmpItem);
				$empleadosData[$tmpId]["nombres"] = $_POST["nombres"];
				$empleadosData[$tmpId]["ape_paterno"] = $_POST["ape_paterno"];
				$empleadosData[$tmpId]["ape_materno"] = $_POST["ape_materno"];
				$empleadosData[$tmpId]["sexo"] = $_POST["sexo"];
				$empleadosData[$tmpId]["carrera"] = $_POST["carrera"];
				$empleadosData[$tmpId]["grado"] = $_POST["grado"];
				$empleadosData[$tmpId]["universidad"] = $_POST["universidad"];
				$empleadosData[$tmpId]["anio_egreso"] = (int)$_POST["anio_egreso"];

				$emplaedoData[$tmpId]["updated_at"] = date("Y-m-d H:i:s");
				//print_r($tmpItem); exit;
				$empleadoJson = json_encode($empleadoData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/ajax_data_empleado.json", $empleadoJson);
				$response = ["rst" => 1, "msj"=>"Empleado Actualizado"];
				echo json_encode($response);
				exit;
			} else {
				$tmpItem = [];
				$tmpItem["nombres"] = $_POST["nombres"];
				$tmpItem["ape_paterno"] = $_POST["ape_paterno"];
				$tmpItem["ape_materno"] = $_POST["ape_materno"];
				$tmpItem["sexo"] = $_POST["sexo"];
				$tmpItem["carrera"] = $_POST["carrera"];
				$tmpItem["grado"] = $_POST["grado"];
				$tmpItem["universidad"] = $_POST["universidad"];
				$tmpItem["anio_egreso"] = (int)$_POST["anio_egreso"];
				
				$tmpItem["created_at"] = date("Y-m-d H:i:s");
				$tmpItem["updated_at"] = "";
				$tmpItem["deleted_at"] = "";

				$size = count($usuariosData);
				$size = $size +1;
				$usuariosData[$size] = $tmpItem;
				$usuarioJson = json_encode($usuariosData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/ajax_data_empleado.json", $usuarioJson);
				$response = ["rst" => 1, "msj"=>"Usuario Creado"];
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
		<title>Empleado</title>
	</head>
	<body>
		<?php
			include __DIR__."/resources/views/includes/header.phtml";
		?>
		<div class="container">
			<?php 
				//echo file_get_contents(__DIR__."/resources/assets/js/usuario.json"); exit;
				$empleadosJson = file_get_contents(__DIR__."/resources/assets/js/ajax_data_empleado.json");
				$empleadosData = json_decode($empleadosJson, true);
			?>
			<div class="box box-primary content-table">
				<h1>Listado de Empleado <div style="width: auto; display: inline-block; float: right;">
					<a href="#" class="btn btn-primary"
						data-toggle="modal"
						data-target="#mdlEmpleado">
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
							  <th>Posicion</th>
						      <th>Area</th>
						      <th>Salario</th>
						      <th>Día de Inicio</th>
						      <th>Fecha de Creación</th>
						      <th>Fecha de Actualización</th>
						      <th>Fecha de Eliminación</th>
						    </tr>
						</thead>
						<tbody>
						  		<?php 
						  			//print_r($usuariosData); exit;
						    		foreach ($empleadosData as $key => $value) {
						    		//	$tmpIndex = (int)$key;
						    		//	if ($value["deleted_at"] == "") {
						    	?>
							    <tr>
							      <th><?php echo $tmpIndex;?></th>
							      <td><?php echo $value["nombres"];?></td>
							      <td><?php echo $value["ape_paterno"];?></td>
							      <td><?php echo $value["ape_materno"];?></td>
							      <td><?php echo $value["sexo"];?></td>
								  <td><?php echo $value["posicion"];?></td>
								  <td><?php echo $value["area"];?></td>
								  <td><?php echo $value["salario"];?></td>
								  <td><?php echo $value["start_date"];?></td>
								  <td><?php echo $value["created_at"];?></td>
								  <td><?php echo $value["updated_at"];?></td>
							      <td><?php echo $value["deleted_at"];?></td>
							      <td>
							      	<a href="#"
							      		data-toggle="modal"
							      		data-target="#mdlEmpleado"
							      		class="btn btn-primary"
							      		data-id="<?php echo $key;?>">
							      		<i class="fas fa-pencil-alt"></i>
							      	</a>
							      	<a class="btn btn-danger btn-delete" data-id="<?php echo $key;?>">
							      		<i class="fas fa-trash"></i>
							      	</a>
							      </td>
							    </tr>
							<?php //}
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
			var table = $('#table-empleado').DataTable({
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
