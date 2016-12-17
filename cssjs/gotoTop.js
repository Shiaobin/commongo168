
$(document).ready(function() {
    //在body结束前添加按钮
	$('body').append('<a href="#" class="back-to-top">回頂端</a>');

	//为按钮添加css样式
	$('.back-to-top').css({
		'position': 'fixed',
		'bottom': '2em',
		'left': '2em',
		'text-decoration': 'none',
		'color': '#EEEEEE',
		'background-color': 'rgba(0, 0, 0, 0.3)',
		'font-size': '12px',
		'padding': '1em',
		'display': 'none',
		'border-radius': '3px',
		'border': '1px solid #CCCCCC'
	});

	// 滚动窗口来判断按钮显示或隐藏
	$(window).scroll(function() {
		if ($(this).scrollTop() > 150) {
			$('.back-to-top').fadeIn(100);
		} else {
			$('.back-to-top').fadeOut(100);
		}
	});
	
	// jQuery实现动画滚动
	$('.back-to-top').click(function(event) {
		event.preventDefault();
		$('html, body').animate({scrollTop: 0}, 500);
	})
});