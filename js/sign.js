
(function() {
	var time  = 5;
	function go() {
		time = time-1;
		if(time > 0) {
			setTimeout(go, 1000);
		}else{
			window.location.href = "http://zanbai.com";  
		}
	}
	go();
})();