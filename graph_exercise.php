<!doctype html>

<html>

	<head>
		<title>cytoscape-klay.js demo</title>

		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">

		<!-- the demo uses fetch() -->
		<script src="https://unpkg.com/bluebird@3.5.1/js/browser/bluebird.js"></script>
		<script src="https://unpkg.com/whatwg-fetch@2.0.3/fetch.js"></script>

		<script src="https://unpkg.com/cytoscape/dist/cytoscape.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
		<!-- for testing with local version of cytoscape.js -->
		<!--<script src="../cytoscape.js/build/cytoscape.js"></script>-->
		<script src="https://unpkg.com/dagre@0.7.4/dist/dagre.js"></script>
    <script src="cytoscape.js-klay-3.1.4/cytoscape-dagre.js"></script>
		
		<script src="//d3js.org/d3.v3.min.js"></script>
		<style>
			
			body {
        font-family: helvetica;
        font-size: 14px;
      }

      #cy {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 999;
      }

      h1 {
        opacity: 0.5;
        font-size: 1em;
      }
    
		</style>


	</head>

	<body>
	

		<div id="cy"></div>

	</body>
	<script>

d3.csv("python3/src/resources/html/graph.csv?ff="+Date.now(), function(error, links) {
	var newnode=[]
	var newlink=[]
	var datpie=[]
	var datpin=[]
 for (var x in links){
	if(typeof(links[x])!="undefined"){
		
		datpie.push( { data: { source:links[x].Source, target: links[x].Target } })	
		var node = links[x].Source;
	
		if(newnode.findIndex(x => x.id === node)==-1){
			newnode.push({"id":node})
			if(links[x][""]==0){
			
				datpin.push({"data": {"id": node, name:node.toUpperCase(),class:"primo","img":"test"+x}})
			
			}else{
				datpin.push({"data": {"id": node, name:node,"img":"test"+x}})
			}
		
		}
		node = links[x].Target
		if(newnode.findIndex(x => x.id === node)==-1){
			newnode.push({"id":node})
			datpin.push({"data": {"id": node, name:node,"img":"test"+x}})
		}	
	}
}
var data ={
nodes: datpin,
edges: datpie

}

console.log(data);
setTimeout(function() {
	caricatutto(data);
}, 1000);





});

function aggiornaimmagine(parola){
	$.ajax({
			type: 'POST',
			url: "http://93.147.158.9:5002/see_another",
			data: JSON.stringify ({word: parola,language:'it'}),
			success: function(data) { 
		
			
			
			for (var x in data){
			
				urlimg=data[x].replace("'","")
				
				console.log(parola)
				console.log(urlimg)
				cy.style().selector('#'+parola)
				.css({
					'background-image': urlimg
					
					
				
				}).update()
				break
			}
		
			
			},
			async:false,
			contentType: "application/json",
			dataType: 'json'
		});
}
function caricatutto(data){


var cy = window.cy = cytoscape({
container: document.getElementById('cy'),

layout: {
name: 'dagre',
concentric: function(n){ return n.id() === 'j' ? 200 : 0; },
levelWidth: function(nodes){ return 100; },
minNodeSpacing: 100
},

style: [
{
selector: 'node[name]',
style: {
'content': 'data(name)',
'background-color': '#377fbf',
 'width':'50px;',
      'height': '50px;',

	  'background-fit': 'cover',
					'background-repeat':'no-repeat',
					'background-position': 'center center'
}
},
{
selector: 'node[class="primo"]',
style: {
'content': 'data(name)',
'background-color': '#80c7bf',

}
},
{
selector: 'edge',
style: {
'curve-style': 'bezier',
'target-arrow-shape': 'triangle',
'target-arrow-color':'#f8d260',
'line-color': '#f8d260'
}
},

// some style for the extension




],

elements: data
});


for (var x=0;x< cy.elements("node").length;x++){
	if (typeof(cy.elements("node")[x])!="undefined"){
		console.log(cy.elements("node")[x].id());
		parola =cy.elements("node")[x].id();
		aggiornaimmagine(parola)
	}
	
}
	
/*cy.style().selector('#bird')
      .css({
        'background-image': 'https://live.staticflickr.com/7272/7633179468_3e19e45a0c_b.jpg'
      }).update()
*/

}		
</script>
</html>
