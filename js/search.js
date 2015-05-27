
function format_search_results(xml) {
  var html = $.map( $("entry", xml), function(val, i) {
    var items = "<li>"
              + $("title", val).text()
              + " - "
              + $("id", val).text()
              + " [ Option to vote / import? ] "
              + " [ Link to page.php page? ] "
              + "</li>";
    return "<ul>" + items + "</ul>";
  }).join("");
  $("#arxiv_search_results").html(html);
}

$(document).ready(function() {
  $('#arxiv_search').on("input", function() {
    $.ajax({
      url: 'https://export.arxiv.org/api/query',
      type: 'GET',
      dataType: 'xml',
      data: {
        search_query: this.value,
        start: 0,
        max_results: 10
      },
      success: function(xml) {
        format_search_results(xml);
      },
    });
  });
});
