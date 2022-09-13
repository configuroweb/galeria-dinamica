$(document).ready(function(){	

	$(".gallery").on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "deleteImage";
		if(confirm("¿Deseas eliminar esta imagen?")) {
			$.ajax({
				url:"gallery_action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(response) {
					console.log("dgdsgdsgs");
					$("#gallery_image_"+id).remove();
				}
			});
		} else {
			return false;
		}
	});
	
});