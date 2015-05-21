$(document).ready(function() {

$('#bumpModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var paperId = button.data('paperid')
  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  $(this).find(".bump-btn").each( function(){
    
    console.log("Opened Modal",paperId)
    
    $(this).on("click", function() {
      
      var bump = $(this).data('bump');
      
      console.log("clicked a button",bump);
      //something is wrong with the ajax.... 

      var ajaxData = {
        dataType: "json",
        method: "POST",
        url: "js/bump.php",
        data: { paperId: paperId, bump: bump }
      };
      console.log("This is the ajaxData", ajaxData);
//something is wrong with the ajax call
      $.ajax(ajaxData).done(function( json ) {
        console.log("Recieved from server: ", json);
      }).fail(function( jqXHR, textStatus, errorThrown ) {
        console.log( "Error bumping.", textStatus, errorThrown, jqXHR);
      });
    })
  })
})
});



/*  $("bump-yes").each(function(index) {

  $(this).on("click", function() {
    console.log("i am here");
      var paperId = $(this).getAttribute('data-paperid');
      var bump = $(this).getAttribute('data-bump');
      var ajaxData = {
        dataType: "json",
        method: "POST",
        url: "js/bump.php",
        data: { paperId: paperId, bump: bump }
      };
      console.log("Bumped", ajaxData);
      $.ajax(ajaxData).done(function( json ) {
        console.log("Recieved from server: ", json);
      }).fail(function( jqXHR, textStatus, errorThrown ) {
        console.log( "Error submitting vote.", textStatus, errorThrown );
      });
    });
  });
*/