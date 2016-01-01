$(document).ready(function() {
	$('input.rdo').click(function() {
		var id = $(this).val();
		switch(id) {
			case 'phone' : $('#toggle').html('Contact Number <span>*</span>');
				break;
			case 'email' : $('#toggle').html('Email Address <span>*</span>');
				break;
			case 'fax'	 : $('#toggle').html('Fax Number <span>*</span>');
				break;
			default: break;
		}
		$('#xtr_bottom input.txt').addClass('invisible');
		$('#xtr_bottom #' + id).removeClass('invisible');
	});
	$('#xtr_bottom input.txt').addClass('invisible');
	$('#' + $('input.rdo:checked').val()).removeClass('invisible');
});