$('#mdlUsuario').on('show.bs.modal', function (event) {
	var id = $(event.relatedTarget).data("id");
	if (typeof id !=undefined && typeof id !="undefined") {
		showLoading();
		Usuario.show(id);
	}
});
$('#mdlUsuario').on('show.bs.modal', function (event) {
	$("input[type=text], select, #txt_id").val("");
});
$("#btn-guardar").click(function() {
	$("#form-usuario").submit();
});
$("#form-usuario").submit(function() {
	showLoading();
	var formData = $("#form-usuario").serialize();
	Usuario.save(formData);
	return false;
});
$(document).delegate(".btn-delete", "click", function(e) {
	var id = e.target.dataset.id;
	Swal.fire({
	  title: '¿Quiere eliminar este Registro?',
	  showCancelButton: true,
	  confirmButtonText: `Eliminar`,
	  cancelButtonText: `Cancelar`,
	}).then((result) => {
		showLoading();
		  /* Read more about isConfirmed, isDenied below */
		  if (result.isConfirmed) {
	  			Usuario.destroy(id);
		  }
	});
});

var Usuario = {
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
	                fila.push(objData[i].ape_paterno);
	                fila.push(objData[i].ape_materno);
	                fila.push(objData[i].sexo);
	                fila.push(objData[i].updated_at);
	                var btn = "";
	                btn+= "<a href='#'";
						btn+="data-toggle='modal' ";
						btn+="data-target='#mdlUsuario' ";
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
		var usuario = $.ajax({
			type : "GET",
			url : "producto_ajax.php",
			data : {id: id, action : "show"},
			success : function(obj) {
				var objData = JSON.parse(obj);
				$("#txt_id").val(objData.id);
				$("#txt_nombre").val(objData.nombre);
				$("#txt_descripcion").val(objData.descripcion);
				$("#txt_estado").val(objData.estado);
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
					Usuario.list();
					setTimeout(function() {
						showLoading();
						$("#mdlUsuario").modal("hide");
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
		    		}
		    	})
	}
};
Usuario.list();