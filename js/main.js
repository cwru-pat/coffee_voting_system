
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

function remove_newlines(text) {
  return text.replace(/(\r\n|\n|\r)/gm, "");
}
