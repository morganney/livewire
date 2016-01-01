function prepareSelects(json, active_id) {
  if(active_id) {// selection is being made
	// disable the dropdown providing the latest choice
	$('select#' + active_id).attr('disabled', 'disabled');
	// build an array with the id's of remaining select elements
	var rem_choices = $('input#unchosen_ids').val().split(':'); 
	rem_choices.pop();// has trailing ':', hence the pop()
	for(var i = 0; i < rem_choices.length; i++) {
	  var s = $('select#' + rem_choices[i])[0];
	  s.options.length = 0;
	  $.browser.msie ? s.add(new Option('-- Choose --', -1)) : s.add(new Option('-- Choose --', -1), null);
	  for(var j = 0; j < json[rem_choices[i]].length; j++) {
	    $.browser.msie ? s.add(new Option(json[rem_choices[i]][j], json[rem_choices[i]][j])) : s.add(new Option(json[rem_choices[i]][j], json[rem_choices[i]][j]), null);
	  }
	}
	
  } else {// user is reseting dropdown's
    $('select.step').removeAttr('disabled').each(function() {
      this.options.length = 0;
      $.browser.msie ? this.add(new Option('-- Choose --', -1)) : this.add(new Option('-- Choose --', -1), null);
      for(var i = 0; i < json[this.id].length; i++) {
    	$.browser.msie ? this.add(new Option(json[this.id][i], json[this.id][i])) : this.add(new Option(json[this.id][i], json[this.id][i]), null);
      }
      this.options[0].selected = 'selected';
    });
	$('input#unchosen_ids').val('group:type:amperage:');
  }
} // end prepareSelects()

function prepareResults(parts) {
  $('#matching_parts tbody').empty();
  for(var i = 0; i < parts.length; i++) {
    $('#matching_parts tbody').append(
      "<tr><td><a href='" + parts[i].url + "'>" + parts[i].part_no + '</a></td><td>' + parts[i].grp + '</td><td>' + parts[i].frame_type + '</td><td>' + parts[i].amps + '</td></tr>'
    );
  }
  var srch_params = new Object();
  if(parseInt($('select#group').val()) != -1) srch_params.Group =  $('select#group').val();
  if(parseInt($('select#type').val()) != -1) srch_params.Type =  $('select#type').val();
  if(parseInt($('select#amperage').val()) != -1) srch_params.Amperage =  $('select#amperage').val();
  var my_html = '<strong>Search Criteria:</strong> ';
  for(var p in srch_params) {
    my_html = my_html  + p + ':<em>' + srch_params[p] + '</em>';
  }
  $('span#srch_params').html(my_html);
  $('#matching_parts').removeClass('invisible');
}// end prepareResults()

$(document).ready(function() {
  $('input#unchosen_ids').val('group:type:amperage:');
  $('select.step')
  .removeAttr('disabled')
  .each(function(){this.options[0].selected='selected';})
  .change(function() {
	var active_id = $(this).attr('id');
	var old_unchosen_ids = $('input#unchosen_ids').val();
	$('input#unchosen_ids').val(old_unchosen_ids.replace(active_id + ':', ''));
	$.getJSON(
	  // URL
	  $(this).parents('form').attr('action'),
	  // parameters
	  {group: $('select#group').val(), type: $('select#type').val(), amps: $('select#amperage').val(), manuf_id: $('input#manuf_id').val()},
	  // callback
	  function(json, status) {
	    if(status == 'success') {
	      if(json != null) {
	    	prepareSelects(json, active_id);
	    	prepareResults(json.parts);
	      } else {
	    	  // I guess I never finished this script completely?? 7/21/2010
	    	  alert('something is not right logically!');
	      }
		} else {
			alert('status = ' + status);
		}
	  }// end callback
	);// end getJSON()
  });// end change() handler
  $('form#selection').removeClass('invisible');
  $('a#reset').click(function() {
    $.getJSON(
      $(this).parents('form').attr('action'), 
      {group: -1, type: -1, amps: -1, manuf_id: $('input#manuf_id').val()},
      function(json, status) {
        prepareSelects(json, false);
      }
    );
    $('#matching_parts').addClass('invisible');
    return false;
  });
});// end DOM ready handler
