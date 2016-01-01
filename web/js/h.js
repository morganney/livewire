
function afterHours() {
  // If cookie is not set by user, then show them after hours info
  if(document.cookie.length && (document.cookie.indexOf('remove_after_hours') == -1)) {
    $('#after_hours').css('border-bottom','3px solid #a8a8a8');
    $('#after_hours div').delay('1500').slideDown();
    $("<a href='#'></a>").attr('id','toggle_btn').appendTo('#after_hours').click(function() {
	  var info = $('#after_hours div')[0];
      if($(info).is(':hidden')) {
        $(this).removeClass('down');
        $(info).slideDown();
      }
      else { 
        $(this).addClass('down');
        
        $(info).slideUp(); 
      }
    });
  }
  // Set cookie if user doesn't want to see the info for current browser session
  $('#remove a').click(function() {
    document.cookie = 'remove_after_hours=true; path=/';
    $('#after_hours').remove();
  });
}

$(document).ready(function() {
	// Task A: Slide-show
	// Available options @ http://jquery.malsup.com/cycle/options.html
	$('#slides li').hide();
	$('#h1_home').appendTo('#slide_0 div.slide_text');
	/*$('div.slide_text').css('cursor', 'pointer').click(function(){
		window.location = $(this + ' a').attr('href');
	});*/
	$('#slide_0').fadeIn(1000, function() {
		$('#slides').cycle({
			fx: 'fade',
			speed: 1000,
			timeout: 6000,
			pause: 1,
			// 'this' refers to the element that is being TRANSITIONED IN
			before: function() {
			  $('#h1_home').appendTo('#' + this.id + ' div.slide_text');
			  var href = $('#' + this.id + ' .slide_text a').attr('href');
			  $('#' + this.id + ' .slide_text').css('cursor', 'pointer').click(function() {
			     window.location = href;
			  });
			}
		});
	});


	// Task B: stock search form
	var search_entry_txt = 'ENTER PART OR CATALOG NUMBER';
	$('#stock_search input.txt')
	.val(search_entry_txt)
	.click(function() {
		$(this).val('');
	});


	// Task C: rotate lower left slides randomly
	$('#s_0').addClass('invisible');
	var r = Math.floor(Math.random() * 4);
	$('#s_' + r).removeClass('invisible');
	
	// Task D: make news and customer slides linkable
	$('div.slide:has(a)').click(function() {
		window.location = $('#' + this.id + ' a').attr('href');
	})
	.css('cursor', 'pointer');
	
	// Task D: after hours
	afterHours();
});