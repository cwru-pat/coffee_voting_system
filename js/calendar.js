$(document).ready(function() {
  
  availableDates=[];//["2015-06-02", "2015-06-01"];//don't know how to get the dates out of getPaperDates. json is in this form.
  console.log(availableDates);
  getPaperDates();
  console.log(availableDates);

/*  $('#datepick').datepicker({
    todayHighlight: true,
    beforeShowDay: function(dt){ 
        return papersExist(dt);
      },
    todayBtn: 'linked',
    keyboardNavigation: false,
  });*/

  $('#datepick').datepicker('update', urlToDate());

  $('#datepick').datepicker().on('changeDate', function() {
    date = $('#datepick').datepicker('getDate');
    window.location =  window.location.protocol + '//' +
      window.location.host + window.location.pathname +
      '?d=' + date.getFullYear() + '-' + (date.getMonth() + 1) +
      '-' + (date.getDate());
  });

});

function getPaperDates(){
  var ad;
  var ajaxData = {
        dataType: 'json',
        method: 'POST',
        url: 'js/getdates.php',
      };
  $.ajax(ajaxData).done(function(json) {
    console.log('Recieved from server: ', json);
    availableDates=json;
    console.log(availableDates);
      $('#datepick').datepicker({
    todayHighlight: true,
    beforeShowDay: function(dt){ 
        return papersExist(dt);
      },
    todayBtn: 'linked',
    keyboardNavigation: false,
  });
    console.log(availableDates);
  }).fail(function(jqXHR, textStatus, errorThrown) {
    console.log('Error getting Dates', textStatus, errorThrown, jqXHR);
  });
};


function papersExist(date) {
  dmy = date.getFullYear()+ "-" +('0'+(date.getMonth()+1)).slice(-2) + "-" + ('0'+date.getDate()).slice(-2) ;
  return ($.inArray(dmy, availableDates) != -1) ? true: false;
}

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
