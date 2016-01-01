function updatePasswordHandler() {
	$('#upw_btn').click(function() {
		$('form#upw p.user_msg').remove();
		var cpw = $.trim($('input[name=cpw]').val());
		var npw = $.trim($('input[name=npw]').val());
		var pwc = $.trim($('input[name=pwc]').val());
		if(!cpw) alert('You must provide your current password.');
		else if(npw != pwc) alert('The passwords do not match.');
		else if(npw.length < 5) alert('The new password is too short!\nPasswords require at least 5 alphanumeric characters.');
		else {
			var form = $('form#upw').get(0);
			var ajax_loader = $('form#upw p.low').get(0);
	    $.ajax({
	      url: 			$(form).attr('action'),
	      type: 		'POST',
	      data: 		$(form).serialize(),
	      cache:		false, // requests aren't cached by users browser
	      dataType:		'html',
	      beforeSend:	function() {
	        $(ajax_loader).css({'background-image' : 'url(/images/be/ajax-spinner.gif)'});
	      },// end beforeSend Handler
	      success:		function(data, status, xhr) {
	        $(ajax_loader).css({'background-image' : 'url()'});
	        $(':password').val('');
	        $("<p class='user_msg'></p>").prependTo(form).html(data);
	      }, // end success callback
	      error:		function(xhr, status, error_thrown) {
	    	$(ajax_loader).css({'background-image' : 'url()'});
	    	$("<p class='user_msg'></p>").prependTo(form).html("<div id='tech_prob'>Sorry, there has been an error: " + error_thrown + "</div>");
	      }// end error callback
	    });// end ajax
		}
		return false;
	});
}

$(document).ready(function() {
	updatePasswordHandler();
});