$('#mdlProducto').on('show.bs.modal', function (event) {
	var id = $(event.relatedTarget).data("id");
	if (typeof id !=undefined && typeof id !="undefined") {
		showLoading();
		var Producto = $.ajax({
			type : "GET",
			url : "producto_ajax.php?action=list",
			data : {id: id},
			success : function(obj) {
				var objData = JSON.parse(obj);
				$("#txt_id").val(objData.id);
				$("#txt_nombres").val(objData.nombres);
				$("#txt_descripcion").val(objData.descripcion);
				$("#txt_estado").val(objData.estado);
			/*	
				$("#slct_sexo").val(objData.sexo);
				$("#txt_carrera").val(objData.carrera);
				$("#txt_grado").val(objData.grado);
				$("#txt_universidad").val(objData.universidad);
				$("#slct_anio_egreso").val(objData.anio_egreso);
			*/
				removeLoading();
			}
		});
	}

});
$('#mdlProducto').on('show.bs.modal', function (event) {
	$("input[type=text], select, #txt_id").val("");
});
$("#btn-guardar").click(function() {
	$("#form-producto").submit();
});
$("#form-producto").submit(function() {
	showLoading();
	$.ajax({
		type : "POST",
		url : "producto_ajax.php?action=save&id="+id,
		data : $("#form-producto").serialize(),
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
					window.location.href="producto_list.php";
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
		    		url : "producto.php?action=delete&id="+id,
		    		success : function(obj) {
		    			var objData = JSON.parse(obj);
		    			Swal.fire(
							'Muy Bien!',
							objData.msj,
							'success'
						);
		    			removeLoading();
		    		}
		    	})
		  }
	});
});

var Producto = {
	list : function(obj) {
		showLoading();
		$.ajax({
			type : "GET",
			url : "producto_ajax.php?action=list",
			success : function(obj) {
				console.log(obj);
				var objData = JSON.parse(obj);
				table.clear().draw();
	            for(var i in objData) {
	            	let index = parseInt(i);
	            	let fila = [];
	            	index++;
	                fila.push(index);
	                fila.push(objData[i].nombres);
	                fila.push(objData[i].descripcion);
	                fila.push(objData[i].estado);
	                fila.push(objData[i].created_at);
	                fila.push(objData[i].updated_at);
	                fila.push(objData[i].deleted_at);
	                var btn = "";
	                btn+= "<a href='#'";
						btn+="data-toggle='modal' ";
						btn+="data-target='#mdlProducto' ";
						btn+="class='btn btn-primary' ";
						btn+="data-id='"+objData[i].id+"'>";
						btn+="<i class='fas fa-pencil-alt'></i>";
						btn+="</a>";
	                fila.push(btn);
	                console.log(fila);
	                table.row.add(fila).draw();
	            }
	            removeLoading();
			}
		});
	}
};
Producto.list();