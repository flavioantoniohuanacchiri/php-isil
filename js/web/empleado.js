$('#mdlempleado').on('show.bs.modal', function (event) {
	var id = $(event.relatedTarget).data("id");
	if (typeof id !=undefined && typeof id !="undefined") {
		showLoading();
		var empleado = $.ajax({
			type : "GET",
			url : "empleado.php",
			data : {id: id},
			success : function(obj) {
				var objData = JSON.parse(obj);
				$("#txt_id").val(objData.id);
				$("#txt_nombres").val(objData.nombres);
				$("#txt_ape_paterno").val(objData.ape_paterno);
				$("#txt_ape_materno").val(objData.ape_materno);
				$("#slct_sexo").val(objData.sexo);
				$("#slct_estado").val(objData.estado);

				removeLoading();
			}
		});
	}

});
$('#mdlempleado').on('show.bs.modal', function (event) {
	$("input[type=text], select, #txt_id").val("");
});
$("#btn-guardar").click(function() {
	$("#form-empleado").submit();
});
$("#form-empleado").submit(function() {
	showLoading();
	$.ajax({
		type : "POST",
		url : "empleado.php",
		data : $("#form-empleado").serialize(),
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
					window.location.href="empleado.php";
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
$(document).delegate(".btn-delete", "click", function(e) {
	var id = e.target.dataset.id;
	Swal.queue([{
		title: '¿Estás seguro de eliminarlo?',
		text: "Este cambio no es reversible!",
	  	type: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Si deseo, eliminarlo!',
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		showLoaderOnConfirm: true
	}]).then(function(result) {
		if (typeof result.value!="undefined" && typeof result.value!=undefined) {
			if (result.value[0]) {
				showLoading();
				$.ajax({
			    	type : "GET",
			    	url : "empleado.php?action=delete&id="+id,
			    	success : function(obj) {
			    		var objData = JSON.parse(obj);
			    		Swal.fire(
							'Muy Bien!',
							objData.msj,
							'success'
						);
			    		removeLoading();
			    		setTimeout(function() {
			    			location.reload();
			    		}, 1000);
			    	}
			    });
			}
		}
	});
});