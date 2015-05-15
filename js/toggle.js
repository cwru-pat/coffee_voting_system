$(document).ready(function() {
  $(".panel-heading").each(function(key, value) {
    $(this).on("click",function() {
      $(this).parent().children(".panel-body").slideToggle(300);
    });
  });
});
