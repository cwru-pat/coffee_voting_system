
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

  $('#delete-post-button').on('click', function(e){
    var $form = $(this).closest('form'); 
    e.preventDefault();
    $('#confirm_delete').modal({ backdrop: 'static', keyboard: false })
      .one('click', '#modal-delete-button', function() { // (one. is not a typo of on.)
        $("#delete-post").val("delete"); // set input to 'delete'
        $form.trigger('submit'); // submit the form
      });
  });

});

function remove_newlines(text) {
  return text.replace(/(\r\n|\n|\r)/gm, " ");
}
