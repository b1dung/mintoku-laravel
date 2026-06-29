$(document).ready(function () {
	// menu
	$(".toggle-menu").click(function () {
		$("#header").toggleClass('active');
		$("body").toggleClass('no-scroll');
	});
	$(".menu .link").click(function () {
		$("#header").removeClass('active');
		$("body").removeClass('no-scroll');
	});

	// relate
	new Swiper('.relate-swiper', {
		slidesPerView: 1.005,
		spaceBetween: 11,
		breakpoints: {
			550: {
				slidesPerView: 1.5,
				spaceBetween: 40,
			},
			768: {
				slidesPerView: 2,
				spaceBetween: 40,
			},
			1024: {
				slidesPerView: 2.5,
				spaceBetween: 40,
			},
			1200: {
				slidesPerView: 3,
				spaceBetween: 40,
			},
			1700: {
				slidesPerView: 3.3,
				spaceBetween: 40,
			},
		}
	});

	$(window).scroll(function() {
		if ($(this).scrollTop() > 100) {
			$('#back-to-top').addClass('active');
		} else {
			$('#back-to-top').removeClass('active');
		}
	});

	$('#back-to-top').click(function() {
		$('html, body').animate({
			scrollTop: 0
		}, 600);
		return false;
	});

	$('.contact-fix-btn').click(function(){
		$('#contact-fix .content').toggleClass('active');
	})
});