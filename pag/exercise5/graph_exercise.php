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
    <script src="../../cytoscape.js-klay-3.1.4/cytoscape-dagre.js"></script>
		
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




d3.json("lettura_graph.php?id=1", function(error, links) {
	var newnode=[]
	var newlink=[]
	var datpie=[]
	var datpin=[]

	var source=-1;
	var node="";
	var depth=0;
 for (var x in links){
	if(typeof(links[x])!="undefined"){
		if(links[x].giusto==1){
		
		node = links[x].id ;
		//creo il nodo 
		if (source>=0){
			//creao il link
			if(x % 2 == 0) {
		
				datpin.push({"data": {"id": node, name:links[x].word.toUpperCase(),class:"primo","img":links[x].img,"description":links[x].description,"depth":depth,giusto:1}})
				nodeerr = links.find(x=>x.id===node+"-0");
				datpin.push({"data": {"id": nodeerr.id, name:nodeerr.word.toUpperCase(),class:"primo","img":nodeerr.img,"description":nodeerr.description,"depth":depth,giusto:0}})
				datpie.push( { data: { source:source, target: node ,} })	
				datpie.push( { data: { source:source, target: nodeerr.id } })	
			}else{
				nodeerr = links.find(x=>x.id===node+"-0");
				datpin.push({"data": {"id": nodeerr.id, name:nodeerr.word.toUpperCase(),class:"primo","img":nodeerr.img,"description":nodeerr.description,"depth":depth,giusto:0}})	
				datpin.push({"data": {"id": node, name:links[x].word.toUpperCase(),class:"primo","img":links[x].img,"description":links[x].description,"depth":depth,giusto:1}})
				datpie.push( { data: { source:source, target: nodeerr.id } })	
				datpie.push( { data: { source:source, target: node } })	
			}
			
			
		}else{
		
			datpin.push({"data": {"id": node, name:links[x].word.toUpperCase(),class:"primo","img":links[x].img,"description":links[x].description,"depth":depth,giusto:1}})


		}

		source = node
		depth=depth+1;
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
],
elements: data
});
var step =0;

console.log(cy.elements("node").depthFirstSearch('#0'))
cy.on('tap', 'node', function(ele,param=0) {
	ele.target.selectify()
	if ( ele.target.data().giusto==1){


	step= ele.target.data().depth+1
}
	console.log(step);
	for (var x=0;x< cy.elements("node").length;x++){
		if (typeof(cy.elements("node")[x])!="undefined"){
		
		
				if (cy.elements("node")[x].data().depth>step){

				
				parola =cy.elements("node")[x].id();
				cy.style().selector('#'+parola)
						.css({					
							'display':'none'
						}).update()
					
				}else{
					parola =cy.elements("node")[x].id();
				cy.style().selector('#'+parola)
						.css({					
							'display':'element'
						}).update()
				}
			}
		
	}
});
for (var x=0;x< cy.elements("node").length;x++){
	if (typeof(cy.elements("node")[x])!="undefined"){
		
		if (cy.elements("node")[x].data().depth>step){

		
		parola =cy.elements("node")[x].id();
		cy.style().selector('#'+parola)
				.css({					
					'display':'none'
				}).update()
			
		}
	}
}
var y =0 ;
var x1 =0;
for (var x=0;x< cy.elements("node").length;x++){
	if (typeof(cy.elements("node")[x])!="undefined"){
		
		parola =cy.elements("node")[x].id();
		 x1 = cy.elements("node")[x].data().depth * 100;
		 if(x==0){
			y=0;
		 }else{
			if (y==150){
				y = -150
			}else{
				y = 150
			}
		 }
		
		
		cy.elements("node")[x].position( "x" ,y);
		cy.elements("node")[x].position( "y", x1);
		console.log(cy.elements("node")[x].position())
		cy.style().selector('#'+parola)
				.css({
					
					'background-image':cy.elements("node")[x].data().img
				}).update()
	}
	
}



}		
</script>
</html>
