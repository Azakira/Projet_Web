window.onload = function () {


getTabs();

    setTimeout(function () { 

	var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			title: {},
			
			toolTip: {
				shared: true
			},
		});
	
		PleinTarifCanvas()
		chart.render();
				
				
			
	function popUpPT(e){
	
		var  str = "<span style= \"color:"+e.entries[0].dataSeries.color + "\"> "+e.entries[0].dataSeries.name+"</span> : <strong>"+e.entries[0].dataPoint.y+"</strong> places<br/>";
		total = totPT(e.entries[0].dataPoint.y);
		str2 = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.label)+"</strong></span><br/>";
		str3 = "<span style = \"color:Tomato\">Total : </span><strong>"+total+"</strong>€<br/>";
		return (str2.concat(str)).concat(str3);
	}	
	
	function popUpTR(e){
	
		var  str = "<span style= \"color:"+e.entries[0].dataSeries.color + "\"> "+e.entries[0].dataSeries.name+"</span> : <strong>"+e.entries[0].dataPoint.y+"</strong> places<br/>";
		total = totTR(e.entries[0].dataPoint.y);
		str2 = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.label)+"</strong></span><br/>";
		str3 = "<span style = \"color:Tomato\">Total : </span><strong>"+total+"</strong>€<br/>";
		return (str2.concat(str)).concat(str3);
	}
	
	function popUpSJ(e){
	
		var  str = "<span style= \"color:"+e.entries[0].dataSeries.color + "\"> "+e.entries[0].dataSeries.name+"</span> : <strong>"+e.entries[0].dataPoint.y+"</strong> places<br/>";
		total = totSJ(e.entries[0].dataPoint.y);
		str2 = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.label)+"</strong></span><br/>";
		str3 = "<span style = \"color:Tomato\">Total : </span><strong>"+total+"</strong>€<br/>";
		return (str2.concat(str)).concat(str3);
	}
	
	function popUpSA(e){
	
		var  str = "<span style= \"color:"+e.entries[0].dataSeries.color + "\"> "+e.entries[0].dataSeries.name+"</span> : <strong>"+e.entries[0].dataPoint.y+"</strong> places<br/>";
		total = totSA(e.entries[0].dataPoint.y);
		str2 = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.label)+"</strong></span><br/>";
		str3 = "<span style = \"color:Tomato\">Total : </span><strong>"+total+"</strong>€<br/>";
		return (str2.concat(str)).concat(str3);
	}	
	
	function popUpRD(e){
	
		var  str1 = "<span style= \"color:"+e.entries[0].dataSeries.color + "\"> "+e.entries[0].dataSeries.name+"</span> : <strong>"+e.entries[0].dataPoint.y+"</strong> €<br/>";
		var  str2 = "<span style= \"color:"+e.entries[1].dataSeries.color + "\"> "+e.entries[1].dataSeries.name+"</span> : <strong>"+e.entries[1].dataPoint.y+"</strong> €<br/>";
		total = e.entries[0].dataPoint.y - e.entries[1].dataPoint.y ;
		str3 = "<span style = \"color:Tomato\">Total : </span><strong>"+total+"</strong>€<br/>";
		ville = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.label)+"</strong></span><br/>";
		return (ville.concat(str1.concat(str2))).concat(str3);
	}
	
	function popUpNoTot(e){
	
		var  str = "<span style= \"color:"+e.entries[0].dataSeries.color + "\"> "+e.entries[0].dataSeries.name+"</span> : <strong>"+e.entries[0].dataPoint.y+"</strong> places<br/>";
		str2 = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.label)+"</strong></span><br/>";
		return str2.concat(str);
	
	}
	
	//pour les Recettes et Depenses
	function popUpNoTot2(e){
	
		var  str = "<span style= \"color:"+e.entries[0].dataSeries.color + "\"> "+e.entries[0].dataSeries.name+"</span> : <strong>"+e.entries[0].dataPoint.y+"</strong> €<br/>";
		str2 = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.label)+"</strong></span><br/>";
		return str2.concat(str);
	
	}


//CALCUL DES GAINS ET DEPENSES D'UN SPECTACLE
	function totPT(nbBillets){
	
		return nbBillets*15*0.1;
		
	}
	
	function totTR(nbBillets){
	
		return nbBillets*10*0.1;
		
	}
	
	function totSJ(nbBillets){
	
		return nbBillets*12.5;
		
	}
	
	function totSA(nbBillets){
	
		return nbBillets*9;
		
	}





//MODIFICATION DU CANVAS SELON LE CHOIX DE L'UTILISATEUR
	function PleinTarifCanvas(){

		var donnees ={
				type: "column",
				name: "Nombre de billets",
	//			legendText: "Nombre de ticket",
	//			showInLegend: true, 
				dataPoints: tabP
				};
				
		chart.options.title.text="Nombre de billet Plein Tarif vendu par Spectacle";
		chart.options.data = [];
		chart.options.data.push(donnees);
		chart.options.toolTip.content = popUpPT;

		chart.render();
	}
	
	
	//Tarif Reduit
	function TarifReduitCanvas(){
	
		var donnees ={
				type: "column",
				name: "Nombre de billets",
				//legendText: "Nombre de ticket",
				//showInLegend: true, 
				dataPoints: tabR
			};
	
		chart.options.title.text="Nombre de billet Tarif Reduit vendu par Spectacle";
		chart.options.data = [];
		chart.options.data.push(donnees);
		chart.options.toolTip.content = popUpTR;
		chart.render();
	}
	
	
	//Tarif Enfant
	function TarifEnfantCanvas(){
	
		var donnees ={
				type: "column",
				name: "Nombre de billets",				
				dataPoints: tabE
			};
	
		chart.options.title.text="Nombre de billets Enfant vendu par Spectacle";
		chart.options.data = [];
		chart.options.data.push(donnees);
		chart.options.toolTip.content = popUpNoTot;
		chart.render();
	}
	
	
	//Offert
	function OffertCanvas(){
	
		var donnees ={
				type: "column",
				name: "Nombre de billet",
				dataPoints: tabO
			};
	
		chart.options.title.text="Nombre de billet Offert par Spectacle";
		chart.options.data = [];
		chart.options.data.push(donnees);
		chart.options.toolTip.content = popUpNoTot;
		chart.render();
	}
	
	
	//Tarif SJ
	function SJCanvas(){
	
		var donnees ={
				type: "column",
				name: "Nombre de billet",
				dataPoints: tabSJ
			};
	
		chart.options.title.text="Nombre de billet Tarif SJ payé par Spectacle";
		chart.options.data = [];
		chart.options.data.push(donnees);
		chart.options.toolTip.content = popUpSJ;
		chart.render();
	}
	
	
	//Tarif SJ
	function SACanvas(){
	
		var donnees ={
				type: "column",
				name: "Nombre de billet",
				dataPoints: tabSA
			};
	
		chart.options.title.text="Nombre de billet Tarif SA payé par Spectacle";
		chart.options.data = [];
		chart.options.data.push(donnees);
		chart.options.toolTip.content = popUpSA;
		chart.render();
	}
	
	
	function Recette(){

		var donnees ={
					type: "column",
					name: "Recette",
//					legendText: "Nombre de ticket",
					showInLegend: true, 
					dataPoints: tabRecette
				};
		chart.options.title.text="Recette du Festival";
		chart.options.data = [];
		chart.options.data.push(donnees);
		chart.options.toolTip.content = popUpNoTot2;
		chart.render();
	}
	
	
	//Depenses
	function Depenses(){

		var donnees ={
					type: "column",
					name: "Depenses",
//					legendText: "Nombre de ticket",
					showInLegend: true, 
					dataPoints: tabDepenses
				};
				
		chart.options.title.text="Depenses du Festival";
		chart.options.data = [];
		chart.options.data.push(donnees);
		chart.options.toolTip.content = popUpNoTot2;
		chart.render();
	}
	
	
	//Recette + Depenses
	function Recette_Depenses(){

		var recette ={
					type: "column",
					name: "Recette",
					legendText: "Recette",
					showInLegend: true, 
					dataPoints: tabRecette
				};
				
		var depenses ={
					type: "column",
					name: "Depenses",
					legendText: "Dépenses",
					showInLegend: true, 
					dataPoints: tabDepenses
				};
				
		chart.options.title.text="Recette et Depenses";
		chart.options.data = [];

		chart.options.data.push(recette);
		chart.options.data.push(depenses);
		chart.options.toolTip.content = popUpRD;		
		chart.render();
	}
	
	function changeAspect(){
		
		
		var recette ={
					type: "stackedColumn",
					name: "Recette",
					legendText: "Recette",
					showInLegend: true, 
					dataPoints: tabRecette
				};
				
		var depenses ={
					type: "stackedColumn",
					name: "Depenses",
					legendText: "Dépenses",
					showInLegend: true, 
					dataPoints: tabDepenses
				};
				
		chart.options.title.text="Recette et Depenses";
		chart.options.data = [];
		chart.options.data.push(recette);
		chart.options.data.push(depenses);
		chart.render();
	
	}
	


	
	
//Les Events listener de chaque bouton pour modifier les paramètres
//Tarif Enfant
document.getElementById('enfant').addEventListener('click', function(){
	console.log('click');
	TarifEnfantCanvas();
	document.getElementById('Change').hidden=true;
});

//Plein Tarif
document.getElementById('PleinTarif').addEventListener('click', function(){
	console.log('click');
	PleinTarifCanvas();
	document.getElementById('Change').hidden=true;
});

//Tarif Reduit
document.getElementById('TarifReduit').addEventListener('click', function(){
	console.log('click');
	TarifReduitCanvas();
	document.getElementById('Change').hidden=true;
});


//Tarif SJ
document.getElementById('Sj').addEventListener('click', function(){
	console.log('click');
	SJCanvas();
	document.getElementById('Change').hidden=true;
});

//Tarif SA
document.getElementById('Sa').addEventListener('click', function(){
	console.log('click');
	SACanvas();
	document.getElementById('Change').hidden=true;
});

//Offert
document.getElementById('Offert').addEventListener('click', function(){
	console.log('click');
	OffertCanvas();
	document.getElementById('Change').hidden=true;
});

//Recette
document.getElementById('Recette').addEventListener('click', function(){
	console.log('click');
	Recette();
	document.getElementById('Change').hidden=true;
});

//Depenses
document.getElementById('Depenses').addEventListener('click', function(){
	console.log('click');
	Depenses();
	document.getElementById('Change').hidden=true;
});

//Recette + Depenses
document.getElementById('Recette+Depenses').addEventListener('click', function(){
	console.log('click');
	document.getElementById('Change').hidden=false;
	Recette_Depenses();
});

var column = true;
document.getElementById('Change').addEventListener('click', function(){
	if(column){
		changeAspect();
		column = false;
	}else{
		Recette_Depenses();
		column = true;
	}
});	
	
	}, 100);
	
	
	
	
	
}

var tabP = [], tabR=[], tabO=[], tabSJ=[], tabSA=[], tabE=[], tabRecette=[], tabDepenses=[];

//P / R / O / SJ / SA / E






function getTabs(){

	
	$.getJSON('getCSV.php', function(data) {
		


	
        $.each(data, function(Titre, val) {  
         
			$.each(val, function(key2, val2){		                                         		
					if(key2 == 'P'){
						tabP.push({
							label: Titre,
							y: val2 //parfois on a val2 qui est un string donc on le convertit en Number
						});
					 }else if(key2 == 'R'){
						tabR.push({
							label: Titre,
							y: val2 //parfois on a val2 qui est un string donc on le convertit en Number
						});
	 				 }else if(key2 == 'O'){
						tabO.push({
							label: Titre,
							y: val2 //parfois on a val2 qui est un string donc on le convertit en Number
						});
					}else if(key2 == 'SJ'){
						tabSJ.push({
							label: Titre,
							y: val2 //parfois on a val2 qui est un string donc on le convertit en Number
					});
					}else if(key2 == 'SA'){
						tabSA.push({
							label: Titre,
							y: val2 //parfois on a val2 qui est un string donc on le convertit en Number
						});
					}else if(key2 == 'E'){
						tabE.push({
							label: Titre,
							y: val2 //parfois on a val2 qui est un string donc on le convertit en Number
						});
					}else if(key2 == 'Recette'){
						tabRecette.push({
							label: Titre,
							y: val2 //parfois on a val2 qui est un string donc on le convertit en Number
						});
					}else if(key2 == 'Depenses'){
						tabDepenses.push({
							label: Titre,
							y: val2 //parfois on a val2 qui est un string donc on le convertit en Number
						});
					}
	
        	});                            			
		});			
		
    });//getJson 
    
    setTimeout(function () {console.log(tabP); }, 100);
        console.log(tabP);

        
}        

