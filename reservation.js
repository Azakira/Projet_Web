/*<
$( document ).ready(function() {
    console.log( "ready!" );
	
	
}
			
});
*/

function hiddenDDL(){
	titre = document.getElementById("titre");
	selectedTitre = titre.options[titre.selectedIndex].value;
	
	
	for (let i = 1; i < titre.options.length; i++) {
		ddlId = titre.options[i].text; // car value=serialize($spectacleDDL)
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

function hiddenDDL2(){
	titre = document.getElementById("titre");
	selectedTitre = titre.options[titre.selectedIndex].value;	
	
	for (let i = 1; i < titre.options.length; i++) {
		ddlId = titre.options[i].value;
		node = document.getElementById(ddlId);
		if (ddlId == selectedTitre){
			node.style.visibility = "visible";
			node.style.height = "auto";
			if(typeof callCount == 'undefined'){
				callCount = 0;
			} else {
				ddl = document.getElementById(i);
				ddl.selectedIndex = 0;
				selectSpec(ddl.options[ddl.selectedIndex].value);
				callCount++;
			}
		} else {
			node.style.visibility = "hidden";
			node.style.height = "0";
		}
		//console.log("ddlId= "+ddlId+"\nselTitre="+selectedTitre);
	}
}


function selectSpec(val){
	document.getElementById("spectacle").value = val;
	
}



function testJS(value){
	document.getElementById("test").innerHTML = ""+value;
	Console.log("testButton");
}

// $.ajax({
// 	url : 'panier.php',
// 	type : 'POST'

// });