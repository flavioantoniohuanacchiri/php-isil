$('#mdlCategoria').on('show.bs.modal', function (event) {
	var id = $(event.relatedTarget).data("id");
	if (typeof id !=undefined && typeof id !="undefined") {
		showLoading();
		var usuario = $.ajax({
			type : "GET",
			url : "categoria.php",
			data : {id: id},
			success : function(obj) {
				var objData = JSON.parse(obj);
				$("#txt_id").val(objData.id);
				$("#txt_codigo").val(objData.codigo);
				$("#txt_descripcion").val(objData.descripcion);
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
$(".btn-delete").click(function(e) {
	var id = $(e.target).data("id");
	Swal.fire({
	  title: '¿Quiere eliminar este Registro?',
	  showCancelButton: true,
	  confirmButtonText: `Eliminar`,
	  cancelButtonText: `Cancelar`,
	}).then((result) => {
	  /* Read more about isConfirmed, isDenied below */
	  if (result.isConfirmed) {
		$.ajax({
			type : "GET",
			url : "categoria.php?action=delete&id="+id,
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
	  }
	});
})