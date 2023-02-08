function getCookie(c_name)
{
	"use strict";
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name)
		{
			return unescape(y);
		}
	}
}
function setCookie(c_name,value,exdays)
{
	"use strict";
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value + ";domain=;path=/";
}
jQuery.fn.removeClassPrefix = function(prefix) 
{
	"use strict";
    this.each(function(i, el) {
        var classes = el.className.split(" ").filter(function(c) {
            return c.lastIndexOf(prefix, 0) !== 0;
        });
        el.className = jQuery.trim(classes.join(" "));
    });
    return this;
};
jQuery(document).ready(function($){
	"use strict";
	$(".style-selector select option[selected]").prop("selected", true);
	$(".style-selector select input[checked]").prop("checked", true);
	$(".style-selector-icon").click(function(){
		$(this).parent().toggleClass("opened");
		setCookie("cm_style_selector", ($(this).parent().hasClass("opened") ? "opened" : ""));
	});
	$(".style-selector-content ul.layout-chooser:not('.for-main-color') a").click(function(event, param){
		event.preventDefault();
		$(".style-selector-content ul.layout-chooser:not('.for-main-color') li").removeClass("selected");
		$(this).parent().addClass("selected");
		if(parseInt(param)!=1)
			$(".style-selector [name='layout_style']").val("boxed").trigger("change");
		$("body").attr("class", ($(this).attr("class").substr(0,5)=="image" ? $(this).attr("class") + ($("#overlay").is(":checked") ? " overlay" : "") : $(this).attr("class")));
		setCookie("cm_layout_style", $(this).attr("class"));
		if($(this).attr("class").substr(0,5)=="image" && $("#overlay").is(":checked"))
			setCookie("cm_image_overlay", "overlay");
		else
			setCookie("cm_image_overlay", "");
	});
	$(".style-selector-content #overlay").change(function(){
		if($(this).is(":checked"))
		{
			if($("body").is('[class*="image-"]'))
			{
				$("body").addClass("overlay");
				setCookie("cm_image_overlay", "overlay");
			}
			else
				setCookie("cm_image_overlay", "");
		}
		else
		{
			$("body").removeClass("overlay");
			setCookie("cm_image_overlay", "");
		}
	});
	$(".style-selector [name='layout_style']").change(function(){
		if($(this).val()=="boxed")
		{
			$(".site-container").addClass("boxed");
			setCookie("cm_layout", "boxed");
			$(".style-selector-content ul.layout-chooser:not('.for-main-color') .selected a").trigger("click", [1]);
		}
		else
		{
			$(".site-container").removeClass("boxed");
			setCookie("cm_layout", "");
			$("body").removeClassPrefix("image");
			$("body").removeClassPrefix("pattern");
			$("body").removeClass("overlay");
		}
		$(window).trigger('resize');
	});
	
	$(".style-selector [name='menu_type']").change(function(){
		if($(this).val()=="sticky")
		{
			$(".header-container").addClass("sticky");
			setCookie("cm_menu_type", "sticky");
			if(menu_position==null)
				menu_position = $(".header-container").offset().top;
			$(".header-container.sticky").after($(".header-container.sticky").clone().attr("id", "cm-sticky-clone").css("visibility", "visible"));
			$(document).scroll();
		}
		else
		{
			$(".header-container").removeClass("sticky").css("visibility", "visible");
			$("#cm-sticky-clone").remove();
			setCookie("cm_menu_type", "");
		}
	});
	
	$(".style-selector [name='header_type']").change(function(){
		setCookie("cm_header_type", $(this).val());
		location.reload();
	});
	
	$(".style-selector [name='header_top_bar']").change(function(){
		setCookie("cm_header_top_bar", $(this).val());
		location.reload();
	});
});