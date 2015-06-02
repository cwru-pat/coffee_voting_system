$(document).ready(function() {
  
  var ajaxData = {
        dataType: 'json',
        method: 'POST',
        url: 'js/getdates.php',
      };

  $.ajax(ajaxData).done(function(json) {
    console.log('Recieved from server: ', json);

    $('#datepick').datepicker({
        todayHighlight: true,
        beforeShowDay: function(isShownDate) {
          return papersExist(isShownDate, json);
        },
      todayBtn: 'linked',
      keyboardNavigation: false,
    });

    $('#datepick').datepicker('update', urlToDate());

    $('#datepick').datepicker().on('changeDate', function() {
      date = $('#datepick').datepicker('getDate');
      window.location =  window.location.protocol + '//' +
        window.location.host + window.location.pathname +
        '?d=' + date.getFullYear() + '-' + (date.getMonth() + 1) +
        '-' + (date.getDate());
    });

  }).fail(function(jqXHR, textStatus, errorThrown) {
    console.log('Error getting Dates', textStatus, errorThrown, jqXHR);
  });

});

function papersExist(date, availableDates) {
  dmy = date.getFullYear()+ "-" +('0'+(date.getMonth()+1)).slice(-2) + "-" + ('0'+date.getDate()).slice(-2);
  return ($.inArray(dmy, availableDates) != -1) ? true : false;
}

function parse(val) {
  var result = false;
  var tmp = [];
  window.location.search.substr(1).split('&').forEach(function(item) {
    tmp = item.split('=');
    if (tmp[0] === val) {
      result = decodeURIComponent(tmp[1]).replace(/\-/g, '/');
    }
  });
  return result;
}

function urlToDate() {
  var dstring = parse('d');
  var date = new Date(dstring);
  if (dstring === false) {
    date = new Date();
  }
  return date;
}
