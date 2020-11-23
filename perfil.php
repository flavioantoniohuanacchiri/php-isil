<?php 
	include __DIR__."/functions/session_helper.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include __DIR__."/resources/views/includes/head.phtml";
		?>
		<title>Perfiles</title>
	</head>
	<body>
		<?php
			include __DIR__."/resources/views/includes/header.phtml";
		?>
		<div class="container">
			<?php 
				//echo file_get_contents(__DIR__."/resources/assets/js/usuario.json"); exit;
				//$usuariosData = json_decode(file_get_contents(__DIR__."/resources/assets/js/usuario.json"), true);
				$usuarioJson = file_get_contents(__DIR__."/resources/assets/js/perfil.json");
				$usuariosData = json_decode($usuarioJson,true);
			?>
			<div class="box box-primary content-table">
				<h1>Listado de Perfiles</h1>
			<div class="table-responsive-md">
  				<table id="table-perfil" class="table table-striped table-bordered nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Razon Social</th>
                            <th>RUC</th>
                            <th>Direccion</th>
                            <th>Ultima Actualizacion</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
					  	<?php 
					  		//print_r($usuariosData); exit;
					    	foreach ($usuariosData as $key => $value) {
					    ?>
						    <tr>
                                <th><?php echo $key;?></th>
                                <td><?php echo $value["Razon Social"];?></td>
                                <td><?php echo $value["RUC"];?></td>
                                <td><?php echo $value["Direccion"];?></td>
                                <td><?php echo $value["Ultima Actualizacion"];?></td>
                                <td><?php echo $value["Estado"];?></td>
                                <td>
                                    <a 	href="#" 
									  	data-toggle="modal" 
										data-target="#mdlPerfil" 
										class="btn btn-primary" 
										data-id="<?php echo $value['id'];?>">
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
        <nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>
		<?php 
			include __DIR__."/resources/views/modal/mdl_perfil.phtml";
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
        <script type="text/javascript" src="js/web/perfil.js"></script>
	</body>
</html>