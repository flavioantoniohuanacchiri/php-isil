<?php 
	include __DIR__."/functions/session_helper.php";
	if (isset($_POST)) {
		if (count($_POST) > 0) {
			$usuarioJson = file_get_contents(__DIR__."/resources/assets/js/ajax_data_empresa.json");
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
		<title>Usuarios</title>
	</head>
	<body>
		<?php
			include __DIR__."/resources/views/includes/header.phtml";
		?>
		<div class="container">
			<div class="box box-primary content-table">
				<h1>Listado de Empresas</h1>
				<div class="table-responsive-md">
	  				<table id="table-empresas" class="table table-striped table-bordered nowrap" style="width:100%">
						<thead>
				            <tr>
				                <th>Razón Social</th>
				                <th>RUC</th>
				                <th>Direccion</th>
				                <th>Ultima Actua.</th>
				                <th>Estado</th>
				            </tr>
				        </thead>
				        <tfoot>
				            <tr>
							    <th>RazonSocial</th>
				                <th>RUC</th>
				                <th>Direccion</th>
				                <th>Last_at</th>
				                <th>Status</th>
				                
				            </tr>
				        </tfoot>
					</table>
				</div>
			</div>
			<hr>
			<div class="box box-primary content-table">
				<h1>Listado de Empresas <div style="width: auto; display: inline-block; float: right;">
					<a href="#" class="btn btn-primary"
						data-toggle="modal"
						data-target="#mdlEmpresa">
						<i class="fas fa-plus"></i> Agregar</a>
					</div></h1>
				<div class="table-responsive-md">
	  				<table id="table-empresas" class="table table-striped table-bordered nowrap" style="width:100%">
						<thead>
				            <tr>
							    <th>RazonSocial</th>
				                <th>RUC</th>
				                <th>Direccion</th>
				                <th>Last_at</th>
				                <th>Status</th>
				            </tr>
				        </thead>
				        <tfoot>
				            <tr>
							    <th>RazonSocial</th>
				                <th>RUC</th>
				                <th>Direccion</th>
				                <th>Last_at</th>
				                <th>Status</th>
				            </tr>
				        </tfoot>
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
		        "ajax": 'resources/assets/js/ajax_data_empresa.json',
		        responsive: true
		    });

		    var tableDos = $('#table-empresas').DataTable( {
		        "processing": true,
		        "serverSide": true,
		        "responsive" : true,
		        "ajax": {
		            "url": "empresa.php",
		            "type": "POST"
		        },
		        "columns": [
		            { "data": "RazonSocial" },
		            { "data": "RUC" },
		            { "data": "Direccion" },
		            { "data": "last_at" },
		            { "data": "status" }
		        ]
		    } );
		</script>
	</body>
</html>
