$('#mdlPerfil').on('show.bs.modal', function (event) {
	var id = $(event.relatedTarget).data("id");
	if (typeof id !=undefined && typeof id !="undefined") {
		showLoading();
		var perfil = $.ajax({
			type : "GET",
			url : "perfil.php",
			data : {id: id},
			success : function(obj) {
				var objData = JSON.parse(obj);
				$("#txt_id").val(objData.id);
				$("#txt_dni").val(objData.dni);
				$("#txt_nombres").val(objData.nombres);
				$("#txt_apellidos").val(objData.apellidos);
				//$("#txt_ape_materno").val(objData.ape_materno);
				$("#slct_sexo").val(objData.sexo);
				$("#txt_fecha_Nac").val(objData.fecha_Nac);
				$("#txt_direccion").val(objData.direccion);
				$("#txt_numero_telefono").val(objData.numero_telefono);
				//$("#txt_carrera").val(objData.carrera);
				removeLoading();
			}
		});
	}

});
$('#mdlPerfil').on('show.bs.modal', function (event) {
	$("input[type=text], select, #txt_id").val("");
});
$("#btn-guardar").click(function() {
	$("#form-perfil").submit();
});
$("#form-perfil").submit(function() {
	showLoading();
	$.ajax({
		type : "POST",
		url : "perfil.php",
		data : $("#form-perfil").serialize(),
		success : function(obj) {
			var objData = JSON.parse(obj);
			if (parseInt(objData.rst) == 1) {
				Swal.fire(
					'Muy Bien!',
					objData.msj,
					'success'
				);
				removeLoading();
				setTimeout(function() {
					showLoading();
					window.location.href="perfil.php";
				}, 2000);
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: objData.msj
				});
				removeLoading();
			}
		}
	})
	return false;
});
$(".btn-delete").click(function(e) {
	var id = $(e.target).data("id");
	Swal.fire({
	  title: '¿Quiere eliminar este Registro?',
	  showCancelButton: true,
	  confirmButtonText: `Eliminar`,
	  cancelButtonText: `Cancelar`,
	}).then((result) => {
		showLoading();
		  /* Read more about isConfirmed, isDenied below */
		  if (result.isConfirmed) {
		    	$.ajax({
		    		type : "GET",
		    		url : "perfil.php?action=delete&id="+id,
		    		success : function(obj) {
		    			var objData = JSON.parse(obj);
		    			Swal.fire(
							'Muy Bien!',
							objData.msj,
							'success'
						);
		    			removeLoading();
		    			window.location.href="perfil.php";
		    		}
		    	})
		  }
	});
})