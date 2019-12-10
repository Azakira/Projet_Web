$( document ).ready(function() {
    console.log( "ready!" );
	
	function hiddenDDL(){
	document.getElementById("test").innerHTML = "OK";
	titre = document.getElementById("titre");
	selectedTitre = titre.options[titre.selectedIndex].value;
	
	
	for (let i = 1; i < titre.options.length; i++) {
		ddlId = titre.options.[i].text; // car value=serialize($spectacleDDL)
		if (ddlId == selectedTitre){
			node = document.getElementById(ddlId);
			node.style.visibility = "visible";
			node.style.height = "auto";
		} else {
			node.style.visibility = "hidden";
			node.style.height = "0";
		}
	}
}

	function testJS(){
		document.getElementById("test").innerHTML = 100;
		
		$("#testButton").click(testJS);
		Console.log("testButton");
	}
});


