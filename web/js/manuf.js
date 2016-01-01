function preloadCycleImages(imgArray) {
  // Attempt to remove the flicker from image swapping on manuf-level pages due to css positioning
  $(imgArray).each(function(idx) {
    $('<img />')[0].src = this;
  });
}

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
    /*
    var newImg = document.createElement('img');
    newImg.setAttribute('src', src);
    newImg.setAttribute('id', 'cycle_img');
    $(newImg).removeClass('_' + n).addClass('_' + i);
    */
    $('#cycle_img').attr('src', src).removeClass('_' + n).addClass('_' + i);
  }
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

$(document).ready(function() {
  if($.browser.msie && $.browser.version.substr(0,1) < 7) {
    // do nothing
  } else {
	  setInterval(cycleImg, 3000); 
  }
  searchToggleText();
  bindCartHandler();
  afterHours();
});// end DOM ready handler