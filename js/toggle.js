$(document).ready(function() {
	$(".panel-heading.arxiv").each(function(key, value) {

		$(this).parent().children(".panel-body").addClass("panel-body-" + key);

		if(toggle_getCookie($(value).text().trim())=="true") {
			$('#toggle-content ul').append('<li class="list-group-item active toggle" id="toggle-list-item-'+key+'">'+ $(this).text().trim() + '</li>');
			$('.panel-body-'+key).slideToggle(0,"swing");
				//<label class="option" for="toggle-checkbox-'+key+'"> ' + $(this).text().trim() + '</label></li>');
		} else {
			$('#toggle-content ul').append('<li class="list-group-item toggle" id="toggle-list-item-'+key+'">'+ $(this).text().trim() + '</li>');
				//<label class="option" for="toggle-checkbox-'+key+'"> ' + $(this).text().trim() + '</label></li>');
		}

		$('#toggle-list-item-'+key).on("click",function() {
			$(".panel-body-"+key).slideToggle(0,"swing");
			$(this).toggleClass('active');
			//$checkbox=$('#toggle-checkbox-'+key);
			toggle_setCookie($(value).text().trim(),$(this).hasClass('active'),100);
		});

		$(this).on("click",function() {
			$listitem=$('#toggle-list-item-'+key);
			$listitem.toggleClass('active');
			$(".panel-body-" + key).slideToggle(0,"linear");
			toggle_setCookie($(value).text().trim(),$listitem.hasClass('active'),100);
		});
	});
	
	$("button.abstract").each(function() {
		$(this).on("click",function() {
			$('.panel-body#'+ $(this).attr("id")).slideToggle(150,"swing");
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

