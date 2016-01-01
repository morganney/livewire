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
      }, // end success callback
      error:		function(xhr, status, error_thrown) {
    	$('#step_box').css({'background-image' : 'url()'}).html("<p id='tech_prob'>Sorry, there has been an error: " + error_thrown + "</p>");
      }// end error callback
    });// end ajax
    return false;
  });// end click handler
}

function addTooltipHover() {
  $('#tooltip, #csr').hover(
    function() {
      var position = $(this).position();
      if($(this)[0].tagName == 'P') {
        var left = position.left;
        var top = $(this).hasClass('kva') ? position.top - $('#tip').innerHeight() - 10 : position.top  + 65;
      } else {
        var left = position.left + 40;
        var top = position.top;
      }
	  $('#tip').css({'top': top + 'px', 'left': left + 'px'}).removeClass('invisible');
	},
	function() {
	  $('#tip').addClass('invisible');
	}
  );// end hover handler
}

function fixAjaxBackBtn() {
  $('p#ajax_back').css('left', $('#step h2').width() + 45);
}

function KvaCalc(phase, volts, amps, kva) {
	// validate values first
	if(parseInt(volts) && parseInt(amps) && parseInt(kva)) {
		// if all 3 fields have a value, then tell them to remove one
		// parseInt() so the default value of '0' will be interpreted as false
		alert('Two values must be filled in, and the other value left blank.');
	} else {
		// valid values so compute
		volts = parseFloat(volts);
		amps = parseFloat(amps);
		kva = parseFloat(kva);
		if(parseInt(phase) == 1) {
			//alert('phase 1');
			if(!kva) {
				//alert('find kva');
				kva = (volts * amps) / 1000;
				$('#k').val(kva);
			} else if(!amps) {
				//alert('find amps');
				amps = (kva * 1000) / volts;
				$('#a').val(amps);
			} else {
				//alert('find volts');
				volts = (kva * 1000) / amps;
				$('#v').val(volts);
			}
		} else {
			//alert('phase 3');
			if(!kva) {
				//alert('find kva');
				kva = (volts * amps * 1.73) / 1000;
				$('#k').val(kva);
			} else if(!amps) {
				//alert('find amps');
				amps = (kva * 1000) / (volts * 1.73);
				$('#a').val(amps);
			} else {
				//alert('find volts');
				volts = (kva * 1000) / (amps * 1.73);
				$('#v').val(volts);
			}
		}
	}
}

function addKvaCalc() {
	$('a#kva_calc_btn').click(function() {
		$('#kva_calc').toggleClass('invisible');
		return false;
	});
	$('p#kva_close a').click(function() {
		$('#kva_calc').addClass('invisible');
		return false;
	});
	$('#compute').click(function() {
		KvaCalc(
			$(':radio[name=phase]:checked').val(),
			$('#v').val(),
			$('#a').val(),
			$('#k').val()
		);
		return false;
	});
}

$(document).ready(function() {
  // bind ajax on first step
  addAjax();
  // bind ajax on each subsequent step
  $(this).bind('ajaxComplete', addAjax);
  // bind tooltip hover
  addTooltipHover();
  $(this).bind('ajaxComplete', addTooltipHover);
  // reposition the ajax back button as necessary
  $(this).bind('ajaxComplete', fixAjaxBackBtn);
  addKvaCalc();
});
