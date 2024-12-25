let frequency = new Swiper('.frequency', {
	// Optional parameters
	speed:1500,
	spaceBetween:0,
	slidesPerView:1,
	direction: 'horizontal',
	loop: true,
	effect:'flip',
	//effect:'cards',
  
	// If we need pagination
	allowTouchMove:true,
	pagination: {
		el: '.swiper-pagination',
		clickable:true,
	},

	/*autoplay:{
		delay:4000,
		disableOnInteraction:false,
	},*/

	// Navigation arrows
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},

	// And if we need scrollbar
	scrollbar: {
		el: '.swiper-scrollbar',
	},
});

let accountAutomations = new Swiper('.account-automations', {
	// Optional parameters
	speed:1500,
	spaceBetween:0,
	slidesPerView:1,
	direction: 'horizontal',
	loop: true,
	effect:'flip',
	autoHeight: true,
	//effect:'cards',
  
	// If we need pagination
	allowTouchMove:true,
	pagination: {
		el: '.swiper-pagination',
		clickable:true,
	},

	autoplay:{
		delay:4000,
		disableOnInteraction:false,
	},

	// Navigation arrows
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	},

	// And if we need scrollbar
	scrollbar: {
		el: '.swiper-scrollbar',
	},
});