window.onload = function () { //au chargement de la fenetre on applique notre fonction

		getLieu(); //recupere ton tableau rempli

		setTimeout(function () { 

		var chart = new CanvasJS.Chart("Lieu", {
			animationEnabled: true, 
			title: {}, //précréer le titre vide
			toolTip: {
				shared: true //pour afficher tt les infos ensembles sur la meme colonnes
			},	
		});    //contient le canvas

		canvasTarifReduit(); //1er affichage
		chart.render();//rafraichir l'affichage(du rendu)

	 	function popUpPT(e){
		
			var  str = "<span style= \"color:"+e.entries[0].dataSeries.color + "\"> "+e.entries[0].dataSeries.name+"</span> : <strong>"+e.entries[0].dataPoint.y+"</strong> places<br/>";
			total = totPT(e.entries[0].dataPoint.y);
			str2 = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.label)+"</strong></span><br/>"; //on met dans nos var str nos valeurs avec des balises pour l'affichage
			str3 = "<span style = \"color:Tomato\">Total : </span><strong>"+total+"</strong>€<br/>";
			return (str2.concat(str)).concat(str3); //on retourne  la concatenation de nos variables
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
		
		//recette+dépenses
		function popUpRD(e){
		
			var  str1 = "<span style= \"color:"+e.entries[0].dataSeries.color + "\"> "+e.entries[0].dataSeries.name+"</span> : <strong>"+e.entries[0].dataPoint.y+"</strong> €<br/>";
			var  str2 = "<span style= \"color:"+e.entries[1].dataSeries.color + "\"> "+e.entries[1].dataSeries.name+"</span> : <strong>"+e.entries[1].dataPoint.y+"</strong> €<br/>";
			total = e.entries[0].dataPoint.y - e.entries[1].dataPoint.y ;
			str3 = "<span style = \"color:Tomato\">Total : </span><strong>"+total+"</strong>€<br/>";
			troupe = "<span style = \"color:DodgerBlue;\"><strong>"+(e.entries[0].dataPoint.label)+"</strong></span><br/>";
			return (troupe.concat(str1.concat(str2))).concat(str3);
		}
		
		// places gratuites(O et E)
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
					dataPoints: tabP
					}; //jeu données
					
			chart.options.title.text="Nombre de billet Plein Tarif vendu par Lieu";
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
					dataPoints: tabR
				};
		
			chart.options.title.text="Nombre de billet Tarif Reduit vendu par Lieu"; // modifie le title du canvas
			chart.options.data = []; //réinitialise les données du canvas
			chart.options.data.push(donnees); //on met notre jeu de données dans notre data du canvas
			chart.options.toolTip.content = popUpTR; //on met le contenu de notre fonction dans l'affichage du canvans
			chart.render();
		}
		
		
		//Tarif Enfant
		function canvasTarifEnfant(){
		
			var donnees ={
					type: "column",
					name: "Nombre de billets",				
					dataPoints: tabE
				};
		
			chart.options.title.text="Nombre de billets Enfant vendu par Lieu";
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
		
			chart.options.title.text="Nombre de billet Offert par Lieu";
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
		
			chart.options.title.text="Nombre de billet Tarif SJ payé par Lieu";
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
		
			chart.options.title.text="Nombre de billet Tarif SA payé par Lieu";
			chart.options.data = [];
			chart.options.data.push(donnees);
			chart.options.toolTip.content = popUpSA;
			chart.render();
		}
		
		
		function recette(){

			var donnees ={
						type: "column",
						name: "Recette", 
						dataPoints: tabRecette
					};
			chart.options.title.text="Recette de l'organisateur du Festival par Lieu";
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
						dataPoints: tabDepenses
					};
					
			chart.options.title.text="Depenses de l'organisateur du Festival par Lieu";
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
					}; //jeu de données
					
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
			document.getElementById('Change').hidden=true; //cache le boutton de l'id Change
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
		document.getElementById('Change').addEventListener('click', function(){ //détecte l'action du click sur le bouton à l'id Change("Afficahge")
			if(column){
				changeAspect();
				column = false;
			}else{
				recetteTotale(); //pour faire appel 1 fois sur 2 aux fonctions changeAspect() et recetteTotale()
				column = true;
			}
			});	

		}, 100);

	}

		var tabP = [], tabR=[], tabO=[], tabSJ=[], tabSA=[], tabE=[], tabRecette=[], tabDepenses=[]; //pas besoin d'attrendre le chargement de la page pour creer nos taleaux


		function getLieu(){

			$.getJSON('visualisationTroupe.php',function(data) { //récupère l'objet pour executer une fonction que l'on définit 

				$.each(data,function(Titre,val){ //double foreach pour les valeurs function(clé,valeur)

					$.each(val,function(key2,val2){

						switch (key2){
							case "P":
								tabP.push({
									label: Titre,
									y: val2
								});          //ajouter la paire (label,y) au tableau
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
					//console.log(tabP);
				});
			});

			setTimeout(function () {console.log(tabP); }, 100);
	        //console.log("tabP :"+ tabP); //pb de récupération des valeurs à l'extérieur du JSON,json s'éxécute après je javascript donc on met un délai pour récupérer les valeurs avant l'affichage le tableau
}