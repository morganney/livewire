$(document).ready(function() {
  $('h2#select').css('cursor', 'pointer').click(function() {
    window.location = $('#tr_selection a').attr('href');
  });
  $('h2#srch').css('cursor', 'pointer').click(function() {
	  $('#tr_search input.txt').val('').focus();
  });
});

