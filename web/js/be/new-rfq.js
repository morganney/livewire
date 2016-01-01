function addRqxHandler() {
	$('#add_rqx').click(function() {
		window.rqx_cnt++;
		$('#rqx_rows tr:nth-child(2)').clone(true).appendTo('#rqx_rows').find('input[type=text]').val('');
		// remove any previously inserted display values from cloned tr
		//.end().find('input[name="display[]"]').parent().remove();
		// adding the note row here was easier than trying to clone it
		$("<tr><td class='tags r'>Notes</td><td colspan='7'><textarea cols='25' rows='1' name='notes[]'></textarea></td></tr>")
		.appendTo('#rqx_rows');
		if($('#sub_rqx').is(':hidden')) $('#sub_rqx').show();
		return false;
	});
}

function subRqxHandler() {
	$('#sub_rqx').click(function() {
		window.rqx_cnt--;
		$('#rqx_rows tr:last-child').remove(); // remove notes
		$('#rqx_rows tr:last-child').remove(); // remove rqx details
		if(window.rqx_cnt <= 1) $(this).hide();
		return false;
	});
}

function addVmxHandler() {
	$('#add_vmx').click(function() {
		window.vmx_cnt++;
		$('#vmx_clone tr').clone().appendTo('#vmx_rows');
		if($('#sub_vmx').is(':hidden')) $('#sub_vmx').show();
		//purchaseHistoryHandler(); //need to rebind to new items...

		//callback to new notes...
		$('textarea[name="vnotes[]"]').focus(function() { 
			$(this).removeClass('grey');
			if ($(this).val() == "Notes...") $(this).val('');
		});
		
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

function saveButtonHandlers() {
	$('#save, #save_close').click(function() {
		if(rfqFormIsValid()) {
		$(this).attr('id') == 'save' ? $('#continue').val('1') : $('#continue').val('0');
		$('#sent_to').val($('#to').val());
		$('form#new_rfq').submit();
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

function rfqFormIsValid() {
	window.rfq_errs = [];
	
	$('input[name="part_no[]"]').each(function(idx) {
		if(!$.trim($(this).val())) {
			window.rfq_errs.push('Catalog No. is required for all Request & Quote rows.');
			return false;
		}
	});
	
	$('input[name="part_no[]"]').each(function(i) {
		var i_val = $(this).val();
		for(var j = i + 1; j < window.rqx_cnt; j++) {
			var next = $('input[name="part_no[]"]').get(j);
			if(next.value == i_val) {
				window.rfq_errs.push('Catalog No. must be unique for all Request & Quote rows.');
				return false;
			}
		}
	});
	
	$('input[name="qty_req[]"]').each(function(idx) {
		if(!$.trim($(this).val()) || isNaN(parseInt($(this).val()))) {
			window.rfq_errs.push('QTY is required for all Request & Quote rows.');
			return false;
		}
	});
	
	$('input[name="quoted_new[]"]').each(function(idx) {
		if($(this).val() && isNaN(parseFloat(this.value.replace('$','').replace(',','')))) {
			window.rfq_errs.push('New Quote values must be a dollar amount.');
			return false;
		}
	});
	
	$('input[name="quoted_grn[]"]').each(function(idx) {
		if($(this).val() && isNaN(parseFloat(this.value.replace('$','').replace(',','')))) {
			window.rfq_errs.push('Used Quote values must be a dollar amount.');
			return false;
		}
	});
	
	// isertion of vmx rows option on creation of new RFQ
	$('.module input[name="vpart_no[]"]').each(function(idx) {
		var price = $('input[name="purchase_price[]"]').get(idx);
		if($(this).val()) {
			if(isNaN(parseFloat(price.value.replace('$','').replace(',','')))) {
				window.rfq_errs.push('Price must be a dollar amount for all Purchasing rows.');
				return false;
			}
		} else if (price.value || (idx > 0 && !$(this).val())){
			window.rfq_errs.push('Catalog No. & Price are required for all Purchasing rows.');
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
			// check that at least one quoted price is available for each R&Q row
			$('input[name="part_no[]"]').each(function(i) {
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

function priceLookupHandler() {
$('input.ns').blur(function() {
	var part_bx = this;
	var part_no = $.trim($(part_bx).val());
	if(part_no.length >= 2) {// part number 'BA' exists
		// clean this up using window.location.pathname.split('/') & window.location.host
		var endpoint = window.location.href.indexOf('_dev') > -1 ? '/backend_dev.php/ns-price' : '/backend.php/ns-price';
		var qs = 'part_no=' + encodeURIComponent($(part_bx).val());
		var parent_tr = $(part_bx).parent().parent();
		var new_price_bx = $(parent_tr).find('input[name="quoted_new[]"]').css({'background-image' : 'url(/images/be/price-loader.gif)'}).get(0);
		var grn_price_bx = $(parent_tr).find('input[name="quoted_grn[]"]').css({'background-image' : 'url(/images/be/price-loader.gif)'}).get(0);
		var mfr_bx = $(parent_tr).find('select[name="mfr[]"]').get(0);
		var cat_bx = $(parent_tr).find('select[name="category[]"]').get(0);
		$.getJSON(endpoint,qs,
			function(json, status) {
				if(status == 'success' && json != null) {
					$(cat_bx).val(json.category);
					$(mfr_bx).val(json.manuf);
					$(parent_tr).find('input[name="qty_req[]"]').val('1');
					$(new_price_bx).css({'background-image' : 'url()'}).val('').val(json.new_price);
					$(grn_price_bx).css({'background-image' : 'url()'}).val('').val(json.grn_price);
					$(parent_tr).find('input[name="display[]"]').val(json.display);
				} else if (status != 'success'){
					$(new_price_bx).css({'background-image' : 'url()'});
					$(grn_price_bx).css({'background-image' : 'url()'});
					alert('NetSuite price lookup is not working, contact administrator.');
				} else {
					// Maybe a part was entered that doesn't exist in our DB, or DB error.
					$(parent_tr).find('input[name="qty_req[]"]').val('1');
					$(new_price_bx).css({'background-image' : 'url()'}).val('');
					$(grn_price_bx).css({'background-image' : 'url()'}).val('');
					$(parent_tr).find('input[name="display[]"]').val(0);
				}
			}
		);// end getJSON()
		
		$('#add_vmx').click();
		
		var endpoint = window.location.href.indexOf('_dev') > -1 ? '/backend_dev.php/purchase-history' : '/backend.php/purchase-history';
		var qs = 'part_no=' + encodeURIComponent($(this).val());
		$.getJSON(endpoint,qs,
				function(json, status) {
					if(status == 'success' && json != null) {

				    //build out the rows...
					var line = '<table class="tbl_ph"><tr><td><table class="tbl_ph">';
					for (var item in json.New) {
							line = line + '<tr>';
							line = line + '<td title="'+ json.New[item].name +'">' + json.New[item].name.substr(0,7) +'&#8230;</td>';
							line = line + '<td>' + json.New[item].ts +'</td>';
							line = line + '<td>' + json.New[item].purchase_price +'</td>';
							line = line + '</tr>';
					}
					line = line + '</table></td><td><table class="tbl_ph green">';
					for (var item in json.Green) {
							line = line + '<tr>';
							line = line + '<td title="'+ json.New[item].name +'">' + json.Green[item].name.substr(0,7) +'&#8230;</td>';
							line = line + '<td>' + json.Green[item].ts +'</td>';
							line = line + '<td>' + json.Green[item].purchase_price +'</td>';
							line = line + '</tr>';
					}
					line = line + '</table><td></tr></table>';
					
					$('#vmx_rows tr:last-child .r').html(line);
					
					} else if (status != 'success'){
						alert('Purchase History seems broken, harass your administrator.');
					} else {
						// Maybe a part was entered that doesn't exist in our DB, or DB error.

					}
				}
		); //end more get json
		
		
	}
	// add a vmx row and populate the vpart_no field with the part number from the R&Q row
	
	$('#vmx_rows').find('input[name="vpart_no[]"]:last').val(part_no);
	
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

function purchaseHistoryHandler() { 
	
	//trigger ajax lookup when person leaves the pu div
	//this seems the simplest way to do this...
	$('input[name="vpart_no[]"]').blur(function(e) {

	});	
	
}

$(document).ready(function() {
	//$('#add_rqx').appendTo('div.rq td.notes:last');
	$('#notepad tr').not(':first-child').hide();
	$('input#subj').attr('autocomplete', 'off');
	if($('#add_rqx').length) {
		$('#sub_rqx').hide();
		$('#sub_vmx').hide();
		window.rqx_cnt = 1;
		window.vmx_cnt = 0;
		addRqxHandler();
		addVmxHandler();
		subRqxHandler();
		subVmxHandler();
	}
	
	noteTypeHandler();
	saveButtonHandlers();
	priceLookupHandler();
	toggleNotePadHandler();
	
	//purchaseHistoryHandler(); apparnetly not needed on new... stuff gets bound later
	
	
	$('#subj').val('Your quote has arrived from LiveWire Supply');
});
