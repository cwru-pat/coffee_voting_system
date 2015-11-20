$(document).ready(function() {

  $('[rel=tooltip]').tooltip({container: 'body'});

  var ajaxData = {
      dataType: 'json',
      url: 'js/getdates.php',
    };

  $.ajax(ajaxData).done(function(json) {
    dpicker = $('#datepick').datepicker({
      clearDates: true,
      todayHighlight: true,
      autoclose: true,
      beforeShowDay: function(isShownDate) {
        return papersExist(isShownDate, json);
      },
      todayBtn: 'linked',
      keyboardNavigation: false,
    }).data('datepicker');

    var once = false;
    if (!once) {
      dpicker.pickers[0].setDate(urlToDates()[0]);
      dpicker.pickers[1].setDate(urlToDates()[1]);
      once = true;
    }

    $('#datepick').datepicker().on('changeDate', function() {
      if (once) {
        setDateRange();
      }
    });

  }).fail(function(jqXHR, textStatus, errorThrown) {
    console.log('Error getting Dates', textStatus, errorThrown, jqXHR);
  });
});

function papersExist(date, availableDates) {
  dmy = date.getFullYear() + '-' +
    ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
    ('0' + date.getDate()).slice(-2);
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

function urlToDates() {
  var date = [];
  var dstring = parse('ds');
  date[0] = new Date(dstring);
  if (dstring === false) {
    date[0] = new Date();
  }
  dstring = parse('de');
  date[1] = new Date(dstring);
  if (dstring === false) {
    date[1] = date[0];
  }
  return date;
}

function setDateRange() {
  startDate = dpicker.pickers[0].getDate();
  endDate = dpicker.pickers[1].getDate();
  window.location =  window.location.protocol + '//' +
    window.location.host + window.location.pathname +
    '?ds=' + startDate.getFullYear() + '-' + (startDate.getMonth() + 1) +
    '-' + (startDate.getDate()) +
    '&de=' + endDate.getFullYear() + '-' + (endDate.getMonth() + 1) +
    '-' + (endDate.getDate());
}

function setDateRange2(startDate, endDate) {
  window.location =  window.location.protocol + '//' +
    window.location.host + window.location.pathname +
    '?ds=' + startDate.getFullYear() + '-' + (startDate.getMonth() + 1) +
    '-' + (startDate.getDate()) +
    '&de=' + endDate.getFullYear() + '-' + (endDate.getMonth() + 1) +
    '-' + (endDate.getDate());
}
