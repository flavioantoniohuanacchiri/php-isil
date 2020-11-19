<?php 
	include __DIR__."/functions/session_helper.php";
	if (isset($_GET)) {
		if (count($_GET) > 0) {
			if (isset($_GET["id"])) {
				$empresaJson = file_get_contents(__DIR__."/resources/assets/js/empresa.json");
				$empresaData = json_decode($empresaJson, true);
				$tmpId = $_GET["id"];
				if (isset($empresaData[$tmpId])) {
					$empresaData[$tmpId]["id"] = $tmpId;
					echo json_encode($empresaData[$tmpId]);
					exit;
				}

			}
		}
	}
	if (isset($_POST)) {
		if (count($_POST) > 0) {
			$empresaJson = file_get_contents(__DIR__."/resources/assets/js/empresa.json");
			$empresaData = json_decode($empresaJson, true);
			if (isset($_POST["id"]) && $_POST["id"] !="") {
				$tmpId = $_POST["id"];
				$tmpItem = $empresaData[$tmpId];
				//print_r($tmpItem);
				$empresaData[$tmpId]["razon_social"] = $_POST["razon_social"];
				$empresaData[$tmpId]["ruc"] = $_POST["ruc"];
				$empresaData[$tmpId]["direccion"] = $_POST["direccion"];
				$empresaData[$tmpId]["updated_at"] = date("Y-m-d H:i:s");
				$empresaData[$tmpId]["status"] = $_POST["status"];
				//print_r($tmpItem); exit;
				$empresaJson = json_encode($empresaData, JSON_UNESCAPED_UNICODE);
				file_put_contents(__DIR__."/resources/assets/js/empresa.json", $empresaJson);
				$response = ["rst" => 1, "msj"=>"Empresa Actualizada"];
				echo json_encode($response);
				exit;
			} else {
				$tmpItem = [];
				$tmpItem["razon_social"] = $_POST["razon_social"];
				$tmpItem["ruc"] = $_POST["ruc"];
				$tmpItem["direccion"] = $_POST["direccion"];
				$tmpItem["updated_at"] = "";
				$tmpItem["deleted_at"] = "";

				$size = count($empresaData);
				$size = $size +1;
				$empresaData[$size] = $tmpItem;
				$empresaJson = json_encode($empresaData, JSON_UNESCAPED_UNICODE);
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
				//echo file_get_contents(__DIR__."/resources/assets/js/usuario.json"); exit;
				$empresaJson = file_get_contents(__DIR__."/resources/assets/js/empresa.json");
				$empresaData = json_decode($empresaJson, true);
			?>
			<div class="box box-primary content-table">
				<h1>Listado de Empresas <div style="width: auto; display: inline-block; float: right;">
					<a href="#" class="btn btn-primary"
						data-toggle="modal"
						data-target="#mdlEmpresa">
						<i class="fas fa-plus"></i> Agregar</a>
					</div></h1>
			<div class="table-responsive-md">
  				<table id="table-empresa" class="table table-striped table-bordered nowrap" style="width:100%">
						<thead>
						    <tr>
						      <th>#</th>
						      <th>Razon Social</th>
						      <th>RUC</th>
						      <th>Direccion</th>
						      <th>Ult. Actualizacion</th>
						      <th>Estado</th>
						    </tr>
						</thead>
						<tbody>
						  		<?php 
						  			//print_r($usuariosData); exit;
						    		foreach ($empresaData as $key => $value) {
						    			$tmpIndex = (int)$key;
						    			$tmpIndex = $tmpIndex+1;
						    	?>
							    <tr>
							      <th><?php echo $tmpIndex;?></th>
							      <td><?php echo $value["razon_social"];?></td>
							      <td><?php echo $value["ruc"];?></td>
							      <td><?php echo $value["direccion"];?></td>
							      <td><?php echo $value["updated_at"];?></td>
								  <td><?php echo $value["status"];?></td>
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
			var table = $('#table-empresa').DataTable({
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
