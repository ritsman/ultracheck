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
            <table class="table cen">
                <tr>
                    <th>
                        Create New User
                    </th>
                    <th>
                        <input type="text" name="userPass" id="userPass" class="form-control">
                    </th>
                </tr>
                <tr>
                    <th>
                        User Password
                    </th>
                    <th>
                        <input type="text" name="user" id="user" class="form-control">
                    </th>
                </tr>
            </table>
        </div>
        <div class="accordion" id="accordionExample">
            <h2>Give Access To:</h2>
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
                <table class="table cen2" id="tabmain-central">
                      <tr>
                          <th>Print Barcode
                        </th><td><input type="checkbox" name="printBarcode" title= "printBarcode" id="printBarcode"></td>
                        </tr>
                        <tr>
                          <th>View Barcode
                        </th><td><input type="checkbox" name="viewBarcode" title= "viewBarcode" id="viewBarcode"></td>
                        </tr>
                        <tr>
                          <th>Destroy Barcode
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
                          <th>Inventory -Challan
                        </th><td><input type="checkbox" name="showInventory" title="showInventory" id="showInventory"></td>
                        </tr>
                  </table>
                </div>
              </div>
           
      </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Retail Franchise
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                <table class="table cen2">
                      <tr>
                          <th>Print Barcode
                        </th><th><input type="checkbox" name="printBarcode" id="printBarcode"></th>
                        </tr>
                        <tr>
                          <th>View Barcode
                        </th><th><input type="checkbox" name="viewBarcode" id="viewBarcode"></th>
                        </tr>
                        <tr>
                          <th>Destroy Barcode
                        </th><th><input type="checkbox" name="delBarcode" id="delBarcode"></th>
                        </tr>
                        <tr>
                          <th>Inwards -Fresh Barcode
                        </th><th><input type="checkbox" name="addInventory" id="addInventory"></th>
                        </tr>
                        <tr>
                          <th>Inwards -Transfer from Others
                        </th><th><input type="checkbox" name="addTrans" id="addTrans"></th>
                        </tr>
                        <tr>
                          <th>Inventory -Challan
                        </th><th><input type="checkbox" name="showInventory" id="showInventory"></th>
                        </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Ultra LifeStyle Finance
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
    
    
</body>
</html>