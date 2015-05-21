$(document).ready(function() {
  $(".panel-heading.arxiv").each(function(key, value) {

    $(this).parent().children(".panel-body").addClass("panel-body-" + key);

    if(toggle_getCookie($(value).text().trim())=="true") {
      toggle_state="active";
      $('.panel-body-'+key).slideToggle(0,"swing");
    } else {
      toggle_state="";
    }
 /*  $('#arxiv-toggle-list').append('<a class="list-group-item '+toggle_state+'" id="toggle-list-item-'+key+'">'+ $(this).text().trim() + '</a>');*/

$('#arxiv-toggle-list').append('<a role="button" class="btn btn-default btn-info '+toggle_state+' section-toggle-button" id="toggle-item-'+key+'">'+ $(this).text().trim() + '</a>');


    $('#toggle-item-'+key).on("click",function() {
      $(".panel-body-"+key).slideToggle(0,"swing");
      $(this).toggleClass('active');
      toggle_setCookie($(value).text().trim(),$(this).hasClass('active'),100);
    });

    $(this).on("click",function() {
      $listitem=$('#toggle-item-'+key);
      $listitem.toggleClass('active');
      $(".panel-body-" + key).slideToggle(0,"linear");
      toggle_setCookie($(value).text().trim(),$listitem.hasClass('active'),100);
    });
  });
  


  $(".abstract-showhide").each(function() {
    $(this).on("click",function() {
      $("#article-" + $(this).attr("data-paperId") + "-abstract").slideToggle(150,"swing")
      $(this).toggleClass("active");
    });
  });
});


function toggle_setCookie(c_name,value,exdays)
{
  var exdate=new Date();
  exdate.setDate(exdate.getDate() + exdays);
  var c_value=value + "; expires="+exdate.toUTCString();
  document.cookie=c_name + "=" + c_value;
}

function toggle_getCookie(c_name)
{
  var carr=document.cookie.split(";");
  var name=c_name+"="
  for (i=0;i<carr.length;i++)
  {
    c=carr[i];
    while(c.charAt(0)==' ')
      c=c.substring(1);
    if (c.indexOf(name)==0)
      return c.substring(name.length);
  }
}

