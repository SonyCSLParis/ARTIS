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
		<script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/popper.js@1.14.7/dist/umd/popper.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/cytoscape-popper@1.0.4/cytoscape-popper.min.js"></script>
  <script src="https://unpkg.com/tippy.js@4.0.1/umd/index.all.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/tippy.js@4.0.1/index.css" />
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
	<div style="margin:30px;padding:30px;">

		<div id="cy"></div>
	</div>
	</body>
	<script>




d3.json("lettura_graph.php?id=<?php echo $_GET["id"]?>", function(error, links) {
	var newnode=[]
	var newlink=[]
	var datpie=[]
	var datpin=[]

	var source=-1;
	var node="";
	var depth=0;
	console.log(links);
 for (var x in links){
	if(typeof(links[x])!="undefined"){
		
		
		node = links[x].id ;
		//creo il nodo 
		if (source>=0){
			//creao il link
			if(x % 2 == 0) {
		
				datpin.push({"data": {"id": node, name:links[x].word.toUpperCase(),class:"primo","img":links[x].img,"description":links[x].definition,"depth":depth}})
					datpie.push( { data: { source:source, target: node ,} })	
			
			}else{
				
				datpin.push({"data": {"id": node, name:links[x].word.toUpperCase(),class:"primo","img":links[x].img,"description":links[x].definition,"depth":depth}})
			
				datpie.push( { data: { source:source, target: node } })	
			}
			
			
		}else{
		
			datpin.push({"data": {"id": node, name:links[x].word.toUpperCase(),class:"primo","img":links[x].img,"description":links[x].definition,"depth":depth}})


		}

		source = node
		depth=depth+1;
	
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

});
cy.animate({
  fit: {
  
    margin: -120
  }
}, {
  duration: 1000
});
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
		
		
		
		cy.style().selector('#'+parola)
				.css({
					
					'background-image':cy.elements("node")[x].data().img
				}).update()
	}
	
}

function makePopper(ele) {
    let ref = ele.popperRef(); // used only for positioning

    ele.tippy = tippy(ref, { // tippy options:
      content: () => {
        let content = document.createElement('div');
      //  console.log( ele.data())
        content.innerHTML = ele.data().description;

        return content;
      },
      trigger: 'manual' // probably want manual mode
    });
  }

  cy.ready(function() {
    cy.elements().forEach(function(ele) {
      makePopper(ele);
    });
  });

  cy.elements("node").unbind('mouseover');
  cy.elements("node").bind('mouseover', (event) => event.target.tippy.show());

  cy.elements("node").unbind('mouseout');
  cy.elements("node").bind('mouseout', (event) => event.target.tippy.hide());
cy.zoomingEnabled(false)

}		
</script>
</html>
