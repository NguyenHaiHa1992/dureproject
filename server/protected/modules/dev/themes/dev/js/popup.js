function showPopUp(b,c) {
	var a = $(window).height();
	$("body").css("overflow", "hidden");
	$("."+b+".popup-wrapper").css("display", "block");
	$(".bg-overlay").css("display", "block")
}
function hidenPopUp(b) {
	$("body").css("overflow", "auto");
	$("."+b+".popup-wrapper").css("display", "none");
	$(".bg-overlay").css("display", "none")
}