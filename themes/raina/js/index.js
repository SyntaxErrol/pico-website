let logo = document.querySelector(`h1 svg`);
let logoWidth = parseInt(getComputedStyle(logo).width);
addEventListener("resize", ev => logoWidth = parseInt(getComputedStyle(logo).width));

document.querySelectorAll(`rect`).forEach(el => {
	el.addEventListener("mouseenter", ev => {
		let xOff = (el.x.baseVal.value + .5) / logo.width.baseVal.value * logoWidth - ev.clientX;
		el.style.translate = xOff / 190 + "px";
		setTimeout(() => el.style.removeProperty("translate"), 200);
	});
});
