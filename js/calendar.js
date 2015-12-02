$(document).ready(function() {

  var ajaxData = {
      dataType: 'json',
      url: 'js/getdates.php',
    };

  $.ajax(ajaxData).done(function(json) {

    $('#datepick').datepicker({
      format: 'mm/dd/yy',
      clearDates: true,
      todayHighlight: true,
      autoclose: true,
      todayBtn: 'linked',
      keyboardNavigation: false,
      inputs: $('#datepick .format-long'),
      beforeShowDay: function(isShownDate) {
        return papersExist(isShownDate, json);
      },
    });

    $('#datepick-short').datepicker({
      format: 'mm/dd',
      clearDates: true,
      todayHighlight: true,
      autoclose: true,
      todayBtn: 'linked',
      keyboardNavigation: false,
      inputs: $('#datepick-short .format-short'),
      beforeShowDay: function(isShownDate) {
        return papersExist(isShownDate, json);
      },
    });

    $(window).on('scroll', function() {
      $('#datepick-start').datepicker('hide');
      $('#datepick-end').datepicker('hide');
      $('#datepick-end').blur();
      $('#datepick-start').blur();
      $('#datepick-start-short').datepicker('hide');
      $('#datepick-end-short').datepicker('hide');
      $('#datepick-end-short').blur();
      $('#datepick-start-short').blur();
    });

    var once = false;
    if (!once) {
      $('#datepick-start').datepicker('setDate', urlToDates()[0]);
      $('#datepick-end').datepicker('setDate', urlToDates()[1]);
      $('#datepick-start-short').datepicker('setDate', urlToDates()[0]);
      $('#datepick-end-short').datepicker('setDate', urlToDates()[1]);
      once = true;
    }

    $('.cal-input').datepicker().on('changeDate', function() {
      if (once) {
        setDateRange($(this).parent());
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

function setDateRange(dateGroup) {
  startDate = dateGroup.children('.date-start').datepicker('getDate');
  endDate = dateGroup.children('.date-end').datepicker('getDate');
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
