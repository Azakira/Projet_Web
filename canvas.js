window.onload = function () {

	getSpec();

	setTimeout(function () { 

	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		title: {},
		toolTip: {
				shared: true
		},	
	});
	canvasTarifPlein();
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


	//calcul gain de l'organisateur
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
	function canvasTarifPlein(){

		var donnees ={
				type: "column",
				name: "Nombre de billets",
				//legendText: "Nombre de ticket",
				//showInLegend: true, 
				dataPoints: tabP
				};
				
		chart.options.title.text="Nombre de billet Plein Tarif vendu par Spectacle";
		chart.options.data = [];
		chart.options.data.push(donnees);
		chart.options.toolTip.content = popUpPT;

		chart.render();
	}
	
	
	//Tarif Reduit
	function canvasTarifReduit(){
	
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
	function canvasTarifEnfant(){
	
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
	function canvasOffert(){
	
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
	function canvasSpecialeJ(){
	
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
	function canvasSpecialeA(){
	
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
	
	
	function recette(){

		var donnees ={
					type: "column",
					name: "Recette",
					//legendText: "Nombre de ticket",
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
	function depenses(){

		var donnees ={
					type: "column",
					name: "Depenses",
			        //legendText: "Nombre de ticket",
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
	function recetteTotale(){

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
		canvasTarifEnfant();
		document.getElementById('Change').hidden=true;
	});

	//Plein Tarif
	document.getElementById('PleinTarif').addEventListener('click', function(){
		console.log('click');
		canvasTarifPlein();
		document.getElementById('Change').hidden=true;
	});

	//Tarif Reduit
	document.getElementById('TarifReduit').addEventListener('click', function(){
		console.log('click');
		canvasTarifReduit();
		document.getElementById('Change').hidden=true;
	});


	//Tarif SJ
	document.getElementById('Sj').addEventListener('click', function(){
		console.log('click');
		canvasSpecialeJ();
		document.getElementById('Change').hidden=true;
	});

	//Tarif SA
	document.getElementById('Sa').addEventListener('click', function(){
		console.log('click');
		canvasSpecialeA();
		document.getElementById('Change').hidden=true;
	});

	//Offert
	document.getElementById('Offert').addEventListener('click', function(){
		console.log('click');
		canvasOffert();
		document.getElementById('Change').hidden=true;
	});

	//Recette
	document.getElementById('Recette').addEventListener('click', function(){
		console.log('click');
		recette();
		document.getElementById('Change').hidden=true;
	});

	//Depenses
	document.getElementById('Depenses').addEventListener('click', function(){
		console.log('click');
		depenses();
		document.getElementById('Change').hidden=true;
	});

	//Recette + Depenses
	document.getElementById('Recette+Depenses').addEventListener('click', function(){
		console.log('click');
		document.getElementById('Change').hidden=false;
		recetteTotale();
	});

	var column = true;
	document.getElementById('Change').addEventListener('click', function(){
		if(column){
			changeAspect();
			column = false;
		}else{
			recetteTotale();
			column = true;
		}
		});	

	}, 100);

}

	var tabP = [], tabR=[], tabO=[], tabSJ=[], tabSA=[], tabE=[], tabRecette=[], tabDepenses=[];

	function getSpec(){

		$.getJSON('visualisation.php',function(data) {

			$.each(data,function(Titre,val){

				$.each(val,function(key2,val2){

					switch ($key2){
						case "P":
							tabP.push({
								label: Titre,
								y: val2
							});
							break;	
					
						case "R":
							tabR.push({
								label: Titre,
								y: val2
							});	
							break;				

						case "O":
							tabO.push({
								label: Titre,
								y: val2
							});
							break;

						case "SJ":
							tabSJ.push({
								label: Titre,
								y: val2
							});	
							break;

						case "SA":
							tabSA.push({
								label: Titre,
								y: val2
							});	
							break;

						case "E":
							tabE.push({
								label: Titre,
								y: val2
							});	
							break;

						case "Recette":
							tabRecette.push({
								label: Titre,
								y: val2
							});	
							break;

						case "Depenses":
							tabDepenses.push({
								label: Titre,
								y: val2
							});	
							break;
					}
				});
			});
		});

		setTimeout(function () {console.log(tabP); }, 100);
        console.log(tabP);
	} 