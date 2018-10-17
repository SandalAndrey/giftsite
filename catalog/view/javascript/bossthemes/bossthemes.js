//var isMobile = /iPhone|iPod|iPad|Phone|Mobile|Android|hpwos/i.test(navigator.userAgent);
//var isPhone = /iPhone|iPod|Phone|Android/i.test(navigator.userAgent);
/* SHARED VARS */
var touch = false;
   
jQuery(document).ready(function($) {
  
	/* DETECT PLATFORM */
	$.support.touch = 'ontouchend' in document;
  
	if ($.support.touch) {
		touch = true;
		$('body').addClass('touch');
	}
	else{
		$('body').addClass('notouch');
	}
  
	$(".open-bt-mobile,.close-panel").click(function() {
		$('body').toggleClass('openNav');
	});
	
	$('.mega-menu .nav-pills li.parent > .plus').click(function() {
		if ($(this).hasClass('open')){
			$(this).removeClass('open').parent('li').children('.dropdown').slideUp(300);
			$(this).parent('li').removeClass('active');
		} else {
			$(this).addClass('open').parent('li').children('.dropdown').slideDown(300);
			$(this).parent('li').addClass('active');
		}  
		
	});
	
	$('#search .dropdown-toggle').click(function(e) {
		var dropdown = $(this).parents('.dropdown');
		var input = $('#search input[name="search"]');
		
		if ((dropdown.hasClass('open') || dropdown.filter(':hover').length) && input.val() != '') {
			$('#search button').trigger('click');
		}
	});
});
jQuery(function($) {
	$(document).ready(function() {
		// Product List
		$('#bt-list-view').click(function() {
			$('#bt-list-view, #bt-grid-view, #bt-grid-view-2, #bt-grid-view-3, #bt-grid-view-4, #bt-grid-view-6, #bt-table-view').removeClass('active');
			$('#bt-list-view').addClass('active');
			
			$('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');
			
			localStorage.setItem('bt_display', 'list');
		});
		
		// Product Grid
		$('#bt-grid-view').click(function() {
			$('#bt-list-view, #bt-grid-view, #bt-grid-view-2, #bt-grid-view-3, #bt-grid-view-4, #bt-grid-view-6, #bt-table-view').removeClass('active');
			$('#bt-grid-view').addClass('active');
			
			var cols = $('#column-right, #column-left').length;

			if (cols == 2) {
				$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
			} else if (cols == 1) {
				$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
			} else {
				$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
			}
			
			localStorage.setItem('bt_display', 'grid');
		});
		
		// Product Grid 2
		$('#bt-grid-view-2').click(function() {
			$('#bt-list-view, #bt-grid-view, #bt-grid-view-2, #bt-grid-view-3, #bt-grid-view-4, #bt-grid-view-6, #bt-table-view').removeClass('active');
			$('#bt-grid-view-2').addClass('active');
			
			$('#content .product-layout').attr('class', 'product-layout product-grid product-grid-2 col-lg-6 col-md-6 col-sm-6 col-xs-12');
			
			localStorage.setItem('bt_display', 'grid-2');
		});
		
		// Product Grid 3
		$('#bt-grid-view-3').click(function() {
			$('#bt-list-view, #bt-grid-view, #bt-grid-view-2, #bt-grid-view-3, #bt-grid-view-4, #bt-grid-view-6, #bt-table-view').removeClass('active');
			$('#bt-grid-view-3').addClass('active');
			
			$('#content .product-layout').attr('class', 'product-layout product-grid product-grid-3 col-lg-4 col-md-4 col-sm-6 col-xs-12');
			
			localStorage.setItem('bt_display', 'grid-3');
		});
		
		// Product Grid 4
		$('#bt-grid-view-4').click(function() {
			$('#bt-list-view, #bt-grid-view, #bt-grid-view-2, #bt-grid-view-3, #bt-grid-view-4, #bt-grid-view-6, #bt-table-view').removeClass('active');
			$('#bt-grid-view-4').addClass('active');
			
			$('#content .product-layout').attr('class', 'product-layout product-grid product-grid-4 col-lg-3 col-md-3 col-sm-6 col-xs-12');
			
			localStorage.setItem('bt_display', 'grid-4');
		});
		
		// Product Grid 6
		$('#bt-grid-view-6').click(function() {
			$('#bt-list-view, #bt-grid-view, #bt-grid-view-2, #bt-grid-view-3, #bt-grid-view-4, #bt-grid-view-6, #bt-table-view').removeClass('active');
			$('#bt-grid-view-6').addClass('active');
			
			$('#content .product-layout').attr('class', 'product-layout product-grid product-grid-6 col-lg-2 col-md-4 col-sm-6 col-xs-12');
			
			localStorage.setItem('bt_display', 'grid-6');
		});

		// Product Table
		$('#bt-table-view').click(function() {
			$('#bt-list-view, #bt-grid-view, #bt-grid-view-2, #bt-grid-view-3, #bt-grid-view-4, #bt-grid-view-6, #bt-table-view').removeClass('active');
			$('#bt-table-view').addClass('active');
			
			$('#content .product-layout').attr('class', 'product-layout product-table col-xs-12');
			
			localStorage.setItem('bt_display', 'table');
		})
		
		if (localStorage.getItem('bt_display') == 'table') {
			$('#bt-table-view').trigger('click');
		} else if (localStorage.getItem('bt_display') == 'grid'){
			$('#bt-grid-view').trigger('click');
		} else if (localStorage.getItem('bt_display') == 'grid-2'){
			$('#bt-grid-view-2').trigger('click');
		} else if (localStorage.getItem('bt_display') == 'grid-3'){
			$('#bt-grid-view-3').trigger('click');
		} else if (localStorage.getItem('bt_display') == 'grid-4'){
			$('#bt-grid-view-4').trigger('click');
		} else if (localStorage.getItem('bt_display') == 'grid-6'){
			$('#bt-grid-view-6').trigger('click');
		} else {
			$('#bt-list-view').trigger('click');
		}
	});
});
function resizeWidth(){
	if ($('html').attr('dir') == 'rtl') {
		var rtl = true;
	} else {
		var rtl = false;
	}
	
	$('.mega-menu ul > li.parent > div').each(function(index, element) {
		if ($(this).parents('.container').length) {
			var container = $(this).parents('.container').offset();
			var menu = $(this).parents('.mega-menu').offset();
			var dropdown = $(this).parent().offset();
			
			if (rtl) {
					var right = ($(this).outerWidth() - (dropdown.left + $(this).parent().outerWidth() - container.left) + 15);
					
					if (right > 0) {
							$(this).css({
								'margin-left': '',
								'margin-right': '-' + (right)+ 'px'
							});
					} else {
							$(this).css({
								'margin-left': '',
								'margin-right': '0px'
							});
					}
			} else {
				if (((dropdown.left - container.left)+$(this).width()) > parseFloat($(this).parents('.container').width())) {
					var balance = ((dropdown.left - container.left)+$(this).width()) - parseFloat($(this).parents('.container').width() - 30);
					
					var left = (dropdown.left - container.left)-15;
					
					if (balance > 0 && balance <= left) {
						$(this).css({
							'margin-left': '-' + (balance)+ 'px',
							'margin-right': ''
						});
					} else  if (balance > 0 && balance > left) {
						$(this).css({
							'margin-left': '-' + (left)+ 'px',
							'margin-right': ''
						});
					} else {
						$(this).css({
							'margin-left': '0px',
							'margin-right': ''
						});
					}
				}
			}
		}
	});
}
$(function() {
	var timer;
	
	$(window).resize(function() {
		clearTimeout(timer);
		timer = setTimeout(resizeWidth, 500);
	});
	
	resizeWidth();
});

var btadd = {
	'cart': function(product_id,quantity) {
		$.ajax({
			url: 'index.php?route=bossthemes/boss_add/cart/',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					addNotice(json, 'index.php?route=checkout/checkout');
					
					setTimeout(function () {
						$('#cart > button').html('<span id="cart-total">' + json['total'] + '</span>');
					}, 100);
				
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	},
	'wishlist': function(product_id) {
		$.ajax({
			url: 'index.php?route=bossthemes/boss_add/wishlist/',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					addNotice(json, 'index.php?route=account/wishlist');
					$('#wishlist-total').html(json['total']);
				} else {
					addNotice(json, 'index.php?route=account/wishlist');
					$('#wishlist-total').html(json['total']);
				}
			}
		});
	},
	'compare': function(product_id) {
		$.ajax({
			url: 'index.php?route=bossthemes/boss_add/compare',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					addNotice(json, 'index.php?route=product/compare');
					$('#compare-total').html(json['total']);
					$('#boss_compare').load('index.php?route=extension/module/boss_compare/info #boss_compare');
				}
			}
		});
	}
};

function addNotice(data, url) {
	$.jGrowl.defaults.closer = true;
	
	if (data['success']) {
		var tpl = '<h3>' + data['success'] + '</h3>';
	} else {
		var tpl = '<h3>' + data['error'] + '</h3>';
	}
	
	$.jGrowl(tpl, {
		life: 5000,
		btnGroup: '<div class="buttons"><a type="button" class="btn btn-default" href="index.php?route=common/home">' + data['button_continue'] + '</a><a type="button" class="btn btn-default" href="' + url + '">' + data['button_target'] + '</a></div>',
		header: data['title'],
		speed: 'slow'
	});
}

(function($){
	$.fn.equalHeights=function(minHeight,maxHeight){
		this.css('min-height', 'auto');
		
		tallest = (minHeight)?minHeight:0;
		
		this.each(function() {
			if($(this).outerHeight()>tallest){
				tallest = $(this).outerHeight()
			}
		});
		
		if((maxHeight)&&tallest>maxHeight) tallest = maxHeight;
		
		return this.each(function() {
			$(this).css('min-height', tallest)
		}
	)}
})(jQuery);

(function($){
	$.fn.btMobileMenu=function(html){
		var target = this.data('target');
		var index = $(target);
		var _this = this;
		
		if (!index.length) {
			index = $('<div/>', {
				id: target.replace('#',''),
				class: 'bt-mobile-menu'
			}).html(html);
			
			$('body').append(index);
		}
		
		if ($('header').length) {
			$('header').css({
				'position': 'relative',
				'z-index': (parseInt(index.css("z-index"))+1)
			});
		}
		
		_this.on('click', function() {
			if ($('header').length) {
				index.css('top', ($('header').offset().top + $('header').outerHeight()) + 'px');
			}
			
			if (_this.hasClass('is-open')) {
				$('body').removeClass('open-nav');
				_this.removeClass('is-open');
			} else {
				$('body').addClass('open-nav');
				_this.addClass('is-open');
			}
		});
		
		$('.close-menu', index).on('click', function(e) {
			e.preventDefault();
			$('body').removeClass('open-nav');
			_this.removeClass('is-open');
		});
		
		return this;
	}
})(jQuery);

(function($) {
	$.fn.onresize = function(handle) {
		return this.each(function() {
			var onresize = {
				obj: $(this),
				resizeTimer: null,
				checkResize: function() {
					var _this = this;
					clearTimeout(this.resizeTimer);
					this.resizeTimer = setTimeout(function() {
						if (_this.obj.data('width') != _this.obj.width() ||  _this.obj.data('height') != _this.obj.height()) {
							_this.obj.data('width', _this.obj.width());
							_this.obj.data('height', _this.obj.height());
							
							handle(_this.obj);
						}
						_this.checkResize();
					}, 100);
				},
				addListener: function() {
					var _this = this;
					this.obj.on('onresize', function(event){ handle(_this.obj); });
				},
				init: function() {
					this.obj.attr('data-width', this.obj.width()).attr('data-height', this.obj.height());
					this.addListener();
					this.checkResize();
				}
			}
			onresize.init();
		});
	};
})(jQuery);