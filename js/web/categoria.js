$('#mdlCategoria').on('show.bs.modal', function (event) {
	var id = $(event.relatedTarget).data("id");
	if (typeof id !=undefined && typeof id !="undefined") {
		showLoading();
		var categoria = $.ajax({
			type : "GET",
			url : "categoria.php",
			data : {id: id},
			success : function(obj) {
				var objData = JSON.parse(obj);
				$("#txt_id").val(objData.id);
				$("#txt_tipo").val(objData.tipo);
				$("#slct_estado").val(objData.estado);
				removeLoading();
			}
		});
	}

});
$('#mdlCategoria').on('show.bs.modal', function (event) {
	$("input[type=text], select, #txt_id").val("");
});
$("#btn-guardar").click(function() {
	$("#form-categoria").submit();
});
$("#form-categoria").submit(function() {
	showLoading();
	$.ajax({
		type : "POST",
		url : "categoria.php",
		data : $("#form-categoria").serialize(),
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
					window.location.href="categoria.php";
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
			    	url : "categoria.php?action=delete&id="+id,
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