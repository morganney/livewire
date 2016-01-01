function formIsValid() {
	window.form_errs = [];
	var email_pattern = /^[^@]+@[^@]+\.[^@]+$/;
	var digit_pattern = /[:digit:]/;
	var company = $.trim($('#company').val());
	
	if(!company) window.form_errs.push('"Company" is required.');
	if(company && company.toUpperCase() == company) window.form_errs.push('"Company" must not be all uppercase.');
	
	if(window.form_errs.length) return false;
	else return true;
}
function saveCustomerHandler() {
	$('#save_cust').click(function() {
		if(formIsValid()) {
			
			$('form#new_cust').submit();
		} else {
			var err_msg = 'Error(s): \n\n';
			for(var i in window.form_errs) {
				var j = 1 + parseInt(i);
				err_msg += j + '. ' + window.form_errs[i] + '\n';
			}
			alert(err_msg);
		}
		return false;
	});
}

$(document).ready(function() {
	saveCustomerHandler();
});
