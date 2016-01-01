// global variable used to count repeated attempts to query UPS for pricing
// I used this because for some reason the requests would return a null json object
// After repeated requests it will go through ok
var ups_request_counter = 0;

function stockAnimation() {
  var ts_css = $('.complete em, .grn em, .new em').css('textShadow');
  if (ts_css == 'none') {
    $('.store_front em').css({'textShadow': '-5px -5px 1px #f7b61a'});  
  } else {
	  $('.store_front em').css({'textShadow': 'none'});
  }  
}

function bindTxtClearingHandler() {
  $('#main input.txt')
  .filter(function() {return $(this).parent().parent().attr('id') != 'friend_form';})
  .click(function() {$(this).val('');});
}

function UPSCalc() {
  $('form#ups_calc').submit(function() {
    $(this).css({'background-image' : 'url(/images/ups-ajax-loader.gif)'});
    $.getJSON(
      $(this).attr('action'),
      {cat_id: $('input#cat_id').val(), zip: $('input#zip').val(), ship_qty: $('input#ship_qty').val(), weight: $('input#weight').val()},
      function(json, status, xhr) {
    	$('form#ups_calc').css({'background-image' : 'url()'});
        if(status != 'success') {
          alert('status=' + status);
        } else {
          if(json != null) {
  		    $.each(json, function() {
  	          $.each(this, function(ups_service_code, rate) {
  	            rate = parseFloat(rate).toFixed(2);
  	            if(isNaN(rate)) {// UPS doesn't offer this service/destination pair
  	              $('td#_' + ups_service_code).text('N/A');
  	            } else $('td#_' + ups_service_code).text('$' + rate);
  	          });
  	        });
          } else {
        	  alert('json is null');
        	  /*$.each(xhr, function(idx, n){
        		  alert(idx+'='+n);
        	  });*/
          }
        }
      }
    );
    return false;
  });
}

function bindUPSCalculator() {
$('form#ups_calc').submit(function() {
  // used to reset costs for any services that aren't available on repeated requests
  var ups_service_codes = ['03','12','02','13','14'];
  if(!$('input#ship_qty').val() || $('input#ship_qty').val() == 'QTY' || isNaN($('input#ship_qty').val()) || parseInt($('input#ship_qty').val()) <= 0) {
    alert('QTY is required as a positive number.');
  } else if(!$('input#zip').val() || $('input#zip').val() == 'ZIP' || isNaN($('input#zip').val())) {
    alert('A valid ZIP is required.');
  } else {
  $(this).css({'background-image' : 'url(/images/ups-ajax-loader.gif)'});
  $.getJSON(
    // URL
    $(this).attr('action'),
    // parameters
	{cat_id: $('input#cat_id').val(), zip: $('input#zip').val(), ship_qty: $('input#ship_qty').val(), weight: $('input#weight').val()},
	// callback
	function(json, status) {
	  $('form#ups_calc').css({'background-image' : 'url()'});
	  if(status == 'success') {
	    if(json != null) {
	      if(json.ups_error) {
	    	// reset service values to zero
	    	var len_j = ups_service_codes.length;
	    	for(var j = 0; j < len_j; j++) $('td#_' + ups_service_codes[j]).text('N/A');
	    	// display error message
	        alert(json.ups_error);
	      } else {
		    $.each(json, function() {
	          $.each(this, function(ups_service_code, rate) {
	            rate = parseFloat(rate).toFixed(2);
	            if(isNaN(rate)) {// UPS doesn't offer this service/destination pair
	              $('td#_' + ups_service_code).text('N/A');
	            } else $('td#_' + ups_service_code).text('$' + rate);
	            // remove last used ups service code
	            ups_service_codes = $.grep(ups_service_codes, function(val) { return val != ups_service_code; });
	          });
	        });
		    
		    // check for free ground shipping
		    var ship_qty = $('input#ship_qty').val();
		    var cost = parseFloat($('#fsp').text().replace('$','').replace(',','') * ship_qty).toFixed(2);
		    if(cost >= 250) $('td#_03').text('FREE!');
		  
		    // set any unavailable service costs to N/A
		    var len_i = ups_service_codes.length;
		    for(var i = 0; i < len_i; i++) $('td#_' + ups_service_codes[i]).text('N/A');
		    ups_request_counter = 0;
	      }
		} else {
			// json is null !!?? not sure why it would be null with status=success  
			if(ups_request_counter < 15) { 
			  // just make the request again
			  $('form#ups_calc').trigger('submit'); // IE is not playing nicely 12/9/2010
			  //$('form#ups_calc').submit();
			  ups_request_counter++;
			} else {
				$('input#ship_qty').val('QTY');
				$('input#zip').val('ZIP');
				var len_k = ups_service_codes.length;
				for(var k = 0; k < len_k; k++) $('td#_' + ups_service_codes[k]).text('N/A');
			    alert('Sorry there was an error. Please refill the QTY and ZIP values and try again.');
			    ups_request_counter = 0;
			}
		  }
	  } else {
		  alert('Sorry, our shipping calculator is currently down.  Please contact our webmaster webmaster@livewiresupply.com.');
	  }
	}// end callback
  );// end getJSON()
  }
  return false;
});// end submit handler

}

function bindCartHandler() {
$('#pricing div p a').click(function() {
  // id format = [_(ns_id)_(new|grn)]
  var pieces = $(this).attr('id').split('_');
  var ns_id = parseInt(pieces[1]);
  var selector = '#' + pieces[2] + '_qty';
  var qty = $.trim($(selector).val());
  var cart_qty;
  if(qty != 'QTY' && qty != ' ' && qty != '' && qty != '0' && parseInt(qty) > 0) {
	cart_qty = qty;
  } else {
	cart_qty = 1;
  }
  $('#add').val(cart_qty);
  $('#buyid').val(ns_id);
  $('#add_to_cart').submit();
  return false;
});
}

function addPricingInfo() {
  if($('#new').length) {
	var info = $("<div class='invisible tip' id='info_price'><p class='top'>Yes, this item is NEW.</p><p>Most Distributors are locked in at a set price based on regional-price restrictions set by manufactures. LiveWire Supply is a National Supplier with customers from San Francisco, CA to Syracuse, NY so we are allowed to set our own prices. We buy new product in bulk and are able to negotiate pricing significantly lower than most other companies. In fact, some of our inventory comes right from our customers. Click Sell to LiveWire if you have bulk inventory.</p></div>");
    $('#new ul li:first-child strong')
    .append("<img class='tip' id='price_info' src='/images/help-sm.png' alt='Discounted Pricing Information' />")
    .parent()
    .append(info);
    // IE has terrible z-index implementation.  Any value less than 1 would not allow the tip to appear correctly.  Standard convention out there is to give the nearest positioned parent a HIGHER z-index to fix this bug.
    if ($.browser.msie && $.browser.version.substr(0,1)<8) $('#new ul li:first-child').css('z-index', '4');
  }
  if($('#grn').length) {
	var info = $("<div class='invisible tip' id='info_green'><div><p class='top'>These days it seems everyone is going green and LiveWire is no exception. You should go green with us. For starters, we will proudly contribute 3% of the proceeds from this sale to benefit the <strong>Environmental Defense Fund</strong>.</p><p>This product has been Certified Green because it may have previously been in service. Most of our Certified Green Breakers were removed from service by professional electricians and require no reconditioning. They are tested and cleaned to look and function good as new. In fact, they carry the <strong>same 1-year warranty as our new breakers</strong>. When possible, LiveWire will ship this breaker from a regional warehouse close to you to cut down on total emissions associated with shipping. Basically, we hope you buy this green breaker to cut down on the waste associated with the production of new equipment that does the same thing.</p></div></div>");
	$('#grn ul li:first-child strong')
	.append("<img class='tip' id='green_info' src='/images/help-sm.png' alt='Certified Green Information' />")
	.parent()
	.append(info);
	if ($.browser.msie && $.browser.version.substr(0,1)<8) $('#grn ul li:first-child').css('z-index', '4');
  }
  
  /*
  $('img.tip').click(function() {
	  var id = $(this).attr('id').split('_')[0];
      var position = $(this).position();
      var left = position.left + 25;
      $('#info_' + id).css({'top': '0px', 'left': left + 'px'}).toggleClass('invisible');
  });
  */
  
  $('img.tip').hover(
    function() {
      var position = $(this).position();
      var left = position.left + 25;
      var id = $(this).attr('id').split('_')[0];
      $('#info_' + id).css({'top': '0px', 'left': left + 'px'}).toggleClass('invisible');
    },
    function() {
      var id = $(this).attr('id').split('_')[0];
      $('#info_' + id).toggleClass('invisible');
    }
   );
 
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
      } else { 
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

function emptyShipAnimation() {
  var el_css = $('span#empty_ship_msg').css('background-image');
  if(el_css != 'none') {
    $('span#empty_ship_msg').css('background-image','none');
  } else {
	$('span#empty_ship_msg').css('background-image', 'url(/images/grn-plus-icon.png)');
  }
}

function addShipAvailabilityText() {
  var markup;
  var animationFunc = emptyShipAnimation;
  var store_front = $('.store_front').get(0);
  if($(store_front).hasClass('empty')) {
	  markup = "<span id='empty_ship_msg'>Item might be available to ship today</span>";
  } else {
	  markup = "<span id='ship_msg'>Item can still ship today</span>";
	  animationFunc = function() {$('span#ship_msg').toggleClass('invisible');};
  }
  $('div#shopping h2')
  .append(markup);
  setInterval(animationFunc, 1000);
}

function addTellFriend() {
  $('#social a').click(function() {
	var form = $('form#friend_form')[0];
	if($(form).is(':hidden')) $(form).slideDown();
	else $(form).slideUp();
    return false;
  });
  
  $('form#friend_form').submit(function() {
	// validation
	var req_fields = $('form#friend_form input:text');
	var num_req_fields = req_fields.length;
	var complete = true;
	for(var i = 0; i < num_req_fields; i++) {
	  if(!$.trim($(req_fields[i]).val())) complete = false;
	}
	if(complete) {
	  var email_pattern = /^[^@]+@[^@]+\.[^@]+$/; // /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/
	  if(!email_pattern.test($.trim($(req_fields[1]).val()))) {
	    alert("Your friend's email address is invalid.");
	  } else if(!email_pattern.test($.trim($(req_fields[3]).val()))) {
		alert('Your email address is invalid.');
	  } else {
		// Ajax
		var form = this; // used by Ajax callback functions
		$.ajax({
		  url:			$(this).attr('action'),
		  method:		'GET',
		  data:			$(this).serialize(),
		  cache:		false,
		  dataType:		'html',
		  beforeSend:	function() {
			$('#loader')
			.css({
			  'height' : $('#tf_wrap').height() + 'px',
			  'top'	: '0px',
			  'background-image' : 'url(/images/ajax-loader.gif)'
			}).removeClass('invisible');
		  },// end beforeSend()
		  success:		function(data, status, xhr) {
			$('#loader').css({'background-image' : 'url()'}).addClass('invisible');
			alert(data);
			$('input#f_name').val('');
			$('input#f_email').val('');
			$(form).slideUp();
		  },// end success()
		  error:		function(xhr, status, error_thrown) {
			$('#loader').css({'background-image' : 'url()'}).addClass('invisible');
			alert('Sorry there has been an error: ' + error_thrown);
			$('input#f_name').val('');
			$('input#f_email').val('');
			$(form).slideUp();
		  }// end error()
		})// end $.ajax 
	  }
	} else {
      alert('All fields are required.');
	}
	// do not submit the form
    return false;
  });
}

$(document).ready(function() {
  // add pricing info tooltips
  addPricingInfo();
  // Text clearing
  bindTxtClearingHandler();
  // UPS calculator
  bindUPSCalculator();
  //UPSCalc();
  // add-to-cart functionality for buttons
  bindCartHandler();
  // add stock text effect
  setInterval(stockAnimation, 300);
  // add Tell a Friend
  addTellFriend();
  // add outside of normal business hours logic
  afterHours();
  //if($.browser.msie) $('#ship_calc > div').remove();
});
