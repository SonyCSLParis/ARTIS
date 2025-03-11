
<?php
// Start the session
session_start();
?>
     <?php if($_GET["suitable"]<>"0" && $_GET["suitable"]<>"" && $_GET["title"]<>"0" || $_GET["title"]<>"" ){
    $_SESSION["id_text"]=$_GET["title"];
     }
     ?>
<?php include "../../admin/conn.php";
 include "../../admin/funz.php";
 controlla_user()?>

<?php 


?>
<script src="https://unpkg.com/bluebird@3.5.1/js/browser/bluebird.js"></script>
		<script src="https://unpkg.com/whatwg-fetch@2.0.3/fetch.js"></script>

		<script src="https://unpkg.com/cytoscape/dist/cytoscape.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
		<!-- for testing with local version of cytoscape.js -->
		<!--<script src="../cytoscape.js/build/cytoscape.js"></script>-->
		<script src="https://unpkg.com/dagre@0.7.4/dist/dagre.js"></script>
    <script src="../../cytoscape.js-klay-3.1.4/cytoscape-dagre.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/popper.js@1.14.7/dist/umd/popper.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/cytoscape-popper@1.0.4/cytoscape-popper.min.js"></script>
  <script src="https://unpkg.com/tippy.js@4.0.1/umd/index.all.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/tippy.js@4.0.1/index.css" />
		<script src="//d3js.org/d3.v3.min.js"></script>
<style>
   #cy {
		
        width:100%;
        height: 100%;
 
      }
</style>

</head>
<?php include "../../header.php";?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0" align="center">Trova la rete semantica </h1>
		<div align="center">	Clicca sulla parola inizale.<bR>
		Vedrai due alternative:<bR>

    Una è collegata alla parola iniziale.<bR>
	L'altra non lo è.<bR>
	</div>
            <hr>
          
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="container">
    <div class="row mb-2" id="container">
          <div class="col-sm-10" id="cy">
    
        
      
          
          
        
        </div><!-- /.row -->
    </div> 
   
    <!-- Main content -->
    </div>
<!-- ./wrapper -->

<?php include "../../modal.php";?>

<?php include "../../scripts.php";?>

<script>
var timer = 0
var interval = setInterval(function(){
 timer=timer+1;
}, 1000);


var risposte = [];

d3.json("lettura_graph.php?id=<?php echo $_GET["id"]?>", function(error, links) {
	var newnode=[]
	var newlink=[]
	var datpie=[]
	var datpin=[]
 var source_arra=[]
	var source=-1;
	var node="";
	var depth=0;

 for (var x in links){
	if(typeof(links[x])!="undefined"){

	node = links[x].id ;
		if(links[x].giusto==1){
		//creo il nodo 
		if (source>=0){
			//creao il link
				datpin.push({"data": {"id": node, name:links[x].word.toUpperCase(),class:"primo","img":links[x].img,"description":links[x].definition,"depth":depth,giusto:1}})
				datpie.push( { data: { source:source, target: node } })	
					
		}else{
			datpin.push({"data": {"id": node, name:links[x].word.toUpperCase(),class:"primo","img":links[x].img,"description":links[x].definition,"depth":depth,giusto:1}})
		}

			source = node
			source_arra.push(node)
	depth=depth+1;
	}

	}
}

var data ={
nodes: datpin,
edges: datpie

}
var source=0;
	var node="";
	var depth=1;
	y=0;
 for (var x in links){
	if(typeof(links[x])!="undefined"){

	node = links[x].id ;
		if(links[x].giusto==0){
		//creo il nodo 
		
			//creao il link
				datpin.push({"data": {"id": node, name:links[x].word.toUpperCase(),class:"primo","img":links[x].img,"description":links[x].definition,"depth":depth,giusto:0}})
				datpie.push( { data: { source:source_arra[y], target: node } })	
					
		y=y+1;
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
console.log("SSSS")

var cy = window.cy = cytoscape({
container: document.getElementById('cy'),

layout: {
name: 'dagre',
concentric: function(n){ return n.id() === 'j' ? 200 : 0; },
levelWidth: function(nodes){ return 200; },
minNodeSpacing: 200
},

style: [
{
  
selector: 'node[name]',
style: {
'content': 'data(name)',
'background-color': '#377fbf',

 'text-valign': 'center',
    // the next line moves the parents label up to the top of the node and 5px down to create a padding 
    'text-margin-y': function (node) { return -node.height() + 5 },
      

	  'background-fit': 'cover',
					'background-repeat':'no-repeat',
					'background-position': 'bottom center'
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

function salva(){

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "salva_esercizio.php");
  xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8")
  const body = JSON.stringify({
  id_word: <?php echo $_GET["id"]?>,
  iduser: <?php echo $_SESSION["id_alunno"]?>,
  language: "<?php echo $language ?>",
  risposta: risposte,
 tempo:timer, 
  completed: false
});
xhr.onload = () => {
  if (xhr.readyState == 4 && xhr.status == 201) {
    console.log(JSON.parse(xhr.responseText));
  } else {
    console.log(`Error: ${xhr.status}`);
  }
};
xhr.send(body);

timer=0;
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
$('#cy').css('height', $('#container').width());
$('#cy').css('width', $('#container').height());
    cy.resize();
    cy.fit();

cy.on('tap', 'node', function(ele,param=0) {

	var 	depthmax=0;
 	
	if ( ele.target.data().giusto==1){
		step= ele.target.data().depth+1
	}
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
			if (cy.elements("node")[x].data().depth>depthmax){
				depthmax= cy.elements("node")[x].data().depth;
			}
	 
		}

	}


	var pos = risposte.findIndex(x=>x[0]===ele.target.id())
	console.log(pos);
	if (pos==-1){
		risposte.push([ele.target.id(),ele.target.data().giusto]);
		salva()
		console.log(risposte)
		var conta = risposte.filter(x=>x[1]==1);
		console.log(conta.length)
		console.log(depthmax)
		if (ele.target.data().giusto==0){
			cy.style().selector('#'+ele.target.id())
		.css({					
			'border-color':'red',
			'border-width': 2
		}).update()
		$('#modal-l3').modal('show');
		}else{
			cy.style().selector('#'+ele.target.id())
		.css({					
			'border-color':'blue',
			'border-width': 2
		}).update()
		if (depthmax+1==conta.length){
			//vinto
			console.log("vinto")
			$('#modal-l1').modal('show');
		}else{
			$('#modal-l2').modal('show');
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

for (var x=0;x< cy.elements("node").length;x++){
	if (cy.elements("node")[x].data().giusto==1){
		if(x==0){
			console.log(cy.elements("node")[x].position().x)
			console.log(cy.elements("node")[x].position().y)
			var y =cy.elements("node")[x].position().y;
			var x1 =cy.elements("node")[x].position().x+100;
			var y1=y+75;
			var y2=y-75;
		}
		
		
	
		if (typeof(cy.elements("node")[x])!="undefined"){
			
			parola =cy.elements("node")[x].id();
			x1 = cy.elements("node")[x].data().depth * 100;
		
				if (y==y1){
					y = y2
				}else{
					y = y1
				}
			
			
			
			cy.elements("node")[x].position( "x" ,y);
			cy.elements("node")[x].position( "y", x1);
		//	console.log(cy.elements("node")[x].position())
			cy.style().selector('#'+parola)
					.css({
			
						'background-image':cy.elements("node")[x].data().img
					}).update()
		}
	}
}

for (var x=0;x< cy.elements("node").length;x++){

	if (cy.elements("node")[x].data().giusto==0){

	
		if (typeof(cy.elements("node")[x])!="undefined"){
			if(x==0){
			console.log(cy.elements("node")[x].position().x)
			console.log(cy.elements("node")[x].position().y)
			var y =cy.elements("node")[x].position().y ;
			var x1 =cy.elements("node")[x].position().x;
			var y1=y+75;
			var y2=y-75;
		}
			parola =cy.elements("node")[x].id();
			x1 = cy.elements("node")[x].data().depth * 100;
			
			if (y==y1){
					y = y2
				}else{
					y = y1
				}
			
			
			
			cy.elements("node")[x].position( "x" ,y);
			cy.elements("node")[x].position( "y", x1);
		//	console.log(cy.elements("node")[x].position())
			cy.style().selector('#'+parola)
					.css({
			
						'background-image':cy.elements("node")[x].data().img
					}).update()
		}
	}
}
cy.fit()



}		
</script>


</body>
</html>

