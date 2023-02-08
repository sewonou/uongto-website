"use strict";
/*window.odometerOptions = {
  auto: true, // Don't automatically initialize everything with class 'odometer'
  selector: '.number.animated-element', // Change the selector used to automatically find things to be animated
  format: '(ddd).dd', // Change how digit groups are formatted, and how many digits are shown after the decimal point
  duration: 2000, // Change how long the javascript expects the CSS animation to take
  theme: 'default', // Specify the theme (if you have more than one theme css file on the page)
  animation: 'count' // Count is a simpler animation method which just increments the value,
                     // use it when you're looking for something more subtle.
};*/
var map = null;
var marker = null;
var menu_position = null;
var modificator = 0;
function gm_authFailure() 
{
	if($("#map").length)
		alert('Please define Google Maps API Key.\nReplace YOUR_API_KEY with the key generated on https://developers.google.com/maps/documentation/javascript/get-api-key\nin below line before the </body> closing tag <script type="text/javascript" src="//maps.google.com/maps/api/js?key=YOUR_API_KEY"></script>');
}
jQuery(document).ready(function($){
	//odometer
	$('.number.animated-element').each(function(){
		var self = $(this)[0];
		var od = new Odometer({
			el: self,
			format: '(ddd).dd',
			duration: 2000,
			theme: 'default',
			animation: 'count'
		});
	});
	//preloader
	var preloader = function()
	{
		$(".blog a.post-image>img, .post.single .post-image img, .services-list a>img, .projects-list:not('.isotope') a>img, .cm-preload>img").each(function(){
			$(this).before("<span class='cm-preloader'></span>");
			imagesLoaded($(this)).on("progress", function(instance, image){
				$(image.img).prev(".cm-preloader").remove();
				if($(image.img).prev(".post-date").length)
				{
					$(image.img).prev(".post-date").fadeTo("slow", 1, function(){
						$(this).css("opacity", "");
					});
				}
				$(image.img).css("display", "block");
				$(image.img).parent().css("opacity", "0");
				$(image.img).parent().fadeTo("slow", 1, function(){
					$(this).css("opacity", "");
				});
			});
		});
		
	};
	preloader();
	//slider
	jQuery('.revolution-slider').show().revolution({
		dottedOverlay:"none",
		delay:6000,
		sliderLayout:"auto",
		responsiveLevels:[1920,1173,751,463],
		gridwidth:[1170,750,462,300],
		gridheight:[700,650,380,420],
		lazyType:"none",
		navigation: {
			keyboardNavigation:"on",
			onHoverStop:"on",
			touch:{
				touchenabled:"on",
				swipe_treshold : 75,
				swipe_min_touches : 1,
				drag_block_vertical:false,
				swipe_direction:"horizontal"
            },
			arrows: {
				style:"preview1",
				enable:true,
				hide_onmobile:true,
				hide_onleave:true,
				hide_delay:200,
				hide_delay_mobile:1500,
				hide_under:767,
				hide_over:9999,
				tmp:'',
				left : {
					h_align:"left",
					v_align:"center",
					h_offset:50,
					v_offset:0,
				},
				right : {
					h_align:"right",
					v_align:"center",
					h_offset:50,
					v_offset:0
				}
			},
			bullets: {
				style:"preview1",
				enable:true,
				hide_onmobile:true,
				hide_onleave:true,
				hide_delay:200,
				hide_delay_mobile:1500,
				hide_under:767,
				hide_over:9999,
				direction:"horizontal",
				h_align:"center",
				v_align:"bottom",
				space:16,
				h_offset:0,
				v_offset:37,
				tmp:''
			},
			parallax:{
			   type:"off",
			   bgparallax:"off",
			   disable_onmobile:"on"
			}
		},
		shadow:0,
		spinner:"spinner0",
		stopAfterLoops:-1,
		stopAtSlide:-1,
		disableProgressBar: "on"
	});
	//search form
	$(".template-search").on("click", function(event){
		event.preventDefault();
		$(this).parent().children(".search").toggle();
	});
	//mobile menu
	$(".mobile-menu-switch").on("click", function(event){
		event.preventDefault();
		if(!$(".mobile-menu-container nav .mobile-menu").is(":animated"))
		{
			if(!$(".mobile-menu-container nav .mobile-menu").is(":visible"))
				$(".header-container").css("z-index", 4);
			$(".mobile-menu-container nav .mobile-menu").slideToggle(500, function(){
				if(!$(".mobile-menu-container nav .mobile-menu").is(":visible"))
					$(".header-container").css("z-index", 3);
			});
		}
	});
	$(".mobile-menu .template-arrow-vertical-3").on("click", function(event){
		event.preventDefault();
		if(!$(".mobile-menu-container nav .mobile-menu").is(":animated"))
		{
			if(!$(".mobile-menu-container nav .mobile-menu").is(":visible"))
				$(".header-container").css("z-index", 4);
			$(".mobile-menu-container nav .mobile-menu").slideToggle(500, function(){
				if(!$(".mobile-menu-container nav .mobile-menu").is(":visible"))
					$(".header-container").css("z-index", 3);
			});
		}
	});
	$(".collapsible-mobile-submenus .template-arrow-menu").on("click", function(event){
		event.preventDefault();
		$(this).next().slideToggle(300);
		$(this).toggleClass("template-arrow-expanded");
	});
	
	//header toggle
	$(".header-toggle").on("click", function(event){
		event.preventDefault();
		$(this).prev().slideToggle();
		$(this).toggleClass("active");
	});
	//cost calculator
	$(".cost-slider").each(function(){
		$(this).slider({
			range: "min",
			value: $(this).data("value"),
			min: $(this).data("min"),
			max: $(this).data("max"),
			step: $(this).data("step"),
			slide: function(event, ui){
				$("#" + $(this).data("input")).val(ui.value);
				$("." + $(this).data("input") + "-hidden").val(ui.value);
				$(this).find(".cost-slider-tooltip .value").html(ui.value);
				if(typeof($(this).data("price"))!="undefined")
					$("#" + $(this).data("value-input")).val(ui.value*$(this).data("price"));
				$(".cost-calculator-price").costCalculator("calculate");
			},
			change: function(event, ui){
				$("#" + $(this).data("input")).val(ui.value);
				$("." + $(this).data("input") + "-hidden").val(ui.value);
				$(this).find(".cost-slider-tooltip .value").html(ui.value);
				if(typeof($(this).data("price"))!="undefined")
					$("#" + $(this).data("value-input")).val(ui.value*$(this).data("price"));
				$(".cost-calculator-price").costCalculator("calculate");
			}
		}).find(".ui-slider-handle").append('<div class="cost-slider-tooltip"><div class="arrow"></div><div class="value">' + $(this).data("value") + '</div></div>');
	});
	$(".cost-slider-input").on("paste change keyup", function(){
		var self = $(this);
		if(self.attr("type")=="checkbox")
		{	
			if(self.is(":checked"))
				self.val(self.data("value"));
			else
				self.val(0);
		}
		if($("[data-input='" + self.attr("id") + "']").length)
			setTimeout(function(){
				$("[data-input='" + self.attr("id") + "']").slider("value", self.val());
			}, 500);
		else
		{
			$(".cost-calculator-price").costCalculator("calculate");
		}
	});
	$(".cost-dropdown").each(function(){
		$(this).selectmenu({
			/*width: 370,*/
			icons: { button: "template-arrow-vertical-3" },
			change: function(event, ui){
				$(".cost-calculator-price").costCalculator("calculate");
				$("." + $(this).attr("id")).val(ui.item.label);
				$("." + $(this).attr("id") + "-hidden").val($(this).val());
			},
			select: function(event, ui){
				$(".cost-calculator-price").costCalculator("calculate");
				$("." + $(this).attr("id")).val(ui.item.label);
				$("." + $(this).attr("id") + "-hidden").val($(this).val());
			},
			create: function(event, ui){
				$(".contact-form").each(function(){
					$(this)[0].reset();
				});
				$(this).selectmenu("refresh")
			}
		});
	});
	/*$.datepicker.regional['nl'] = {clearText: 'Effacer', clearStatus: '',
		closeText: 'sluiten', closeStatus: 'Onveranderd sluiten ',
		prevText: '<vorige', prevStatus: 'Zie de vorige maand',
		nextText: 'volgende>', nextStatus: 'Zie de volgende maand',
		currentText: 'Huidige', currentStatus: 'Bekijk de huidige maand',
		monthNames: ['januari','februari','maart','april','mei','juni',
		'juli','augustus','september','oktober','november','december'],
		monthNamesShort: ['jan','feb','mrt','apr','mei','jun',
		'jul','aug','sep','okt','nov','dec'],
		monthStatus: 'Bekijk een andere maand', yearStatus: 'Bekijk nog een jaar',
		weekHeader: 'Sm', weekStatus: '',
		dayNames: ['zondag','maandag','dinsdag','woensdag','donderdag','vrijdag','zaterdag'],
		dayNamesShort: ['zo', 'ma','di','wo','do','vr','za'],
		dayNamesMin: ['zo', 'ma','di','wo','do','vr','za'],
		dayStatus: 'Gebruik DD als de eerste dag van de week', dateStatus: 'Kies DD, MM d',
		dateFormat: 'dd/mm/yy', firstDay: 1, 
		initStatus: 'Kies een datum', isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['nl']);*/
	$(".cost-slider-datepicker").each(function(){
		$(this).datepicker({
			dateFormat: "DD, d MM yy",
			nextText: "",
			prevText: ""
		});
	});
	$(".datepicker-container .ui-icon").on("click", function(){
		$(this).next().datepicker("show");
	});
	$("#basic-service-cost").costCalculator({
		formula: "cleaning-frequency*clean-area+cleaning-frequency*basic-service-cleaning-supplies+cleaning-frequency*basic-service-bedrooms*10+cleaning-frequency*basic-service-bathrooms*20+cleaning-frequency*basic-service-livingrooms*30+cleaning-frequency*basic-service-kitchen-size+cleaning-frequency*basic-service-bathroom-includes+cleaning-frequency*basic-service-pets+cleaning-frequency*basic-service-dining-room+cleaning-frequency*basic-service-play-room+cleaning-frequency*basic-service-laundry+cleaning-frequency*basic-service-gym+cleaning-frequency*basic-service-garage+cleaning-frequency*basic-service-refrigerator-clean",
		currency: "$",
		currencyPosition: "before",
		thousandthSeparator: ",",
		decimalSeparator: ".",
		updateHidden: $("#basic-service-total-cost")
	});
	$("#premium-service-cost").costCalculator({
		formula: "cleaning-frequency*clean-area+cleaning-frequency*premium-service-cleaning-supplies+cleaning-frequency*premium-service-bedrooms*10+cleaning-frequency*premium-service-bathrooms*20+cleaning-frequency*premium-service-livingrooms*30+cleaning-frequency*premium-service-kitchen-size+cleaning-frequency*premium-service-bathroom-includes+cleaning-frequency*premium-service-pets+cleaning-frequency*premium-service-dining-room+cleaning-frequency*premium-service-play-room+cleaning-frequency*premium-service-laundry+cleaning-frequency*premium-service-gym+cleaning-frequency*premium-service-garage+cleaning-frequency*premium-service-refrigerator-clean",
		currency: "$",
		currencyPosition: "before",
		thousandthSeparator: ",",
		decimalSeparator: ".",
		updateHidden: $("#premium-service-total-cost")
	});
	$("#post-renovation-service-cost").costCalculator({
		formula: "cleaning-frequency*clean-area+cleaning-frequency*post-renovation-cleaning-supplies+cleaning-frequency*post-renovation-bedrooms*10+cleaning-frequency*post-renovation-bathrooms*20+cleaning-frequency*post-renovation-livingrooms*30+cleaning-frequency*post-renovation-kitchen-size+cleaning-frequency*post-renovation-bathroom-includes+cleaning-frequency*post-renovation-pets+cleaning-frequency*post-renovation-dining-room+cleaning-frequency*post-renovation-play-room+cleaning-frequency*post-renovation-laundry+cleaning-frequency*post-renovation-gym+cleaning-frequency*post-renovation-garage+cleaning-frequency*post-renovation-refrigerator-clean",
		currency: "$",
		currencyPosition: "before",
		thousandthSeparator: ",",
		decimalSeparator: ".",
		updateHidden: $("#post-renovation-service-total-cost")
	});
	$("#basic-service-cost-2").costCalculator({
		formula: "basic-service-cleaning-frequency*basic-service-clean-area+basic-service-cleaning-frequency*basic-service-cleaning-supplies+basic-service-cleaning-frequency*bedrooms*10+basic-service-cleaning-frequency*bathrooms*20+basic-service-cleaning-frequency*basic-service-livingrooms*30+basic-service-cleaning-frequency*basic-service-kitchen-size+basic-service-cleaning-frequency*basic-service-bathroom-includes+basic-service-cleaning-frequency*basic-service-pets+basic-service-cleaning-frequency*basic-service-dining-room+basic-service-cleaning-frequency*basic-service-play-room+basic-service-cleaning-frequency*basic-service-laundry+basic-service-cleaning-frequency*basic-service-gym+basic-service-cleaning-frequency*basic-service-garage+basic-service-cleaning-frequency*basic-service-refrigerator-clean",
		currency: "$",
		currencyPosition: "before",
		thousandthSeparator: ",",
		decimalSeparator: ".",
		updateHidden: $("#basic-service-total-cost")
	});
	$("#premium-service-cost-2").costCalculator({
		formula: "premium-service-cleaning-frequency*premium-service-clean-area+premium-service-cleaning-frequency*premium-service-cleaning-supplies+premium-service-cleaning-frequency*bedrooms*10+premium-service-cleaning-frequency*bathrooms*20+premium-service-cleaning-frequency*premium-service-livingrooms*30+premium-service-cleaning-frequency*premium-service-kitchen-size+premium-service-cleaning-frequency*premium-service-bathroom-includes+premium-service-cleaning-frequency*premium-service-pets+premium-service-cleaning-frequency*premium-service-dining-room+premium-service-cleaning-frequency*premium-service-play-room+premium-service-cleaning-frequency*premium-service-laundry+premium-service-cleaning-frequency*premium-service-gym+premium-service-cleaning-frequency*premium-service-garage+premium-service-cleaning-frequency*premium-service-refrigerator-clean",
		currency: "$",
		currencyPosition: "before",
		thousandthSeparator: ",",
		decimalSeparator: ".",
		updateHidden: $("#premium-service-total-cost")
	});
	$("#post-renovation-service-cost-2").costCalculator({
		formula: "post-renovation-cleaning-frequency*post-renovation-clean-area+post-renovation-cleaning-frequency*post-renovation-cleaning-supplies+post-renovation-cleaning-frequency*bedrooms*10+post-renovation-cleaning-frequency*bathrooms*20+post-renovation-cleaning-frequency*post-renovation-livingrooms*30+post-renovation-cleaning-frequency*post-renovation-kitchen-size+post-renovation-cleaning-frequency*post-renovation-bathroom-includes+post-renovation-cleaning-frequency*post-renovation-pets+post-renovation-cleaning-frequency*post-renovation-dining-room+post-renovation-cleaning-frequency*post-renovation-play-room+post-renovation-cleaning-frequency*post-renovation-laundry+post-renovation-cleaning-frequency*post-renovation-gym+post-renovation-cleaning-frequency*post-renovation-garage+post-renovation-cleaning-frequency*post-renovation-refrigerator-clean",
		currency: "$",
		currencyPosition: "before",
		thousandthSeparator: ",",
		decimalSeparator: ".",
		updateHidden: $("#post-renovation-service-total-cost")
	});
	$("#final-service-cost").costCalculator({
		formula: "cleaning-frequency*clean-area+cleaning-frequency*cleaning-supplies+cleaning-frequency*bedrooms*10+cleaning-frequency*bathrooms*20+cleaning-frequency*livingrooms*30+cleaning-frequency*kitchen-size+cleaning-frequency*bathroom-includes+cleaning-frequency*pets+cleaning-frequency*dining-room+cleaning-frequency*play-room+cleaning-frequency*laundry+cleaning-frequency*gym+cleaning-frequency*garage+cleaning-frequency*refrigerator-clean",
		currency: "$",
		currencyPosition: "before",
		thousandthSeparator: ",",
		decimalSeparator: ".",
		updateHidden: $("#final-service-cost-hidden")
	});
	
	//parallax
	if(!navigator.userAgent.match(/(iPod|iPhone|iPad|Android)/))
	{
		$(".parallax-2").each(function(){
			$(this).parallax({
				speed: -50
			});
		});
	}
	else
		$(".parallax").addClass("attachment-scroll");
	
	//isotope
	$(".isotope").isotope({
		masonry: {
			//columnWidth: 225,
			gutter: 30
		}
	});	
	
	//testimonials
	$(".testimonials-carousel").each(function(){
		var self = $(this);
		var length = $(this).children().length;
		var elementClasses = $(this).attr('class').split(' ');
		var autoplay = 0;
		var pause_on_hover = 0;
		var scroll = 1;
		var effect = "scroll";
		var easing = "easeInOutQuint";
		var duration = 750;
		for(var i=0; i<elementClasses.length; i++)
		{
			if(elementClasses[i].indexOf('autoplay-')!=-1)
				autoplay = elementClasses[i].replace('autoplay-', '');
			if(elementClasses[i].indexOf('pause_on_hover-')!=-1)
				pause_on_hover = elementClasses[i].replace('pause_on_hover-', '');
			if(elementClasses[i].indexOf('scroll-')!=-1)
				scroll = elementClasses[i].replace('scroll-', '');
			if(elementClasses[i].indexOf('effect-')!=-1)
				effect = elementClasses[i].replace('effect-', '');
			if(elementClasses[i].indexOf('easing-')!=-1)
				easing = elementClasses[i].replace('easing-', '');
			if(elementClasses[i].indexOf('duration-')!=-1)
				duration = elementClasses[i].replace('duration-', '');
		}
		self.carouFredSel({
			/*responsive: true,*/
			width: "auto",
			items: {
				visible: 1
			},
			scroll: {
				items: 1,
				fx: effect,
				easing: easing,
				duration: parseInt(duration, 10),
				pauseOnHover: (parseInt(pause_on_hover, 10) ? true : false)
			},
			auto: {
				play: (parseInt(autoplay, 10) ? true : false),
				fx: effect,
				easing: easing,
				duration: parseInt(duration, 10),
				pauseOnHover: (parseInt(pause_on_hover, 10) ? true : false)
			},
			pagination: {
				container: $(self).prev(".cm-carousel-pagination")
			},
			'prev': {button: self.prev()},
			'next': {button: self.next()}
		},
		{
			transition: true,
			wrapper: {
				classname: "caroufredsel_wrapper caroufredsel_wrapper_testimonials"
			}
		});
		var base = "x";
		var scrollOptions = {
			scroll: {
				easing: "easeInOutQuint",
				duration: 750
			}
		};
		self.swipe({
			fallbackToMouseEvents: true,
			allowPageScroll: "vertical",
			excludedElements:"button, input, select, textarea, .noSwipe",
			swipeStatus: function(event, phase, direction, distance, fingerCount, fingerData ) {
				//if(!self.is(":animated") && (!$(".control-for-" + self.attr("id")).length || ($(".control-for-" + self.attr("id")).length && !$(".control-for-" + self.attr("id")).is(":animated"))))
				if(!self.is(":animated"))
				{
					self.trigger("isScrolling", function(isScrolling){
						if(!isScrolling)
						{
							if (phase == "move" && (direction == "left" || direction == "right")) 
							{
								if(base=="x")
								{
									self.trigger("configuration", scrollOptions);
									self.trigger("pause");
								}
								if (direction == "left") 
								{
									if(base=="x")
										base = 0;
									self.css("left", parseInt(base, 10)-distance + "px");
								} 
								else if (direction == "right") 
								{	
									if(base=="x" || base==0)
									{
										self.children().last().prependTo(self);
										base = -self.children().first().width()-parseInt(self.children().first().css("margin-right"), 10);
									}
									self.css("left", base+distance + "px");
								}

							} 
							else if (phase == "cancel") 
							{
								if(distance!=0)
								{
									self.trigger("play");
									self.animate({
										"left": base + "px"
									}, 750, "easeInOutQuint", function(){
										if(base==-self.children().first().width()-parseInt(self.children().first().css("margin-right"), 10))
										{
											self.children().first().appendTo(self);
											self.css("left", "0px");
											base = "x";
										}
										self.trigger("configuration", {scroll: {
											easing: "easeInOutQuint",
											duration: 750
										}});
									});
								}
							} 
							else if (phase == "end") 
							{
								self.trigger("play");
								if (direction == "right") 
								{
									self.trigger('ql_set_page_nr', 1);
									self.animate({
										"left": 0 + "px"
									}, 750, "easeInOutQuint", function(){
										self.trigger("configuration", {scroll: {
											easing: "easeInOutQuint",
											duration: 750
										}});
										base = "x";
									});
								} 
								else if (direction == "left") 
								{
									if(base==-self.children().first().width()-parseInt(self.children().first().css("margin-right"), 10))
									{
										self.children().first().appendTo(self);
										self.css("left", (parseInt(self.css("left"), 10)-base)+"px");
									}
									self.trigger("nextPage");
									base = "x";
								}
							}
						}
					});
				}
			}
		});
	});
	//our-clients
	$(".our-clients-list:not('.type-list')").each(function(index){
		$(this).addClass("cm-preloader_" + index);
		$(".cm-preloader_" + index).before("<span class='cm-preloader'></span>");
		$(".cm-preloader_" + index).imagesLoaded(function(){
			$(".cm-preloader_" + index).prev(".cm-preloader").remove();
			$(".cm-preloader_" + index).fadeTo("slow", 1, function(){
				$(this).css("opacity", "");
			});
			var self = $(".cm-preloader_" + index);
			self.carouFredSel({
				items: {
					visible: ($(".header").width()>750 ? 5 : ($(".header").width()>462 ? 4 : ($(".header").width()>300 ? 3 : 2)))
				},
				scroll: {
					items: ($(".header").width()>750 ? 5 : ($(".header").width()>462 ? 4 : ($(".header").width()>300 ? 3 : 2))),
					easing: "easeInOutQuint",
					duration: 750
				},
				auto: {
					play: false
				},
				pagination: {
					items: ($(".header").width()>750 ? 5 : ($(".header").width()>462 ? 4 : ($(".header").width()>300 ? 3 : 2))),
					container: $(self).next()
				}
			});
			var base = "x";
			var scrollOptions = {
				scroll: {
					easing: "easeInOutQuint",
					duration: 750
				}
			};
			self.swipe({
				fallbackToMouseEvents: true,
				allowPageScroll: "vertical",
				excludedElements:"button, input, select, textarea, .noSwipe",
				swipeStatus: function(event, phase, direction, distance, fingerCount, fingerData ) {
					//if(!self.is(":animated") && (!$(".control-for-" + self.attr("id")).length || ($(".control-for-" + self.attr("id")).length && !$(".control-for-" + self.attr("id")).is(":animated"))))
					if(!self.is(":animated"))
					{
						self.trigger("isScrolling", function(isScrolling){
							if(!isScrolling)
							{
								if (phase == "move" && (direction == "left" || direction == "right")) 
								{
									if(base=="x")
									{
										self.trigger("configuration", scrollOptions);
										self.trigger("pause");
									}
									if (direction == "left") 
									{
										if(base=="x")
											base = 0;
										self.css("left", parseInt(base, 10)-distance + "px");
									} 
									else if (direction == "right") 
									{	
										if(base=="x" || base==0)
										{
											self.children().last().prependTo(self);
											base = -self.children().first().width()-parseInt(self.children().first().css("margin-right"), 10);
										}
										self.css("left", base+distance + "px");
									}

								} 
								else if (phase == "cancel") 
								{
									if(distance!=0)
									{
										self.trigger("play");
										self.animate({
											"left": base + "px"
										}, 750, "easeInOutQuint", function(){
											if(base==-self.children().first().width()-parseInt(self.children().first().css("margin-right"), 10))
											{
												self.children().first().appendTo(self);
												self.css("left", "0px");
												base = "x";
											}
											self.trigger("configuration", {scroll: {
												easing: "easeInOutQuint",
												duration: 750
											}});
										});
									}
								} 
								else if (phase == "end") 
								{
									self.trigger("play");
									if (direction == "right") 
									{
										self.trigger("prevPage");
										self.children().first().appendTo(self);
										self.animate({
											"left": 0 + "px"
										}, 200, "linear", function(){
											self.trigger("configuration", {scroll: {
												easing: "easeInOutQuint",
												duration: 750
											}});
											base = "x";
										});
									} 
									else if (direction == "left") 
									{
										if(base==-self.children().first().width()-parseInt(self.children().first().css("margin-right"), 10))
										{
											self.children().first().appendTo(self);
											self.css("left", (parseInt(self.css("left"), 10)-base)+"px");
										}
										self.trigger("nextPage");
										self.trigger("configuration", {scroll: {
											easing: "easeInOutQuint",
											duration: 750
										}});
										base = "x";
									}
								}
							}
						});
					}
				}
			});
		});
	});
	
	//horizontal carousel
	var horizontalCarousel = function()
	{
		$(".horizontal-carousel").each(function(index){
			$(this).addClass("cm-preloader-hr-carousel_" + index);
			$(".cm-preloader-hr-carousel_" + index).before("<span class='cm-preloader'></span>");
			$(".cm-preloader-hr-carousel_" + index).imagesLoaded(function(instance){
				$(".cm-preloader-hr-carousel_" + index).prev(".cm-preloader").remove();
				$(".cm-preloader-hr-carousel_" + index).fadeTo("slow", 1, function(){
					$(this).css("opacity", "");
				});
				
				//caroufred
				var visible = 3;
				var autoplay = 0;
				var pause_on_hover = 0;
				var scroll = 3;
				var effect = "scroll";
				var easing = "easeInOutQuint";
				var duration = 750;
				var navigation = 1;
				var control_for = "";
				var elementClasses = $(".cm-preloader-hr-carousel_" + index).attr('class').split(' ');
				for(var i=0; i<elementClasses.length; i++)
				{
					if(elementClasses[i].indexOf('visible-')!=-1)
						visible = elementClasses[i].replace('visible-', '');
					if(elementClasses[i].indexOf('autoplay-')!=-1)
						autoplay = elementClasses[i].replace('autoplay-', '');
					if(elementClasses[i].indexOf('pause_on_hover-')!=-1)
						pause_on_hover = elementClasses[i].replace('pause_on_hover-', '');
					if(elementClasses[i].indexOf('scroll-')!=-1)
						scroll = elementClasses[i].replace('scroll-', '');
					if(elementClasses[i].indexOf('effect-')!=-1)
						effect = elementClasses[i].replace('effect-', '');
					if(elementClasses[i].indexOf('easing-')!=-1)
						easing = elementClasses[i].replace('easing-', '');
					if(elementClasses[i].indexOf('duration-')!=-1)
						duration = elementClasses[i].replace('duration-', '');
					if(elementClasses[i].indexOf('navigation-')!=-1)
						navigation = elementClasses[i].replace('navigation-', '');
					/*if(elementClasses[i].indexOf('threshold-')!=-1)
						var threshold = elementClasses[i].replace('threshold-', '');*/
					if(elementClasses[i].indexOf('control-for-')!=-1)
						control_for = elementClasses[i].replace('control-for-', '');
				}
				if($(".header").width()<=462)
					scroll = 1;
				else if(parseInt(scroll, 10)>3)
					scroll = 3;
				
				var self = $(".cm-preloader-hr-carousel_" + index);
				var length = self.children().length;
				self.data("scroll", scroll);
				if(length<parseInt(visible, 10))
					visible = length;
				var carouselOptions = {
					items: {
						start: 0,
						visible: parseInt(scroll, 10)
					},
					scroll: {
						items: parseInt(scroll, 10),
						fx: effect,
						easing: easing,
						duration: parseInt(duration, 10),
						pauseOnHover: (parseInt(pause_on_hover, 10) ? true : false),
						onAfter: function(){
							$(this).trigger('configuration', [{scroll :{
								easing: "easeInOutQuint",
								duration: 750
							}}, true]);
						}
					},
					auto: {
						items: parseInt(scroll, 10),
						play: (parseInt(autoplay, 10) ? true : false),
						fx: effect,
						easing: easing,
						duration: parseInt(duration, 10),
						pauseOnHover: (parseInt(pause_on_hover, 10) ? true : false),
						onAfter: null
					},
					pagination: {
						items: parseInt(scroll, 10),
						container: $(self).next()
					}
				};
				self.carouFredSel(carouselOptions,{
					wrapper: {
						classname: "caroufredsel-wrapper"
					}
				});
				var base = "x";
				var scrollOptions = {
					scroll: {
						easing: "linear",
						duration: 200
					}
				};
				self.swipe({
					fallbackToMouseEvents: true,
					allowPageScroll: "vertical",
					excludedElements:"button, input, select, textarea, .noSwipe",
					swipeStatus: function(event, phase, direction, distance, fingerCount, fingerData ) {
						//if(!self.is(":animated") && (!$(".control-for-" + self.attr("id")).length || ($(".control-for-" + self.attr("id")).length && !$(".control-for-" + self.attr("id")).is(":animated"))))
						if(!self.is(":animated"))
						{
							self.trigger("isScrolling", function(isScrolling){
								if(!isScrolling)
								{
									if (phase == "move" && (direction == "left" || direction == "right")) 
									{
										if(base=="x")
										{
											self.trigger("configuration", scrollOptions);
											self.trigger("pause");
										}
										if (direction == "left") 
										{
											if(base=="x")
												base = 0;
											self.css("left", parseInt(base, 10)-distance + "px");
										} 
										else if (direction == "right") 
										{	
											if(base=="x" || base==0)
											{
												//self.children().last().prependTo(self);
												self.children().slice(-self.data("scroll")).prependTo(self);
												base = -self.data("scroll")*self.children().first().width()-self.data("scroll")*parseInt(self.children().first().css("margin-right"), 10);
											}
											self.css("left", base+distance + "px");
										}

									} 
									else if (phase == "cancel") 
									{
										if(distance!=0)
										{
											self.trigger("play");
											self.animate({
												"left": base + "px"
											}, 750, "easeInOutQuint", function(){
												if(base==-self.data("scroll")*self.children().first().width()-self.data("scroll")*parseInt(self.children().first().css("margin-right"), 10))
												{
													//self.children().first().appendTo(self);
													self.children().slice(0, self.data("scroll")).appendTo(self);
													self.css("left", "0px");
													base = "x";
												}
												self.trigger("configuration", {scroll: {
													easing: "easeInOutQuint",
													duration: 750
												}});
											});
										}
									} 
									else if (phase == "end") 
									{
										self.trigger("play");
										if (direction == "right") 
										{
											self.trigger('ql_set_page_nr', self.data("scroll"));
											self.animate({
												"left": 0 + "px"
											}, 200, "linear", function(){
												self.trigger("configuration", {scroll: {
													easing: "easeInOutQuint",
													duration: 750
												}});
												base = "x";
											});
										} 
										else if (direction == "left") 
										{
											if(base==-self.children().first().width()-parseInt(self.children().first().css("margin-right"), 10))
											{
												self.children().first().appendTo(self);
												self.css("left", (parseInt(self.css("left"), 10)-base)+"px");
											}
											self.trigger("nextPage");
											self.trigger("configuration", {scroll: {
												easing: "easeInOutQuint",
												duration: 750
											}});
											base = "x";
										}
									}
								}
							});
						}
					}
				});
			});
		});
	};
	horizontalCarousel();
	
	//counters
	var counters = function()
	{
		$(".counters-group").each(function(){
			var groupHeight = $(this).height();
			var topValue = 0, currentValue = 0;
			var counterBoxes = $(this).find(".counter-box")
			counterBoxes.each(function(index){
				var self = $(this);
				if(self.find("[data-value]").length)
				{
					currentValue = parseInt(self.find("[data-value]").data("value").toString().replace(" ",""), 10);
					if(currentValue>topValue)
						topValue = currentValue;
				}
			});
			var height = 83/groupHeight*100; //var height = 0/groupHeight*100;
			counterBoxes.each(function(index){
				var self = $(this);
				currentValue = parseInt(self.find("[data-value]").data("value").toString().replace(" ",""), 10);
				height = 83*(1-currentValue/topValue)/groupHeight*100; //height = 0*(1-currentValue/topValue)/groupHeight*100;
				self.find(".ornament-container").css("height", currentValue/topValue*100+height + "%");
			});
		});
		$(".single-counter-box").each(function(){
			var value = $(this).find("[data-value]");
			if(value.length)
				$(this).find(".ornament-container").css("width", "calc(" + value.data("value").toString().replace(" ","") + "%" + " - 10px)");
		});
	}
	counters();
	
	//accordion
	$(".accordion").accordion({
		event: 'change',
		heightStyle: 'content',
		icons: {"header": "template-plus", "activeHeader": "template-minus"},
		/*active: false,
		collapsible: true*/
		create: function(event, ui){
			$(window).trigger('resize');
			$(".horizontal_carousel").trigger('configuration', ['debug', false, true]);
		}
	});
	$(".accordion.wide").on("accordionchange", function(event, ui){
		$("html, body").animate({scrollTop: $("#"+$(ui.newHeader).attr("id")).offset().top}, 400);
	});
	$(".tabs:not('.no-scroll')").on("tabsbeforeactivate", function(event, ui){
		$("html, body").animate({scrollTop: $("#"+$(ui.newTab).children("a").attr("id")).offset().top}, 400);
	});
	$(".tabs").tabs({
		event: 'change',
		show: 200,
		hide: 200,
		create: function(){
			$("html, body").scrollTop(0);
		},
		activate: function(event, ui){
			ui.oldPanel.find(".submit-contact-form, [name='submit'], [name='name'], [name='email'], [name='message']").qtip('hide');
		}
	});
	
	//browser history
	$(".tabs .ui-tabs-nav a").on("click", function(){
		if($(this).attr("href").substr(0,4)!="http")
			$.bbq.pushState($(this).attr("href"));
		else
			window.location.href = $(this).attr("href");
	});
	$(".ui-accordion .ui-accordion-header").on("click", function(){
		$.bbq.pushState("#" + $(this).attr("id").replace("accordion-", ""));
	});
	
	$(".scroll-to-comments").on("click", function(event){
		event.preventDefault();
		var offset = $("#comments-list").offset();
		if(typeof(offset)!="undefined")
			$("html, body").animate({scrollTop: offset.top-90}, 400);
	});
	$(".scroll-to-comment-form").on("click", function(event){
		event.preventDefault();
		var offset = $("#comment-form").offset();
		if(typeof(offset)!="undefined")
			$("html, body").animate({scrollTop: offset.top-90}, 400);
	});
	//hashchange
	$(window).on("hashchange", function(event){
		var hashSplit = $.param.fragment().split("-");
		var hashString = "";
		for(var i=0; i<hashSplit.length-1; i++)
			hashString = hashString + hashSplit[i] + (i+1<hashSplit.length-1 ? "-" : "");
		if(hashSplit[0].substr(0,11)!="prettyPhoto")
		{
			if(hashSplit[0].substr(0,7)!="filter=")
			{
				$('.ui-accordion .ui-accordion-header#accordion-' + decodeURIComponent($.param.fragment())).trigger("change");
				$('.ui-accordion .ui-accordion-header#accordion-' + decodeURIComponent(hashString)).trigger("change");
			}
			$('.tabs .ui-tabs-nav [href="#' + decodeURIComponent(hashString) + '"]').trigger("change");
			$('.tabs .ui-tabs-nav [href="#' + decodeURIComponent($.param.fragment()) + '"]').trigger("change");
			if(hashSplit[0].substr(0,7)!="filter=")
				$('.tabs .ui-accordion .ui-accordion-header#accordion-' + decodeURIComponent($.param.fragment())).trigger("change");
			$(".testimonials-carousel, .our-clients-list:not('.type-list')").trigger('configuration', ['debug', false, true]);
			$(document).scroll();
		}
		if(hashSplit[0].substr(0,7)=="comment")
		{
			if($(location.hash).length)
			{
				var offset = $(location.hash).offset();
				$("html, body").animate({scrollTop: offset.top-90}, 400);
			}
		}
		
		// get options object from hash
		var hashOptions = $.deparam.fragment();

		if(hashSplit[0].substr(0,7)=="filter")
		{
			var filterClass = decodeURIComponent($.param.fragment()).substr(7, decodeURIComponent($.param.fragment()).length);
			// apply options from hash
			$(".isotope-filters a").removeClass("selected");
			if($('.isotope-filters a[href="#filter-' + filterClass + '"]').length)
				$('.isotope-filters a[href="#filter-' + filterClass + '"]').addClass("selected");
			else
				$(".isotope-filters li:first a").addClass("selected");
			
			$(".isotope").isotope({filter: (filterClass!="*" ? "." : "") + filterClass});
		}
	}).trigger("hashchange");
	
	$('body.dont-scroll').on("touchmove", {}, function(event){
	  event.preventDefault();
	});
	
	if($("#map").length && typeof(google)!="undefined")
	{
		//google map
		var coordinate = new google.maps.LatLng(($("#map").data("map-center-lat") ? $("#map").data("map-center-lat") : 45.4005763), ($("#map").data("map-center-lng") ? $("#map").data("map-center-lng") : -75.6837527));
		var mapOptions = {
			zoom: 16,
			center: coordinate,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			streetViewControl: false,
			mapTypeControl: false,
			scrollwheel: parseInt($("#map").data("scroll-wheel"), 10),
			draggable: parseInt($("#map").data("draggable"), 10)/*,
			styles: [ { "featureType": "water", "elementType": "geometry", "stylers": [ { "color": "#8ccaf1" } ] },{ "featureType": "poi", "stylers": [ { "visibility": "off" } ] },{ "featureType": "transit", "stylers": [ { "visibility": "off" } ] },{ "featureType": "water", "elementType": "labels", "stylers": [ { "color": "#ffffff" }, { "visibility": "simplified" } ] } ]*/
		};
		
		map = new google.maps.Map(document.getElementById("map"),mapOptions);
		marker = new google.maps.Marker({
			position: new google.maps.LatLng(($("#map").data("marker-lat") ? $("#map").data("marker-lat") : 45.4005763), ($("#map").data("marker-lng") ? $("#map").data("marker-lng") : -75.6837527)),
			map: map,
			icon: new google.maps.MarkerImage("images/map_pointer.png", new google.maps.Size(100, 60), null, new google.maps.Point(50, 60))
		});
	}
	
	//window resize
	function windowResize()
	{
		if(map!=null)
			map.setCenter(coordinate);
		$(".testimonials-carousel").trigger('configuration', ['debug', false, true]);

		if($(".cm-smart-column").length && $(".header").width()>462)
		{
			var topOfWindow = $(window).scrollTop();
			$(".cm-smart-column").each(function(){
				var row = $(this).parent();
				var wrapper = $(this).children().first();
				var childrenHeight = 0;
				wrapper.children().each(function(){
					childrenHeight += $(this).outerHeight(true);
				});
				if(childrenHeight<$(window).height() && row.offset().top-20<topOfWindow && row.offset().top-20+row.outerHeight()-childrenHeight>topOfWindow)
				{
					wrapper.css({"position": "fixed", "bottom": "auto", "top": "20px", "width": $(this).width() + "px"});
					$(this).css({"height": childrenHeight+"px"});
				}
				else if(childrenHeight<$(window).height() && row.offset().top-20+row.outerHeight()-childrenHeight<=topOfWindow && (row.outerHeight()-childrenHeight>0))
				{
					wrapper.css({"position": "absolute", "bottom": "0", "top": (row.outerHeight()-childrenHeight) + "px", "width": "auto"});
					$(this).css({"height": childrenHeight+"px"});
				}
				else if(childrenHeight>=$(window).height() && row.offset().top+20+childrenHeight<topOfWindow+$(window).height() && row.offset().top+20+row.outerHeight()>topOfWindow+$(window).height())
				{	
					wrapper.css({"position": "fixed", "bottom": "20px", "top": "auto", "width": $(this).width() + "px"});
					$(this).css({"height": childrenHeight+"px"});
				}
				else if(childrenHeight>=$(window).height() && row.offset().top+20+row.outerHeight()<=topOfWindow+$(window).height() && (row.outerHeight()-childrenHeight>0))
				{
					wrapper.css({"position": "absolute", "bottom": "0", "top": (row.outerHeight()-childrenHeight) + "px", "width": "auto"});
					$(this).css({"height": childrenHeight+"px"});
				}
				else
				{
					wrapper.css({"position": "static", "bottom": "auto", "top": "auto", "width": "auto"});
					$(this).css({"height": childrenHeight + "px"});
				}
			});
		}
		$(".horizontal-carousel").each(function(){
			var self = $(this);
			self.data("scroll", ($(".header").width()>462 ? 3 : 1));
			self.trigger("configuration", {
				items: {
					visible: self.data("scroll")
				},
				scroll: {
					items: self.data("scroll")
				},
				pagination: {
					items: self.data("scroll")
				}
			});
		});
		$(".our-clients-list:not('.type-list')").each(function(){
			var self = $(this);
			self.trigger("configuration", {
				items: {
					visible: ($(".header").width()>750 ? 5 : ($(".header").width()>462 ? 4 : ($(".header").width()>300 ? 3 : 2)))
				},
				scroll: {
					items: ($(".header").width()>750 ? 5 : ($(".header").width()>462 ? 4 : ($(".header").width()>300 ? 3 : 2)))
				},
				pagination: {
					items: ($(".header").width()>750 ? 5 : ($(".header").width()>462 ? 4 : ($(".header").width()>300 ? 3 : 2)))
				}
			});
		});
		if($(".header").width()>300)
		{
			if(!$(".header-top-bar").is(":visible"))
				$(".header-toggle").trigger("click");
		}
		if($(".sticky").length)
		{
			if($(".header-container").hasClass("sticky"))
				menu_position = $(".header-container").offset().top;
			var topOfWindow = $(window).scrollTop();
			/*if(menu_position!=null && $(".header-container .sf-menu").is(":visible"))
			{
				if(menu_position<topOfWindow)
				{
					if(!$("#cm-sticky-clone").length)
					{
						var attachAfter = $(".header-container");
						if($(".transparent-header-container").length)
							attachAfter = $(".header-container").parent();
						//attachAfter.after($(".header-container").clone().attr("id", "cm-sticky-clone").addClass("move"));
						$(".template-search").off("click");
						$(".template-search").on("click", function(event){
							event.preventDefault();
							$(this).parent().children(".search").toggle();
						});
					}
				}
				else
				{
					//$("#cm-sticky-clone").remove();
				}
			}
			//else
				//$("#cm-sticky-clone").remove();*/
				
			if(menu_position!=null && $(".header-container .sf-menu").is(":visible"))
			{
				if($(".transparent-header-container").length)
					modificator = 7;
				if(menu_position+modificator<topOfWindow)
				{
					if(!$("#cm-sticky-clone").hasClass("move"))
					{
						$("#cm-sticky-clone").addClass("move");
						if($(".transparent-header-container").length)
						{
							$('.header-container.sticky:not("#cm-sticky-clone")').css("visibility", "hidden");
							setTimeout(function(){
								if($("#cm-sticky-clone").hasClass("move"))
									$("#cm-sticky-clone").addClass("disable-transition");
							}, 300);
						}
						else
							$(".header-container").addClass("transition");
						$(".template-search").off("click");
						$(".template-search").on("click", function(event){
							event.preventDefault();
							$(this).parent().children(".search").toggle();
						});
					}
				}
				else
				{
					$("#cm-sticky-clone").removeClass("move");
					if($(".transparent-header-container").length)
					{
						$('.header-container.sticky:not("#cm-sticky-clone")').css("visibility", "visible");
						$("#cm-sticky-clone").removeClass("disable-transition");
					}
					else
						$(".header-container").removeClass("transition");
				}
			}
			else
			{
				$("#cm-sticky-clone").removeClass("move");
				if($(".transparent-header-container").length)
				{
					$('.header-container.sticky:not("#cm-sticky-clone")').css("visibility", "visible");
					$("#cm-sticky-clone").removeClass("disable-transition");
				}
				else
					$(".header-container").removeClass("transition");
			}
		}
	}
	$(window).resize(windowResize);
	window.addEventListener('orientationchange', windowResize);	
	
	//timeago
	$("abbr.timeago").timeago();
	
	//scroll top
	$("a[href='#top']").on("click", function() {
		$("html, body").animate({scrollTop: 0}, 1200, 'easeInOutQuint');
		return false;
	});
	
	//hint
	$(".search input[type='text'], .search-form input[type='text'], .cost-calculator-container input[placeholder]:not('.cost-slider-datepicker')").hint();
	
	//reply scroll
	$(".comment-details .more").on("click", function(event){
		event.preventDefault();
		var offset = $("#comment-form").offset();
		$("html, body").animate({scrollTop: offset.top-90}, 400);
		$("#cancel-comment").css('display', 'inline');
	});
	
	//cancel comment button
	$("#cancel-comment").on("click", function(event){
		event.preventDefault();
		$(this).css('display', 'none');
	});
	
	//fancybox
	$(".prettyPhoto").prettyPhoto({
		show_title: false,
		slideshow: 3000,
		overlay_gallery: true,
		social_tools: ''
	});
	$("[rel^='prettyPhoto']").prettyPhoto({
		show_title: false,
		slideshow: 3000,
		overlay_gallery: true,
		social_tools: ''
	});
	
	
	$(".submit-comment-form").on("click", function(event){
		event.preventDefault();
		$("#comment-form").submit();
	});
	
	//cost calculator form
	if($("form.cost-calculator-container").length)
	{
		$("form.cost-calculator-container").each(function(){
			$(this)[0].reset();
			$(this).find("input[type='hidden']").each(function(){
				if(typeof($(this).data("default"))!="undefined")
					$(this).val($(this).data("default"));
			});
			$(this).find(".cost-calculator-price").costCalculator("calculate");
		});
	}
	$(".prevent-submit").on("submit", function(event){
		event.preventDefault();
		return false;
	});
	//contact form
	if($(".contact-form").length)
	{
		$(".contact-form").each(function(){
			$(this)[0].reset();
			$(this).find("input[type='hidden']").each(function(){
				if(typeof($(this).data("default"))!="undefined")
					$(this).val($(this).data("default"));
			});
			$(this).find(".cost-calculator-price").costCalculator("calculate");
		});
		$(".submit-contact-form").on("click", function(event){
			event.preventDefault();
			$("#contact-form").submit();
		});
	}
	$(".contact-form").submit(function(event){
		event.preventDefault();
		var data = $(this).serializeArray();
		var self = $(this);
		//if($(this).find(".total-cost").length)
		//	data.push({name: 'total-cost', value: $(this).find(".total-cost").val()});
		self.find(".block").block({
			message: false,
			overlayCSS: {
				opacity:'0.3',
				"backgroundColor": "#FFF"
			}
		});
		
		$.ajax({
			url: self.attr("action"),
			data: data,
			type: "post",
			dataType: "json",
			success: function(json){
				self.find(".submit-contact-form, [name='submit'], [name='name'], [name='email'], [name='message']").qtip('destroy');
				if(typeof(json.isOk)!="undefined" && json.isOk)
				{
					if(typeof(json.submit_message)!="undefined" && json.submit_message!="")
					{
						self.find(".submit-contact-form").qtip(
						{
							style: {
								classes: 'ui-tooltip-success'
							},
							content: { 
								text: json.submit_message 
							},
							position: { 
								my: "right center",
								at: "left center" 
							}
						}).qtip('show');
						self[0].reset();
						self.find(".cost-slider-input").trigger("change");
						self.find(".cost-dropdown").selectmenu("refresh");
						self.find("input[type='text'], textarea").trigger("focus").trigger("blur");
					}
				}
				else
				{
					if(typeof(json.submit_message)!="undefined" && json.submit_message!="")
					{
						self.find(".submit-contact-form").qtip(
						{
							style: {
								classes: 'ui-tooltip-error'
							},
							content: { 
								text: json.submit_message 
							},
							position: { 
								my: "right center",
								at: "left center" 
							}
						}).qtip('show');
					}
					if(typeof(json.error_name)!="undefined" && json.error_name!="")
					{
						self.find("[name='name']").qtip(
						{
							style: {
								classes: 'ui-tooltip-error'
							},
							content: { 
								text: json.error_name 
							},
							position: { 
								my: "bottom center",
								at: "top center" 
							}
						}).qtip('show');
					}
					if(typeof(json.error_email)!="undefined" && json.error_email!="")
					{
						self.find("[name='email']").qtip(
						{
							style: {
								classes: 'ui-tooltip-error'
							},
							content: { 
								text: json.error_email 
							},
							position: { 
								my: "bottom center",
								at: "top center" 
							}
						}).qtip('show');
					}
					if(typeof(json.error_message)!="undefined" && json.error_message!="")
					{
						self.find("[name='message']").qtip(
						{
							style: {
								classes: 'ui-tooltip-error'
							},
							content: { 
								text: json.error_message 
							},
							position: { 
								my: "bottom center",
								at: "top center" 
							}
						}).qtip('show');
					}
				}
				self.find(".block").unblock();
			}
		});
	});

	if($(".header-container").hasClass("sticky"))
	{
		menu_position = $(".header-container").offset().top;
		$(".header-container.sticky").after($(".header-container.sticky").clone().attr("id", "cm-sticky-clone"));
	}
	function animateElements()
	{
		$('.animated-element, .header-container.sticky:not("#cm-sticky-clone"), .cm-smart-column').each(function(){
			var elementPos = $(this).offset().top;
			var topOfWindow = $(window).scrollTop();
			var animationStart = (typeof($(this).data("animation-start"))!="undefined" ? parseInt($(this).data("animation-start"), 10) : 0);
			if($(this).hasClass("cm-smart-column"))
			{
				var row = $(this).parent();
				var wrapper = $(this).children().first();
				var childrenHeight = 0;
				wrapper.children().each(function(){
					childrenHeight += $(this).outerHeight(true);
				});
				if(childrenHeight<$(window).height() && row.offset().top-20<topOfWindow && row.offset().top-20+row.outerHeight()-childrenHeight>topOfWindow)
				{
					wrapper.css({"position": "fixed", "bottom": "auto", "top": "20px", "width": $(this).width() + "px"});
					$(this).css({"height": childrenHeight+"px"});
				}
				else if(childrenHeight<$(window).height() && row.offset().top-20+row.outerHeight()-childrenHeight<=topOfWindow && (row.outerHeight()-childrenHeight>0))
				{
					wrapper.css({"position": "absolute", "bottom": "0", "top": (row.outerHeight()-childrenHeight) + "px", "width": "auto"});
					$(this).css({"height": childrenHeight+"px"});
				}
				else if(childrenHeight>=$(window).height() && row.offset().top+20+childrenHeight<topOfWindow+$(window).height() && row.offset().top+20+row.outerHeight()>topOfWindow+$(window).height())
				{	
					wrapper.css({"position": "fixed", "bottom": "20px", "top": "auto", "width": $(this).width() + "px"});
					$(this).css({"height": childrenHeight+"px"});
				}
				else if(childrenHeight>=$(window).height() && row.offset().top+20+row.outerHeight()<=topOfWindow+$(window).height() && (row.outerHeight()-childrenHeight>0))
				{
					wrapper.css({"position": "absolute", "bottom": "0", "top": (row.outerHeight()-childrenHeight) + "px", "width": "auto"});
					$(this).css({"height": childrenHeight+"px"});
				}
				else
					wrapper.css({"position": "static", "bottom": "auto", "top": "auto", "width": "auto"});
			}
			else if($(this).hasClass("sticky"))
			{
				if(menu_position!=null && $(".header-container .sf-menu").is(":visible"))
				{
					if($(".transparent-header-container").length)
						modificator = 7;
					if(menu_position+modificator<topOfWindow)
					{
						if(!$("#cm-sticky-clone").hasClass("move"))
						{
							$("#cm-sticky-clone").addClass("move");
							if($(".transparent-header-container").length)
							{
								$(this).css("visibility", "hidden");
								setTimeout(function(){
									if($("#cm-sticky-clone").hasClass("move"))
										$("#cm-sticky-clone").addClass("disable-transition");
								}, 300);
							}
							else
								$(".header-container").addClass("transition");
							$(".template-search").off("click");
							$(".template-search").on("click", function(event){
								event.preventDefault();
								$(this).parent().children(".search").toggle();
							});
						}
					}
					else
					{
						$("#cm-sticky-clone").removeClass("move");
						if($(".transparent-header-container").length)
						{
							$(this).css("visibility", "visible");
							$("#cm-sticky-clone").removeClass("disable-transition");
						}
						else
							$(".header-container").removeClass("transition");
					}
				}
			}
			else if(elementPos<topOfWindow+$(window).height()-20-animationStart) 
			{
				if($(this).hasClass("number") && !$(this).hasClass("progress") && $(this).is(":visible"))
				{
					var self = $(this);
					self.addClass("progress");
					if(typeof(self.data("value"))!="undefined")
					{
						var value = parseFloat(self.data("value").toString().replace(" ",""));
						self.text(0);
						self.text(value);
					}
				}
				else if(!$(this).hasClass("progress"))
				{
					var elementClasses = $(this).attr('class').split(' ');
					var animation = "fadeIn";
					var duration = 600;
					var delay = 0;
					if($(this).hasClass("scroll-top"))
					{
						if(topOfWindow<$(document).height()/2)
						{
							if($(this).hasClass("fadeIn") || $(this).hasClass("fadeOut"))
								animation = "fadeOut";
							else
								animation = "";
							$(this).removeClass("fadeIn")
						}
						else
							$(this).removeClass("fadeOut")
					}
					for(var i=0; i<elementClasses.length; i++)
					{
						if(elementClasses[i].indexOf('animation-')!=-1)
							animation = elementClasses[i].replace('animation-', '');
						if(elementClasses[i].indexOf('duration-')!=-1)
							duration = elementClasses[i].replace('duration-', '');
						if(elementClasses[i].indexOf('delay-')!=-1)
							delay = elementClasses[i].replace('delay-', '');
					}
					$(this).addClass(animation);
					$(this).css({"animation-duration": duration + "ms"});
					$(this).css({"animation-delay": delay + "ms"});
					$(this).css({"transition-delay": delay + "ms"});
				}
			}
		});
	}
	setTimeout(animateElements, 1);
	$(window).scroll(animateElements);
});