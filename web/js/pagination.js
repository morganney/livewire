function bindCartHandler() {
  $('a.add').click(function() {
	// id format = [_(part_no)_(grn|new)_(ns_id)]
    var parts = $(this).attr('id').split('_');
    var qty_selector = '#_' + parts[1] + '_' + parts[2] + '_qty';
    var ns_id = parts[3];
    var qty = $.trim($(qty_selector).val());
	if(qty != 'QTY' && qty != ' ' && qty != '' && qty != '0' && parseInt(qty) > 0) {
	  $('#add').val(qty);
	  $('#buyid').val(ns_id);
	  $('#add_to_cart').submit();
	} else alert('Please enter a positive integer.');
    return false;
  });// end click handler
}

$(document).ready(function() {
	$('input.txt').click(function(){$(this).val('');});
	bindCartHandler();
});// end DOM ready handler