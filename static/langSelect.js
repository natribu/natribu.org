(function(fn){
	if(document.readyState === "complete") return fn();
	document.addEventListener('DOMContentLoaded', fn)
})(function(){
	// Setup async language select
	var input = document.querySelector("header form [type=\"submit\"]");
	input.style.display = "none";
	input.onchange = function(e){
		input.disabled = true;
		var request = new XMLHttpRequest();
		request.open('GET', '/setlang?locale=' + input.value, true);
		request.onload = location.reload.bind();
		request.onerror = location.reload.bind();
		request.send();
	};
});