$(".deshabilitarCopiado").on("drop", function(event) {
	    event.preventDefault();  
	   	event.stopPropagation();
	    alert("¡No puede realizar esta acción! :(");
	});
	
	
	$('.deshabilitarCopiado').bind("cut copy paste",function(e) {
    	e.preventDefault();
    	alert("¡No puede realizar esta acción! :(");
    });