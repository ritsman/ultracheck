<?php
include '../inc/base5.php';
//echo $_SESSION['usr'];
//echo $_SESSION['al'];
//--------------------------get contents for the nav from master-nav.html
$filename="sales-nav.html";
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
		$(document).attr("title","OUTSOURCE");
	});
    
	//set the main menu-------------------------------------------
		$(document).ready(function(){
		
            $("#navbar").append(nav);
        
        });
	
	
  
</script>