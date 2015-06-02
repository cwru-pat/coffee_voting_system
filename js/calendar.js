$(document).ready(function() {

  today = new Date();
  eday = new Date(today.setDate(today.getDate() + 1));

  $('#datepick').datepicker({
    todayHighlight: true,
    endDate: eday,
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

});

function parse(val) {
  var result = false;
  var tmp = [];
  window.location.search.substr(1).split('&').forEach(function(item) {
    tmp = item.split('=');
    if (tmp[0] === val) {
      result = decodeURIComponent(tmp[1]).replace(/\-/g, '/');
      console.log(result);
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
