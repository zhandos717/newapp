$(document).ready(function() {
	$('form').submit(function(event) {
		var json;
		event.preventDefault();
		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function(result) {
                console.dir(result);
				//json = jQuery.parseJSON(result);
				// if (json.url) {
				// 	window.location.href = '/' + json.url;
				// } else {
                // $('.alert-danger').css('display', 'block').html("<p>Test</p>");
				// alert(json.status + ' - ' + json.message);
				// }
			},
		});
	});
});