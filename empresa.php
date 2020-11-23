<?php 
	include __DIR__."/functions/session_helper.php";
	if (isset($_POST)) {
		if (count($_POST) > 0) {
			$usuarioJson = file_get_contents(__DIR__."/resources/assets/js/empresa.json");
			$usuariosData = json_decode($usuarioJson, true);
			echo json_encode($usuariosData);
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
			<div class="box box-primary content-table">
				<h1>Listado de Usuarios</h1>
				<div class="table-responsive-md">
	  				<table id="table-empresa" class="table table-striped table-bordered nowrap" style="width:100%">
						<thead>
				            <tr>
				                <th>Name</th>
				                <th>Position</th>
				                <th>Office</th>
				                <th>Extn.</th>
				                <th>Start date</th>
				                <th>Salary</th>
								<th>[]</th>
				            </tr>
				        </thead>
						<tbody>
						  		<?php 
						  			//print_r($usuariosData); exit;
						    		foreach ($usuariosData as $key => $value) {
						    	?>
							    <tr>
							      <td><?php echo $value["name"];?></td>
							      <td><?php echo $value["position"];?></td>
							      <td><?php echo $value["office"];?></td>
							      <td><?php echo $value["extn"];?></td>
								  <td><?php echo $value["start date"];?></td>
								  <td><?php echo $value["salary"];?></td>
							      <td>
							      	<a 	href="#" 
									  	data-toggle="modal" 
										data-target="#mdl_empresa" 
										class="btn btn-primary" 
									>
									  <i class="fas fa-pencil-alt"></i>
							      	</a>
							      	<button class="btn btn-danger">
							      		<i class="fas fa-trash"></i>
							      	</button>
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
		        "ajax": 'resources/assets/js/empresa.json',
		        responsive: true
		    });

		</script>
	</body>
</html>