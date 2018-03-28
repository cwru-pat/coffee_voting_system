$(document).ready(function() {
  $('[data-clampedwidth]').each(function() {
    let elem = $(this);
    let parentPanel = elem.data('clampedwidth');
    let resizeFn = function() {
      const sideBarNavWidth = $(parentPanel).width() -
                            parseInt(elem.css('paddingLeft')) -
                            parseInt(elem.css('paddingRight')) -
                            parseInt(elem.css('marginLeft')) -
                            parseInt(elem.css('marginRight')) -
                            parseInt(elem.css('borderLeftWidth')) -
                            parseInt(elem.css('borderRightWidth'));
      elem.css('width', sideBarNavWidth);
    };

    resizeFn();
    $(window).resize(resizeFn);
  });

  $('#sidebar-list').affix({
    offset: {
      top: function() {
        return $('#leftCol').offset().top - 80;
      },
      bottom: function() {
        return $('.footer').outerHeight(true) + 20;
      },
    },
  });

  let $body = $(document.body);
  let navHeight = $('.navbar').outerHeight(true);

  $body.scrollspy({
    target: '#leftCol',
    offset: navHeight,
  });
});
