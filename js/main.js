
var isLoggedIn = 0;

$(document).ready(function() {
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
  $(function () {
    $('[data-toggle-tip="tooltip"]').tooltip();
  });

  $.ajax({
    url: 'js/login.php',
    dataType: 'json',
    success: function(json) {
      isLoggedIn = json.isLoggedIn;
    },
  });

});