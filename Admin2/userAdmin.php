<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include '../Central/class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
$EBH2=new dbconnect();
$EBH=$EBH2->con('ultra');
//=======================================================

// get all users
$q="select `usr` from `b_admin`";
$stm=$EBH->prepare($q);
try {
  $stm->execute();
  while($r=$stm->fetch(PDO::FETCH_ASSOC)){
    $usr[]=$r['usr'];
  }
} catch (PDOException $th) {
  //throw $th;
  echo $th->getMessage();
}
//var_export($usr);
//echo '<hr>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<script>
var auxul = "<ul id='aux-ul'><li><a href=\"#\" class=\"bkch\" id='userAdmin' onclick='track(this)'>New User</a></li>";
    auxul += "<li><a href=\"#\" id='viewBarcode' onclick='track(this)'>View</a></li>";
    auxul += "<li><a href=\"#\" id='delBarcode' onclick='track(this)'>Delete</a></li>";
    auxul += "</ul>";
    $(document).ready(function () {
        $("#auxnav").html(auxul);
    });

    // all user
    var user_data=<?php print json_encode($usr);?>;
    //console.log(usr);
</script>
<body>
    <style>
        .cen{
            max-width: 50%;
            /* background-color:red; */
            text-align:center;
            margin-top:5%;
        }
        .cen2{
            max-width: 50%;
            /* background-color:red; */
            text-align:center;
            
        }
        .custom-btn{
          margin-top:12px;
          width:80%;
        }
    </style>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <table class="table cen" id="tabmain-user">
                <tr>
                    <th>
                        Create New User
                    </th>
                    <td>
                        <input type="text" name="userName" id="userName" class="form-control" title='usrname'>
                        <span id="response"></span>
                        <div class="noshow" id="delBtn">
                        <button class="btn btn-danger mt-3" id="delUser">DELETE USER</button>
                        </div>
                        
                    </td>
                </tr>
                <tr>
                    <th>
                        User Password
                    </th>
                    <td>
                        <input type="text" name="userPass" id="userPass" class="form-control" title='usrpas'>
                    </td>
                </tr>
                <tr>
                    <th>
                        User Department
                    </th>
                    <td>
                        <select class="form-control" id="sel_outlet" title="dept"><option>SELECT</option>
                        <option value='central'>LIFESTYLE</option>
                        <option value='central2'>CENTRAL</option>
                        <option value='central3'>SOURCING</option>
                        <option value='Franchise'>FRANCHISE</option>
                        <option value='Ahmd'>FINANCE</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>
                        User Access Level
                    </th>
                    <td>
                        <select class="form-control" id="sel_alevel" title="alevel"><option>SELECT</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <!-- start of accordian -->
        <div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
      Ultra LifeStyle Manufacturing
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <table class="table cen2">
                      <tr>
                          <th>Sales Order Data Entry
                        </th><th><input type="checkbox" name="salesEntry" id="salesEntry"></th>
                        </tr>
                        <tr>
                          <th>Sales Order Modification
                        </th><th><input type="checkbox" name="salesEntry" id="salesEntry"></th>
                        </tr>
                        <tr>
                          <th>Fabric Entry
                        </th><th><input type="checkbox" name="salesEntry" id="salesEntry"></th>
                        </tr>
                        <tr>
                          <th>Cutting,Sewing,Washing,Finishing Data Entry
                        </th><th><input type="checkbox" name="salesEntry" id="salesEntry"></th>
                        </tr>
                        <tr>
                          <th>Material Movement & Reciept
                        </th><th><input type="checkbox" name="salesEntry" id="salesEntry"></th>
                        </tr>
                        <tr>
                          <th>Store Request & Reciept
                        </th><th><input type="checkbox" name="salesEntry" id="salesEntry"></th>
                        </tr>
                  </table>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
      Ultra Central Warehouse & OutSourcing
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <table class="table cen2 text-right" id="tabmain-central">
                      <tr>
                          <th>Barcode -Print Barcode
                        </th><td><input type="checkbox" name="printBarcode" title= "printBarcode" id="printBarcode"></td>
                        </tr>
                        <tr>
                          <th>Barcode -View Barcode
                        </th><td><input type="checkbox" name="viewBarcode" title= "viewBarcode" id="viewBarcode"></td>
                        </tr>
                        <tr>
                          <th>Barcode -Destroy Barcode
                        </th><td><input type="checkbox" name="delBarcode" title= "delBarcode" id="delBarcode"></td>
                        </tr>
                        <tr>
                          <th>Inwards -Fresh Barcode
                        </th><td><input type="checkbox" name="addInventory" title="addInventory" id="addInventory"></td>
                        </tr>
                        <tr>
                          <th>Inwards -Transfer from Others
                        </th><td><input type="checkbox" name="addTrans" title="addTrans" id="addTrans"></td>
                        </tr>
                        <tr>
                          <th>Inwards -View Transfer challan from Outlet to Central
                        </th><td><input type="checkbox" name="chlnsuminwd" title="chlnsuminwd" id="chlnsuminwd"></td>
                        </tr>
                        <tr>
                          <th>Inventory -View Complete Stock
                        </th><td><input type="checkbox" name="showInventory" title="showInventory" id="showInventory"></td>
                        </tr>
                        <tr>
                          <th>Inventory -View Series Summary Outlet wise
                        </th><td><input type="checkbox" name="series_sum" title="series_sum" id="series_sum"></td>
                        </tr>
                        <tr>
                          <th>Inventory -Stock Verify
                        </th><td><input type="checkbox" name="stockVerify" title="stockVerify" id="stockVerify"></td>
                        </tr>
                        <tr>
                          <th>Inventory -Change MRP and Reprint Sticker
                        </th><td><input type="checkbox" name="changeMrp" title="changeMrp" id="changeMrp"></td>
                        </tr>

                        <tr>
                          <th>Outwards -Send Pcs to Outlet
                        </th><td><input type="checkbox" name="sendGoods" title="sendGoods" id="sendGoods"></td>
                        </tr>
                        <tr>
                          <th>Outwards -View Transfer challan from Central to Outlet
                        </th><td><input type="checkbox" name="chlnsumm" title="chlnsumm" id="chlnsumm"></td>
                        </tr>
                        <tr>
                          <th>Outwards -Central Billing
                        </th><td><input type="checkbox" name="billing" title="billing" id="billing"></td>
                        </tr>
                        <tr>
                          <th>Outwards -Central Return Sales
                        </th><td><input type="checkbox" name="returnSales" title="returnSales" id="returnSales"></td>
                        </tr>

                        <tr>
                          <th>Offer -Barcode Discount
                        </th><td><input type="checkbox" name="returnSales" title="returnSales" id="returnSales"></td>
                        </tr>
                        <tr>
                          <th>Offer -Article Number Discount
                        </th><td><input type="checkbox" name="returnSales" title="returnSales" id="returnSales"></td>
                        </tr>
                        
                          <th>Offer -Buy X get Y free
                        </th><td><input type="checkbox" name="buyxgety" title="buyxgety" id="buyxgety"></td>
                        </tr>

                        <tr>
                          <th>Gallery -Upload Picture
                        </th><td><input type="checkbox" name="gallery" title="gallery" id="gallery"></td>
                        </tr>
                        <tr>
                          <th>Gallery -View Picture
                        </th><td><input type="checkbox" name="viewGallery" title="viewGallery" id="viewGallery"></td>
                        </tr>
                        <tr>
                          <th>Gallery -Delete Picture
                        </th><td><input type="checkbox" name="delGallery" title="delGallery" id="delGallery"></td>
                        </tr>
                  </table>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Accordion Item #3
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
</div>
         <!--  end of accordian -->
          <div class="row d-flex justify-content-center">
          <button type="button" class="btn btn-primary custom-btn" id="subForm">SUBMIT</button>
          </div>
          
    </div>

    <form id="POForm" class="noshow" action="R_userAdmin.php" target="_blank" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
        <input type="text" id="holder3" name="holder3" class="noshow"/>
      </form>
      <iframe class="noshow" id="if33" name="if33"></iframe>

      <form id="POForm-user" class="noshow" action="R_userAdminDel.php" target="_blank" method="post">
        <input type="text" id="holder4" name="holder4" class="noshow"/>
        <input type="text" id="holder5" name="holder5" class="noshow"/>
        <input type="text" id="holder6" name="holder6" class="noshow"/>
      </form>
      <iframe class="noshow" id="if44" name="if44"></iframe>
    
<script>
  //load pre-existing values
  
  $("#userName").change(function(){
    var usr=$(this).val();
    var index_user=user_data.indexOf(usr);
    console.log(index_user);
    if(index_user>-1){
      var msg="<p class=errMsg>USER EXISTS WILL BE MODIFIED</p>";
      $("#response").html(msg);
      // remove the noshow class from delete button
      $("#delBtn").removeClass("noshow");

      $.post("P_userAdmin.php",{usr:usr},function(data){
      data=JSON.parse(data);
      console.log(data);
      $(data).each(function(ind,val){
        console.log(ind);
        console.log(val);
        console.log("---------");
        var tabl="#tabmain-"+val.module+" tr";
        console.log(tabl);
        $(tabl).each(function(){
          var f=$(this).find("td input[type='checkbox']").attr("id");
          console.log("F");
          console.log(f);
          if(val.permit==1&&f==val.filename){
            //$(this).find("td").css("background","red");
            $(this).find("td input").prop("checked",true);
          }
          
          });
        });
      });
    }else{
      var msg="<p class=errMsg>NEW USER</p>";
      $("#response").html(msg);
      if($("#delBtn").hasClass("noshow")){
        //nothing
      }else{
        $("#delBtn").addClass("noshow");
                      
      }
      
    }
    
  });



  //submit values for the user
  $("#subForm").click(function(){
    /*
    // get user name and password
    var user=$("#userName").val();
    var passwd=$("#userPass").val();
    var userPass=user+"&&&"+passwd;
    $("#holder2").val(userPass);
    var data_central=check_and_collect_values4a("#tabmain-central");
    console.log(data_central);
    data_central=JSON.stringify(data_central);
    $("#holder1").val(data_central);
    console.log(data_central);
    $("#POForm").submit();
    */
    // submit to B-admin for new user
    var new_user_data=check_and_collect_values22("#tabmain-user");
    console.log(new_user_data);
    if(new_user_data.goahead=='yes'){
      new_user_data=JSON.stringify(new_user_data);
      $("#holder4").val(new_user_data);
      $("#POForm-user").submit();
    }

  });
</script>
</body>
</html>