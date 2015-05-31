$(document).ready(function() {
  $panelHash = window.location.hash.split('-')[1];
  $('.panel-heading.arxiv').each(function(key, value) {

    $(this).parent().children('.panel-body').attr('id', 'panel-body-' + key);
    $(this).parent().attr('id', 'panel-' + key);

    var panelHeadingText = $(value).children('h3').text().trim();
    if (toggleGetCookie(panelHeadingText) == 'true' && $panelHash != key) {
      toggleState = '';
      $('#panel-body-' + key).slideToggle(0, 'swing');
    } else {
      toggleState = 'active';
    }

    $('#arxiv-toggle-list').append(
      '<a role="button" href="#panel-' +
      key + '"' +
      ' class="btn btn-default btn-info btn-lg ' +
      ' section-toggle-button ' +
      toggleState +
      '" id="toggle-item-' +
      key +
      '" data-toggle="button">' +
      $(this).children('h3').html().trim() +
      '</a>'
    );

    $('#toggle-item-' + key).on('click', function() {
      $('#panel-body-' + key).slideToggle(0, 'swing');
      if (!$(this).hasClass('active')) {
        window.location.hash = $(this).attr('href');
        history.pushState('', document.title,
            window.location.pathname + window.location.search);
      }
    });

    $(this).on('click', function() {
      $('#panel-body-' + key).slideToggle(0, 'swing');
      $('#toggle-item-' + key).toggleClass('active');
    });

    $(window).on('beforeunload', function() {
      var panelHeadingText = $(value).children('h3').text().trim();
      var isActivePanel = $('#toggle-item-' + key).hasClass('active');
      toggleSetCookie(panelHeadingText, !isActivePanel, 100);
    });
  });

  $('.abstract-showhide').each(function() {
    $(this).on('click', function() {
      $('#article-' + $(this).attr('data-paperId') + '-abstract')
        .slideToggle(150, 'swing');
    });
  });
});

function toggleSetCookie(cName, value, exdays) {
  var exdate = new Date();
  exdate.setDate(exdate.getDate() + exdays);
  var cValue = value + '; expires=' + exdate.toUTCString();
  document.cookie = cName + '=' + cValue;
}

function toggleGetCookie(cName) {
  var carr = document.cookie.split(';');
  var name = cName + '=';
  for (i = 0; i < carr.length; i++) {
    c = carr[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length);
    }
  }
}

