function addSave() {
	$('#save_btn').click(function() {
		window.location = $('#save a').attr('href');
	});
}

$(document).ready(function() {
	addSave();
});