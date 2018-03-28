$(document).ready(function() {
  $('#bumpModal').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget); // Button that triggered the modal
    const paperId = button.data('paperid');

    $(this).find('.bump-btn').each(function() {
      $(this).data('paperid', paperId);
    });
  });

  $('.bump-btn').on('click', function() {
    const bump = $(this).data('bump');
    const paperId = $(this).data('paperid');

    const ajaxData = {
      dataType: 'json',
      method: 'POST',
      url: 'js/bump.php',
      data: {paperId: paperId, bump: bump},
    };

    $.ajax(ajaxData).done(function(json) {
      console.log('Recieved from server: ', json);
    }).fail(function(jqXHR, textStatus, errorThrown) {
      console.log('Error bumping.', textStatus, errorThrown, jqXHR);
    });
  });
});
