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
    var picdiv2='<div class="col-lg-3 col-md-4 col-6">';
    picdiv2+='<a href="#" class="d-block mb-4 h-100">';
    picdiv2+='<img class="img-fluid img-thumbnail" src="../artno/chai.png" alt=""></a></div>';
    $.each(data,function(i,v){
        var picdiv='<div class="col-lg-3 col-md-4 col-6">';
        picdiv+='<a href="#" class="d-block mb-4 h-100">';
        picdiv+='<img class="img-fluid img-thumbnail" src="'+v.picname+'" alt="">';
        picdiv+='<p>'+v.artno+'--'+v.shade+'</p></a></div>';
        $("#picholder").append(picdiv);
    });






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
                    <button type="button" name="getBar" id="get_bar" class="btn btn-primary">SHOW PIC</button>
                </td>

        </tr>
            

        
    </table>
    </form>
    <hr>
    <style>
        .span4{
            max-width:220px;
            max-height:220px;
            margin-bottom: 195px;;
            overflow: hidden;
        }
    </style>
    <div id="showdata">
       
    <div class="container">

  <h3 class="font-weight-light text-center text-lg-left mt-4 mb-0">Article Gallery</h3>

  <hr class="mt-2 mb-5">

  <div class="row text-center text-lg-left" id="picholder">

    <!-- <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="../artno/chai.png" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="../artno/orcawhale.jpg" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/EUfxH-pze7s/400x300" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/M185_qYH8vg/400x300" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/sesveuG_rNo/400x300" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/AvhMzHwiE_0/400x300" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/2gYsZUmockw/400x300" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/EMSDtjVHdQ8/400x300" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/8mUEy0ABdNE/400x300" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/G9Rfc1qccH4/400x300" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/aJeH0KcFkuc/400x300" alt="">
          </a>
    </div>
    <div class="col-lg-3 col-md-4 col-6">
      <a href="#" class="d-block mb-4 h-100">
            <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/p2TQ-3Bh3Oo/400x300" alt="">
          </a>
    </div> -->
  </div>

</div>
<!-- /.container -->
    
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
