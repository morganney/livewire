$(document).ready(function () {
	$('input.txt').val('QTY').click(function() {
	  $(this).val('');
	});// end click handler
	$('.btn a').click(function() {
	  // id format = [_(part_no)_(ns_id)]
	  var parts = $(this).attr('id').split('_');
	  var part_no = parts[1];
	  // not all parts are setup properly inside netsuite, so this may be empty
	  var ns_id = parts[2];
	  var selector = '#_' + part_no + '_qty';
	  var qty = $.trim($(selector).val());
	  var cart_qty;
	  if(qty != 'QTY' && qty != ' ' && qty != '' && qty != '0' && parseInt(qty) > 0) {
	    cart_qty = qty;
	  } else cart_qty = 1;
	  $('#add').val(cart_qty);
	  $('#buyid').val(ns_id);
	  $('#add_to_cart').submit();
	  return false;
	});// end click handler
	
});// end DOM ready handler