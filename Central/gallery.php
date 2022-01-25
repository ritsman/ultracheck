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



?>

<script type="text/javascript">
var auxul = "<ul id='aux-ul'><li><a href=\"#\" class=\"bkch\" id='gallery' onclick='track(this)'>New Upload</a></li>";
    auxul += "<li><a href=\"#\" id='viewGallery' onclick='track(this)'>View</a></li>";
    auxul += "<li><a href=\"#\" id='delPic' onclick='track(this)'>Delete</a></li>";
    auxul += "</ul>";
    $(document).ready(function () {
        $("#auxnav").html(auxul);
    });
    
    var sono=<?php print json_encode($sono);?>;
    var shades=<?php print json_encode($shades);?>;
    var artno=<?php print json_encode($artno);?>;
    //console.log(sono);
    var sel_options='';
    $.each(shades,function(i,v){
        sel_options+="<option>"+v+"</option>";
    });
    
    $(document).ready(function(){
        $("#sono2").autocomplete({
            source:sono
        });

        $("#artno").autocomplete({
            source:artno
        });

        $("#sel_shade").append(sel_options);
        
    });
    
</script>
<style>
    #tabmain input[type='text']{
        width:90%;
    }
</style>
<div class="container-fluid">
<div class="pageShow2">
    <form name="upform" id="upform" action="upload.php" method="post" enctype="multipart/form-data" target="if33">
    <table id="tabmain">
        <tr>
            
            <th>SELECT ARTICLE NO</th>
            <th>SELECT COLOR</th>
            <th>SELECT PICTURE</th>
        </tr>
        <tr>

            <td><input type="text" name="artno" id="artno" title="artno"></td>
            <td>
                <select class="form-control" title="shade" id="sel_shade" name="shade">
                        <option>SELECT</option>
                        
                        
                </select>
            </td>
            <td>
                <input type="file" class="form-control-file" name="upart" id="upart" title="upart">
            </td>
        </tr>
        <tr>        
                <td colspan="3">
                    <button type="button" name="getBar" id="get_bar" class="btn btn-primary">UPLOAD PIC</button>
                </td>

        </tr>
            

        
    </table>
    </form>
    <hr>
    <div id="response"></div>
    <div id="artpic"></div>
    <iframe class="noshow" id="if33" name="if33"></iframe>
    <script>
    artpic=0;//to hold the uploade file destination later
//upload file
$("#get_bar").click(function(){
        
        
        var article=$("#artno").val();
        var ind=$.inArray(article,artno);
        //alert(ind);
        if(ind==-1){
            alert("Article No not found!")
            return false;
        }else{
           // alert("gin");
           var data=check_and_collect_values("#tabmain");
           console.log(data);
           if(data.goahead=='yes'){
            var loader='<div class="loader"></div>';
               data=JSON.stringify(data);
               $("#response").html(loader);
               $("form#upform").submit();
           }
        }

        });
    </script>
