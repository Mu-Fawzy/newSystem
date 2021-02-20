$(function() {

	// International Telephone Input
	var input = document.querySelector("#phone");
    window.intlTelInput(input, {
      utilsScript: "dashboard/assets/plugins/telephoneinput/utils.js",
    });
});

