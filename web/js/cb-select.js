function addAjax() {
  $('a.ajax').click(function() {
    var query_string = $(this).attr('href').split('?')[1];
    $.ajax({
      url: 			$(this).attr('href'),
      type: 		'GET',
      data: 		query_string,
      cache:		false, // requests aren't cached by users browser
      dataType:		'html',
      beforeSend:	function() {
        $('#step_box').html('').css({'background-image' : 'url(/images/ajax-loader.gif)'});
      },// end beforeSend Handler
      success:		function(data, status, xhr) {
        $('#step_box').css({'background-image' : 'url()'}).html(data);
        $('#step_focus').focus();
      }, // end success callback
      error:		function(xhr, status, error_thrown) {
    	$('#step_box').css({'background-image' : 'url()'}).html("<p id='tech_prob'>Sorry, there has been an error: " + xhr.status + "</p>");
      }// end error callback
    });// end ajax
    return false;
  });// end click handler
};

function cycleImg() {
  // URL structure '/images/cycle/[cat_slug]/[manuf_slug]/cycle-{i}-trans.png'
  var num_imgs = parseInt($('#manuf_box').attr('class').split('_')[1]);
  if(num_imgs > 0) {
    var pieces = $('#cycle_img').attr('src').split('/');
    var cat_slug = pieces[3];
    var manuf_slug = pieces[4];
    var n = parseInt(pieces[5].split('-')[1]);
    var i = (n + 1) % num_imgs;
    var src = '/images/cycle/' + cat_slug + '/' + manuf_slug + '/cycle-' + i + '-trans.png';
    $('#cycle_img').attr('src', src).removeClass('_' + n).addClass('_' + i);
  }
}

function cycleResultSets() {
  $('#results')
  .before("<div id='results_nav'>")
  .cycle({
	fx:				'turnDown',
	speed:			'fast',
	timeout:			0,
	pager:			'#results_nav',
	activePagerClass:	'active_set',
	pagerAnchorBuilder: function(idx, listElement) {
	  var start = idx * 30 + 1;
	  var end = idx * 30 + $(listElement).find('td').size();
      var text = start + ' - ' + end;
	  return "<a href='#'>" + text + '</a>';
	}
  });// end cycle()
}

function searchToggleText() {
  $('#manuf_search input.txt').val('Enter Part or Catalog Number')
  .click(function() {
    $(this).val('');
  });
}

function bindCartHandler() {
  $('.item_box a.btn').click(function() {
	// id format = [_(ns_id)]
	var ns_id = $(this).attr('id').split('_')[1];
	$('#add').val('1');
	$('#buyid').val(ns_id);
	$('#add_to_cart').submit();
	return false;
  });
}

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
    document.cookie = 'remove_after_hours=true;';
    $('#after_hours').remove();
  });
}

$(document).ready(function() {
  // bind ajax handler for CB tool
  addAjax();
  // bind ajax handler to elements on each subsequent CB tool step
  $(this).bind('ajaxComplete', addAjax);
  // bind cycle behavior to result set after each CB tool step
  $(this).bind('ajaxComplete', cycleResultSets);
  // cycle selected manufacturer images every 3 seconds
  if($.browser.msie && $.browser.version.substr(0,1) < 7) {
    // do nothing
   } else {
	   setInterval(cycleImg, 3000); 
  }
  searchToggleText();
  bindCartHandler();
  afterHours();
});