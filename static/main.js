(function(fn){
	// On DOM ready
	if(document.readyState === "complete") return fn();
	document.addEventListener("DOMContentLoaded", fn)
})(function(){
	// Load inlined JSON
	window.locale = JSON.parse(document.getElementById("js-locale").innerHTML);

	// Setup footer buttons
	Object.entries({
		goBack: function() {
			locale.goBack.forEach(window.alert || console.log)
		},
		addFavorite: function() {
			(window.alert || console.log)(window.locale.addFavorite);
			window.external.AddFavorite(location.toString())
		},
		setStartPage: function() {
			locale.setStartPage.forEach(window.alert || console.log);
			window.external.AddFavorite(location.toString())
		},
		sendNatribu: function() {
			locale.sendNatribu.forEach(window.alert || console.log);
			//window.location.href = "/editor/"
		}
	}).forEach(function(v) {
		var el = document.querySelector("a[data-id=\""+ v[0] +"\"]");
		if(!el) return console.warn("Button not found with data-id", v[0]);
		el.addEventListener("click", v[1])
	});
});
if("serviceWorker" in navigator) {
	window.addEventListener("load", function() {
		navigator.serviceWorker.register("./static/sw.js", { scope: "/" })
	})
}