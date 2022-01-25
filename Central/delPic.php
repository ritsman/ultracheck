<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');

// all sales order
$sono=get_sono_list($DBH);

//var_export($sono);
//echo '<hr>';

$shades=get_shade_all($DBH);

$artno=get_articleno($EBH);
//var_export($artno);
// get all the images;;
$q="select * from `Q__artno__pic`";
$stm=$EBH->prepare($q);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}


?>

<script type="text/javascript">

    
    var sono=<?php print json_encode($sono);?>;
    var shades=<?php print json_encode($shades);?>;
    var artno=<?php print json_encode($artno);?>;
    var data={};
    data=<?php print json_encode($data);?>;
    console.log(data);
    





   
    
    $(document).ready(function(){
        $("#sono2").autocomplete({
            source:sono
        });

        $("#artno").autocomplete({
            source:artno
        });

     
        
    });

    $("#artno").change(function(){
        var artno=$(this).val();
        $.post("P_delPic.php",{artno:artno},function(data){
            console.log(data);
            var d=JSON.parse(data);
            var opt="<option>SELECT</option>";
            $(d).each(function(i,v){
                console.log(i,v);
                opt+="<option>"+v.shade+"</option>";
            });
            $("#sel_shade").empty()
                            .append(opt);
        });
    });
// load the pic to delete
    $("#sel_shade").change(function(){
        var shade=$(this).val();
        var artno=$("#artno").val();
        if(artno==''||shade=='SELECT'){
            return false;
        }else{
            $.post("P2_delPic.php",{artno:artno,shade:shade},function(data){
                console.log(data);
                var d=JSON.parse(data);
                console.log(d);
                $("#showdiv").html("<img src='"+d+"' class='thumbnail'/>");
            });
        }
    });
    
</script>
<style>
    #tabmain input[type='text']{
        width:90%;
    }
</style>
<div class="container-fluid">
<div class="pageShow2">
   
    <table id="tabmain">
        <tr>
            
            <th>SELECT ARTICLE NO</th>
            <th>SELECT COLOR</th>
            
        </tr>
        <tr>

            <td><input type="text" name="artno" id="artno" title="artno"></td>
            <td>
                <select class="form-control" title="shade" id="sel_shade" name="shade">
                        <option>SELECT</option>
                        
                        
                </select>
            </td>
           
        </tr>
        <tr>        
                <td colspan="3">
                    <button type="button" name="getBar" id="get_bar" class="btn btn-primary">DELETE PIC</button>
                </td>

        </tr>
            

        
    </table>
    <div id="showdiv">showdiv</div>
   
    <hr>
    <style>
        .span4{
            max-width:220px;
            max-height:220px;
            margin-bottom: 195px;;
            overflow: hidden;
        }
    </style>
    <div id="showdata"></div>

    <script>
    artpic=0;//to hold the uploade file destination later
//upload file
$("#get_bar").click(function(){
        
        
        var article=$("#artno").val();
        var shade=$("#sel_shade").val();
        $.post("P3_delPic.php",{artno:article,shade:shade},function(data){
            $("#showdiv").html(data);
        });
       

        });
    </script>
