
// ADD SOMETHING TO MAKE SURE THAT THEY CANNOT SEND A QUOTE TEMPLATE NOTE IF THERE ARE NO NEW RQ ROWS OR NO U:RQ ROWS HAVE BEEN ACTIVATED

function addRqxHandler() {
	$('#add_rqx').click(function() {
		window.rqx_cnt++;
		$('#rqx_clone tr').clone(true).appendTo('#rqx_rows');
		if($('#sub_rqx').is(':hidden')) $('#sub_rqx').show();
		return false;
	});
}

function subRqxHandler() {
	$('#sub_rqx').click(function() {
		window.rqx_cnt--;
		$('#rqx_rows tr:last-child').remove(); // remove notes
		$('#rqx_rows tr:last-child').remove(); // remove rqx details
		if(window.rqx_cnt <= 0) $(this).hide();
		return false;
	});
}

function addVmxHandler() {
	$('#add_vmx').click(function() {
		window.vmx_cnt++;
		$('#vmx_clone tr').clone().appendTo('#vmx_rows');
		if($('#sub_vmx').is(':hidden')) $('#sub_vmx').show();
		return false;
	});
}

function subVmxHandler() {
	$('#sub_vmx').click(function() {
		window.vmx_cnt--;
		$('#vmx_rows tr:last-child').remove(); // remove notes
		$('#vmx_rows tr:last-child').remove(); // remove vendor details
		if(window.vmx_cnt <= 0) $(this).hide();
		return false;
	});
}

function noteTypeHandler() {
	$('#note_type').change(function() {
		if($(this).val() == 'external') {
			$('.int').hide();
			$('.ext').show();
			if($('#note_template').val() == 'None') $('#paper').show();
		} else if($(this).val() == 'internal') {
			$('.ext').hide();
			$('.int, #paper').show();
		} else {
			$('#notepad tr').not(':first-child').hide();
		}
	});
}

function rfqEditHandler() {
	$('.rqx_edit a').click(function() {
		var key = $(this).attr('class').replace('_','');
		var data_row = $(this).parent().parent('tr').get(0);
		$(data_row).find('input[type=text], :disabled, textarea')
		.removeAttr('disabled').removeAttr('readonly').removeClass('disabled').addClass('border');
		$(data_row).next('tr').find('textarea').removeAttr('readonly').removeClass('disabled').addClass('border');
		var rqx_keys = $('input[name=rqx_keys]').get(0);
		if(!$(rqx_keys).val()) $(rqx_keys).val(key);
		else $(rqx_keys).val($(rqx_keys).val() + '_' + key);
		$(this).parent().addClass('clicked').end().remove();
		window.rqx_under_edit = true;
		return false;
	});
	$('.vmx_edit a').click(function() {
		var key = $(this).attr('class').replace('_','');
		var data_row = $(this).parent().parent('tr').get(0);
		$(data_row).find('input[type=text], :disabled')
		.removeAttr('disabled').removeAttr('readonly').removeClass('disabled').addClass('border');
		$(data_row).next('tr').find('textarea').removeAttr('readonly').removeClass('disabled').addClass('border');
		var vmx_keys = $('input[name=vmx_keys]').get(0);
		if(!$(vmx_keys).val()) $(vmx_keys).val(key);
		else $(vmx_keys).val($(vmx_keys).val() + '_' + key);
		$(this).parent().addClass('clicked').end().remove();
		window.vmx_under_edit = true;
		return false;
	});
	$('.rfq_edit a').click(function() {
		$(this).parent().parent('tr').find(':disabled').removeAttr('disabled').removeClass('disabled');
		$('input[name=rfq_update]').val('1');
		$(this).parent().addClass('clicked').end().remove();
		return false;
	});
}

function rfqFormIsValid() {
	window.rfq_errs = [];

	$('.module input[name="part_no[]"]').add('input[name="u:part_no[]"]').each(function(idx) {
		if(!$.trim($(this).val())) {
			window.rfq_errs.push('Catalog No. is required for all Request & Quote rows.');
			return false;
		}
	});
	
	var part_no_sum = window.rqx_cnt + $('.module input[name="u:part_no[]"]').size();
	var part_nos = $('input[name="part_no[]"]').add('input[name="u:part_no[]"]');
	$(part_nos).each(function(i) {
		var i_val = $(this).val();
		for(var j = i + 1; j < part_no_sum; j++) {
			var next = $(part_nos).get(j);
			if(next.value == i_val) {
				window.rfq_errs.push('Catalog No. must be unique for all Request & Quote rows.');
				return false;
			}
		}
	});
	
	$('.module input[name="qty_req[]"]').add('.module input[name="u:qty_req[]"]').each(function(idx) {
		if(!$.trim($(this).val()) || isNaN(parseInt($(this).val()))) {
			window.rfq_errs.push('QTY is required for all Request & Quote rows.');
			return false;
		}
	});
	
	$('input[name="quoted_new[]"]').add('input[name="u:quoted_new[]"]').each(function(idx) {
		if($(this).val() && isNaN(parseFloat(this.value.replace('$','').replace(',','')))) {
			window.rfq_errs.push('New Quote values must be a dollar amount.');
			return false;
		}
	});
	
	$('input[name="quoted_grn[]"]').add('input[name="u:quoted_grn[]"]').each(function(idx) {
		if($(this).val() && isNaN(parseFloat(this.value.replace('$','').replace(',','')))) {
			window.rfq_errs.push('Used Quote values must be a dollar amount.');
			return false;
		}
	});
	
	// Catalog No. and Purchase Price are required for all vmx rows, new or edited
	$('input[name="u:vpart_no[]"]').add('.module input[name="vpart_no[]"]').each(function(idx) {
		if(!$.trim($(this).val())) {
			window.rfq_errs.push('Catalog No. is required for all Purchasing Rows.');
			return false;
		}
	});
	$('input[name="u:purchase_price[]"]').add('.module input[name="purchase_price[]"]').each(function(idx) {
		if(isNaN(parseFloat($(this).val().replace('$','').replace(',','')))) {
			window.rfq_errs.push('Price must be a dollar amount for all Purchasing rows.');
			return false;
		}
	});
	
	var note_type = $('#note_type').val();
	if(note_type == 'external') {
		if(!$.trim($('#subj').val())) window.rfq_errs.push('Subject is required for external notes.');
		var email_pattern = /^[^@]+@[^@]+\.[^@]+$/;
		if(!email_pattern.test($.trim($('#to').val()))) window.rfq_errs.push('\'To\' is an invalid email address.');
		if($('#cc').val()) {
			var email = $('#cc').val().split(',');
			for(var i in email) {
				if(!email_pattern.test($.trim(email[i]))) {
					window.rfq_errs.push('\'Cc\' has an invalid email address.');
					break;
				}
			}
		}
		if($('#note_template').val() == 'Quote') {
			// check that at least one quoted price is available for each R&Q row (of newly added ones only, not checking already added rows)
			$('.rq input[name="part_no[]"]').each(function(i) {
				var new_price = $(this).parent().parent().find('input[name="quoted_new[]"]').get(0);
				var grn_price = $(this).parent().parent().find('input[name="quoted_grn[]"]').get(0);
				if(!$(new_price).val() && !$(grn_price).val()) {
					window.rfq_errs.push('The Quote template requires at least one quoted price for each Request & Quote row.');
					return false;
				}
			});
		}
	}
	if((note_type == 'internal' || $('#note_template').val() == 'None') && !$.trim($('#rfq_note').val())) window.rfq_errs.push('Note is empty, there is no message.');

	if(window.rfq_errs.length) return false;
	else return true;
}

function updateButtonHandlers() {
	$('#update, #update_close').click(function() {
		// add some client side validation here
		if(rfqFormIsValid()) {
			$(this).attr('id') == 'update' ? $('input[name=close]').val('0') : $('input[name=close]').val('1');
			$('#sent_to').val($('#to').val());
			// important to preserve db_keys/form_rows association on backend
			$('select').removeAttr('disabled');
			$('form#rfq_ticket').submit();
		} else {
			var err_msg = 'Error(s): \n\n';
			for(var i in window.rfq_errs) {
				var j = 1 + parseInt(i);
				err_msg += j + '. ' + window.rfq_errs[i] + '\n';
			}
			alert(err_msg);
		}
		return false;
	});
}

function priceLookupHandler() {
$('input.ns').blur(function() {
	var part_bx = this;
	var part_no = $.trim($(part_bx).val());
	if(part_no.length >= 2) {// part number 'BA' exists
		// clean this up using window.location.pathname.split('/') & window.location.host
		var endpoint = window.location.href.indexOf('_dev') > -1 ? '/backend_dev.php/ns-price' : '/backend.php/ns-price';
		var qs = 'part_no=' + encodeURIComponent($(part_bx).val());
		var parent_tr = $(part_bx).parent().parent();
		var new_price_bx = $(parent_tr).find('input[name="u:quoted_new[]"],input[name="quoted_new[]"]').css({'background-image' : 'url(/images/be/price-loader.gif)'}).get(0);
		var grn_price_bx = $(parent_tr).find('input[name="u:quoted_grn[]"],input[name="quoted_grn[]"]').css({'background-image' : 'url(/images/be/price-loader.gif)'}).get(0);
		var mfr_bx = $(parent_tr).find('select[name="u:mfr[]"],select[name="mfr[]"]').get(0);
		var cat_bx = $(parent_tr).find('select[name="u:category[]"],select[name="category[]"]').get(0);
		$.getJSON(endpoint,qs,
			function(json, status) {
				if(status == 'success' && json != null) {
					$(cat_bx).val(json.category);
					$(mfr_bx).val(json.manuf);
					$(parent_tr).find('input[name="u:qty_req[]"],input[name="qty_req[]"]').val('1');
					$(new_price_bx).css({'background-image' : 'url()'}).val('').val(json.new_price);
					$(grn_price_bx).css({'background-image' : 'url()'}).val('').val(json.grn_price);
					$(parent_tr).find('input[name="display[]"], input[name="u:display[]"]').val(json.display);
				} else if (status != 'success'){
					alert('NetSuite price lookup is not working, contact administrator.');
					$(new_price_bx).css({'background-image' : 'url()'});
					$(grn_price_bx).css({'background-image' : 'url()'});
				} else {
					// Maybe a part was entered that doesn't exist in our DB, or DB error.
					$(parent_tr).find('input[name="qty_req[]"], input[name="u:qty_req[]"]').val('1');
					$(new_price_bx).css({'background-image' : 'url()'}).val('');
					$(grn_price_bx).css({'background-image' : 'url()'}).val('');
					$(parent_tr).find('input[name="display[]"], input[name="u:display[]"]').val(0);
				}
			}
		);// end getJSON()
	}
	// only fill in vmx rows for newly added rqx rows
	//alert($(part_bx).attr('name'));
	if($(part_bx).attr('name').indexOf('u:') == -1) {
		// add a vmx row and populate the vpart_no field with the part number from the R&Q row
		$('#add_vmx').click();
		$('#vmx_rows').find('input[name="vpart_no[]"]:last').val(part_no);
	}
});// end blur() handler
}

function toggleNotePadHandler() {
	$('#note_template').change(function() {
		if($(this).val() != 'None') {
			$('#paper').hide();
			if($(this).val() == 'Quote') $('#subj').val('Your quote has arrived from LiveWire Supply');
		}
		else {
			$('#paper').show();
			$('#subj').val('');
		}
	});
}

$(document).ready(function() {
	if($('#add_rqx').length) {
		$('#sub_rqx').hide();
		$('#sub_vmx').hide();
		window.rqx_cnt = 0;
		window.vmx_cnt = 0;
		addRqxHandler();
		addVmxHandler();
		subRqxHandler();
		subVmxHandler();
	}
	$('#notepad tr').not(':first-child').hide();
	noteTypeHandler();
	rfqEditHandler();
	updateButtonHandlers();
	priceLookupHandler();
	toggleNotePadHandler();
	$('#subj').val('Your quote has arrived from LiveWire Supply');
});
