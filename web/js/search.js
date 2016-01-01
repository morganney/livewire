function liveSearchHandler() {
	$('#search input[type=text]').keyup(function() {
		var form = $(this).parent().parent().get(0);
		var serp = $('#part_serp').get(0);
		//alert($(form).serialize()); return false;
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
        if(data) $(serp).show().html(data);
        else $(serp).hide();
      }, // end success callback
      error:		function(xhr, status, error_thrown) {
    	$(serp).html("<div id='tech_prob'>Sorry, there has been an error: " + error_thrown + "</div>");
      }// end error callback
    });// end ajax
		return false;
	});
	$('#search input[type=text]').attr('autocomplete','off').click(function(){$('#part_serp').hide();});
}



$(document).ready(function() {
	liveSearchHandler();
});