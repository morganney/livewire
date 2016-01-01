function addQuickSearch() {
	$('#cust_cell, #tick_cell').keyup(function() {
	var serps_id = '#' + this.id.split('_')[0] + '_serps';
	if(this.value.length < 2)  {
		$(serps_id).html('').hide();
		return false;
	}
	var form = $(this).parent().parent('form').get(0);
    $.ajax({
      url: 			$(form).attr('action'),
      type: 		'GET',
      data: 		$(form).serialize(),
      cache:		false, // requests aren't cached by users browser
      dataType:		'html',
      beforeSend:	function() {
    		// { blank }
      },// end beforeSend Handler
      success:		function(data, status, xhr) {
        if(data) $(serps_id).show().html(data);
        else $(serps_id).hide();
      }, // end success callback
      error:		function(xhr, status, error_thrown) {
    	$(serps_id).html("<div id='tech_prob'>Sorry, there has been an error: " + error_thrown + "</div>");
      }// end error callback
    });// end ajax
	});
	$('#cust_cell, #tick_cell').attr('autocomplete','off').click(function(){$('.serps').hide();});
}

function addClickableSerp() {
	$('.qx_serp').click(function() {
		window.location = $(this).find('a:first-child').attr('href');
		return false;
	});
}

$(document).ready(function() {
	
	$('.serps').hide();
	addQuickSearch();
	$(this).bind('ajaxComplete', addClickableSerp);
});