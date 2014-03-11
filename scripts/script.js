$(document).ready(function(){
	
	$('div.thumbnail').click(function(event){
		$albumID = $('#id').val();
		$.ajax({
			url: 'view.php',
			type: 'POST',
			data: {albumIDY: $albumID}
			success: function(data){
				console.log(data);
			}
		});
	});
	

});