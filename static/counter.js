(function(fn){
	// On DOM ready
	if(document.readyState === "complete") return fn();
	document.addEventListener('DOMContentLoaded', fn)
})(function(){
    function update() {
        var request = new XMLHttpRequest();
        request.open('GET', 'counter.php', true);
        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                var counter = +this.response;
                if(!counter) return;
                document.querySelectorAll(".natribu-counter").forEach(function(el){
                    el.innerText = counter;
                });
            }
        };
        request.send();
    }
    setInterval(update, 1e4);
    update();
});