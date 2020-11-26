$('#mdlProducto').on('show.bs.modal', function (event) {
	var id = $(event.relatedTarget).data("id");
	if (typeof id !=undefined && typeof id !="undefined") {
		showLoading();
		Producto.show(id);
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
	var formData = $("#form-producto").serialize();
	Producto.save(formData);
	return false;
});
$(document).delegate(".btn-delete", "click", function(e) {
	var id = $(this).data("id");
	Swal.fire({
	  title: '¿Quiere eliminar este Registro?',
	  showCancelButton: true,
	  confirmButtonText: `Eliminar`,
	  cancelButtonText: `Cancelar`,
	}).then((result) => {
		showLoading();
		  /* Read more about isConfirmed, isDenied below */
		  if (result.isConfirmed) {
	  			Producto.destroy(id);
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
	                fila.push(objData[i].nombre);
	                fila.push(objData[i].descripcion);
	                fila.push(objData[i].estado);
	                fila.push(objData[i].updated_at);
	                var btn = "";
	                btn+= "<a href='#'";
						btn+="data-toggle='modal' ";
						btn+="data-target='#mdlProducto' ";
						btn+="class='btn btn-primary' ";
						btn+="data-id='"+objData[i].id+"'>";
						btn+="<i class='fas fa-pencil-alt'></i>";
						btn+="</a>";
						btn+="<a href='#'";
						btn+=" class='btn btn-danger btn-delete' ";
						btn+=" data-id='"+objData[i].id+"'> ";
						btn+="<i class='fas fa-trash-alt'></i>";
						btn+="</a>";
	                fila.push(btn);
	                console.log(fila);
	                table.row.add(fila).draw();
	            }
	            removeLoading();
			}
		});
	},
	show : function(id) {
		var producto = $.ajax({
			type : "GET",
			url : "producto_ajax.php",
			data : {id: id, action : "show"},
			success : function(obj) {
				var objData = JSON.parse(obj);
				$("#txt_id").val(objData.id);
				$("#txt_nombre").val(objData.nombre);
				$("#txt_descripcion").val(objData.descripcion);
				$("#slct_estado").val(objData.estado);
				removeLoading();
			}
		});
	},
	save : function (formData) {
		$.ajax({
			type : "POST",
			url : "producto_ajax.php?action=save",
			data : formData,
			success : function(obj) {
				var objData = JSON.parse(obj);
				if (parseInt(objData.rst) == 1) {
					Swal.fire(
						'Muy Bien!',
						objData.msj,
						'success'
					);
					removeLoading();
					Producto.list();
					setTimeout(function() {
						$("#mdlProducto").modal("hide");
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
		});
	},
	destroy : function(usuarioId) {
		$.ajax({
		    		type : "GET",
		    		url : "producto_ajax.php?action=delete&id="+usuarioId,
		    		success : function(obj) {
		    			var objData = JSON.parse(obj);
		    			Swal.fire(
							'Muy Bien!',
							objData.msj,
							'success'
						);
		    			removeLoading();
		    			window.location = "producto_list.php"
		    		}
		    	})
	}
};
Producto.list();