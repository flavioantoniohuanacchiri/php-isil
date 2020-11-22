<?php 
	include __DIR__."/functions/session_helper.php";
	if (isset($_GET)) {
		if (count($_GET) > 0) {
			if (isset($_GET["id"])) {
				$empresaJson = file_get_contents(__DIR__."/resources/assets/js/empresa.json");
				$empresasData = json_decode($empresaJson, true);
				$tmpId = $_GET["id"];
				if (isset($empresasData[$tmpId])) {
					$empresasData[$tmpId]["id"] = $tmpId;
					echo json_encode($empresasData[$tmpId]);
					exit;
				}

			}
		}
	}
	if (isset($_POST)) {
		if (count($_POST) > 0) {
			$empresaJson = file_get_contents(__DIR__."/resources/assets/js/empresa.json");
			$empresasData = json_decode($empresaJson, true);
			if (isset($_POST["id"]) && $_POST["id"] !="") {
				$tmpId = $_POST["id"];
				$tmpItem = $empresasData[$tmpId];
				//print_r($tmpItem);
				$empresasData[$tmpId]["razon"] = $_POST["razon"];
				$empresasData[$tmpId]["ruc"] = $_POST["ruc"];
				$empresasData[$tmpId]["direccion"] = $_POST["direccion"];
				$empresasData[$tmpId]["distrito"] = $_POST["distrito"];
				$empresasData[$tmpId]["actualizacion"] = $_POST["actualizacion"];
				$empresasData[$tmpId]["estado"] = $_POST["estado"];
				//print_r($tmpItem); exit;
				$empresaJson = json_encode($empresasData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/empresa.json", $empresaJson);
				$response = ["rst" => 1, "msj"=>"Empresa Actualizada"];
				echo json_encode($response);
				exit;
			} else {
				$tmpItem = [];
				$tmpItem["razon"] = $_POST["razon"];
				$tmpItem["ruc"] = $_POST["ruc"];
				$tmpItem["direccion"] = $_POST["direccion"];
				$tmpItem["distrito"] = $_POST["distrito"];
				$tmpItem["actualizacion"] = $_POST["actualizacion"];
				$tmpItem["estado"] = $_POST["estado"];
				$tmpItem["created_at"] = date("Y-m-d H:i:s");
				$tmpItem["updated_at"] = "";
				$tmpItem["deleted_at"] = "";

				$size = count($empresasData);
				$size = $size +1;
				$empresasData[$size] = $tmpItem;
				$empresaJson = json_encode($empresasData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/empresa.json", $empresaJson);
				$response = ["rst" => 1, "msj"=>"Empresa Creada"];
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
		<title>Empresas</title>
	</head>
	<body>
		<?php
			include __DIR__."/resources/views/includes/header.phtml";
		?>
		<div class="container">
			<?php 
				//echo file_get_contents(__DIR__."/resources/assets/js/empresa.json"); exit;
				$empresaJson = file_get_contents(__DIR__."/resources/assets/js/empresa.json");
				$empresaData = json_decode($empresaJson, true);
			?>
			<div class="box box-primary content-table">
				<h1>Listado de Empresas </h1>
			<div class="table-responsive-md">
  				<table id="table-empresas" class="table table-striped table-bordered nowrap" style="width:100%">
						<thead>
						    <tr>
						      <th>#</th>
						      <th>Razón Social</th>
						      <th>RUC</th>
						      <th>Dirección</th>
						      <th>Ultima Actualización</th>
						      <th>Estado</th>
						      <th>[]</th>
						    </tr>
						</thead>
						<tbody>
						  		<?php 
						  			//print_r($empresasData); exit;
						    		foreach ($empresaData as $key => $value) {
						    			$tmpIndex = (int)$key;
						    			//$tmpIndex = $tmpIndex+1;
						    	?>
							    <tr>
							      <th><?php echo $tmpIndex;?></th>
							      <td><?php echo $value["razon"];?></td>
							      <td><?php echo $value["ruc"];?></td>
							      <td><?php echo $value["direccion"];?></td>
							      <td><?php echo $value["actualizacion"];?></td>
							      <td><?php echo $value["estado"];?></td>
							      <td>
							      	<a href="#"
							      		data-toggle="modal"
							      		data-target="#mdlEmpresa"
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
			include __DIR__."/resources/views/modal/mdl_empresa.phtml";
		?>
		<?php
			include __DIR__."/resources/views/includes/script.phtml";
			include __DIR__."/resources/views/includes/loading.phtml";
		?>
		<script type="text/javascript">
			var table = $('#table-empresas').DataTable({
			   	"language": {
			        "url": "/Spanish.json"
			    },
			    responsive: true
			});
			$(document).ready(function() {
			    
			 
			    //new $.fn.dataTable.FixedHeader( table );
			} );
		</script>
		<script type="text/javascript" src="js/web/empresa.js"></script>
	</body>
</html>
