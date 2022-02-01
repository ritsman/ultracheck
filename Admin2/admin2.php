<?php
include '../inc/base3.php';
//echo $_SESSION['usr'];
//echo $_SESSION['al'];
//--------------------------get contents for the nav from master-nav.html
$filename="admin2-nav.html";
$nav= file_get_contents($filename);

?>

<style>
#centraldiv{
	width:100%;
	height:400px;
	background-color: red;

}
#sidebardiv{
	width:900px;
	height:500px;
	background-color: yellow;
	z-index: 35;
}
nav#auxnav ul{
    /* background-color:red; */
    width:700px;;
}
ul#aux-ul li a{
    width:300px;
}

</style>

<script src="../methods/variable.js"></script>

<script type="text/javascript">
var central_dash="<div id='centraldiv'><div id='sidebardiv'>HELLO</div></div>";
var nav=<?php print json_encode($nav);?>;


    
//$("#sidebar").html(central_dash);
	//$("#centraldiv").append(nav);


	
	//set the title of page-------------------------------------
	$(document).ready(function(){
		$(document).attr("title","ADMIN");
	});
    //------------------------------------------------------------
    //set the main menu-------------------------------------------
		$(document).ready(function(){
		//alert("Matman started");..
		
		var pageNavli="<li onclick='laodSubMenu(this,kay3,2)'>FLIVEZ</li>";
                pageNavli+="<li onclick='laodSubMenu(this,kay2,2)'>DOMESTIC</li>";
                pageNavli+="<li onclick='laodSubMenu(this,kay2,2)'>EXPORTS</li>";
                pageNavli+="<li onclick='laodSubMenu(this,kay2,2)'>JOBWORK</li>";
		$("#pageNav-ul").append(pageNavli);
		$("#mod2-ul h3").css("color","#fff");
		});
	//--------------------------------------------------------------
	//set the main menu-------------------------------------------
		$(document).ready(function(){
		
            $("#navbar").append(nav);
        
        });
	
		//set the li for GENERAL module
	var kay3=[];
        kay3[0]='<li id="printBarcode" onclick="track(this)">Print</li>';
		kay3[1]='<li id="show_stock" onclick="track(this)">Scan</li>';
		kay3[2]='<li id="dispatch" onclick="track(this)">Stock</li>';
		kay3[3]='<li id="gatepass" onclick="track(this)">Packing List</li>';
		
        
	

  
</script>