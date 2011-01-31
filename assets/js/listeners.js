$(document).ready(function () {

	// Displays download options after clicking on download button
	$("#downloadButton").click(function (e) {
		$("#downloadOptions").slideToggle("fast");
		return false;
	});

});
