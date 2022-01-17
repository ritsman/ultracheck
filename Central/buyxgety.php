<?php

//echo 'offer Buy X get Y Free';//


?>
<style>
    .dexa{
        width:98%;
        margin-left: auto;
        margin-right: auto;
        margin-top: 2%;
        font-size: 0.8em;
    }
    .red{
        background-color: red;
    }
    .yellow{
        background-color: yellow;
    }
    .green{
        background-color: green;
    }
</style>
<div class="container-fluid fw-bold dexa">
    <div class="row">
        <div class="col"> OFFER NAME: BUY X GET Y FREE</div>
        <div class="col">OFFER CODE: BUYXGETY</div>
       
    </div>
    <div class="row red fs-6">
        <div class="col-md-2 yellow d-flex align-items-center fs-6">
            <label for="buyx">OFFER BUY:</label>
            <input type="text" name="buyx" id="buyx" class="form-control flex-fill">
        </div>
        <div class="col-md-2 green d-flex align-items-center">
            <label for="gety">GET FREE:</label>
            <input type="text" name="gety" id="buyx" class="form-control flex-fill">
        </div>
        <div class="col-md-4 yellow d-flex align-items-center">
            <label for="sel_opt">OUTLET:</label>
            <select name="sel_opt" id="sel_opt" class="form-control flex-fill">
                <option>SELECT</option>
                <option>CENTRAL</option>
            </select>
        </div>
        <div class="col-md-3 green d-flex align-items-center">
            <button class="btn btn-primary mx-1 flex-fill">APPLY</button>
            <button class="btn btn-primary mx-1 flex-fill">REMOVE</button>
            <span class="response"></span>
        </div>

        
       
    </div>

    <!-- series discount on volume -->

    <div class="row mt-2">
        <div class="col"> OFFER NAME: BUY X PCS OF SERIES Y GET DISCOUNT Z%</div>
        <div class="col">OFFER CODE: BUYSERIESX</div>
    </div>
    <div class="row red d-flex mt-2">
        <div class="col-md-2 yellow d-flex align-items-center fs-6">
            <label for="buyx">OFFER BUY:</label>
            <input type="text" name="buyx" id="buyx" class="form-control flex-fill">
        </div>
        <div class="col-md-2 yellow d-flex align-items-center fs-6">
            <label for="series">SERIES:</label>
            <input type="text" name="series" id="series" class="form-control flex-fill grow-1">
        </div>
        <div class="col-md-2 green d-flex align-items-center">
            <label for="gety" class="flex-wrap">DISCOUNT:</label>
            <input type="text" name="gety" id="buyx" class="form-control flex-fill">
        </div>
        <div class="col-md-4 yellow d-flex align-items-center flex-fill">
            <label for="sel_opt">OUTLET:</label>
            <select name="sel_opt" id="sel_opt" class="form-control flex-fill">
                <option>SELECT</option>
                <option>CENTRAL</option>
            </select>
        </div>
        <div class="col-md-2 green d-flex align-items-center">
            <button class="btn btn-primary mx-1 flex-fill">APPLY</button>
            <button class="btn btn-primary mx-1 flex-fill">REMOVE</button>
            <span class="response"></span>
        </div>
       
    </div>


    <!-- artno discount on volume -->

    <div class="row mt-2">
        <div class="col"> OFFER NAME: BUY ARTNO X GET DISCOUNT Z%</div>
        <div class="col">OFFER CODE: BUYARTNOX</div>
    </div>
    <div class="row red d-flex mt-2">
        <div class="col-md-2 yellow d-flex align-items-center fs-6">
            <label for="buyx">OFFER BUY:</label>
            <input type="text" name="buyx" id="buyx" class="form-control flex-fill">
        </div>
        <div class="col-md-2 yellow d-flex align-items-center fs-6">
            <label for="series">ARTNO:</label>
            <input type="text" name="series" id="series" class="form-control flex-fill grow-1">
        </div>
        <div class="col-md-2 green d-flex align-items-center">
            <label for="gety" class="flex-wrap">DISCOUNT:</label>
            <input type="text" name="gety" id="buyx" class="form-control flex-fill">
        </div>
        <div class="col-md-4 yellow d-flex align-items-center flex-fill">
            <label for="sel_opt">OUTLET:</label>
            <select name="sel_opt" id="sel_opt" class="form-control flex-fill">
                <option>SELECT</option>
                <option>CENTRAL</option>
            </select>
        </div>
        <div class="col-md-2 green d-flex align-items-center">
            <button class="btn btn-primary mx-1 flex-fill">APPLY</button>
            <button class="btn btn-primary mx-1 flex-fill">REMOVE</button>
            <span class="response"></span>
        </div>
       
    </div>

     <!-- artno discount on volume -->

     <div class="row mt-2">
        <div class="col"> OFFER NAME: BUY BARCODE X GET DISCOUNT Z%</div>
        <div class="col">OFFER CODE: BUYBARCODEX</div>
    </div>
    <div class="row red d-flex mt-2">
        <div class="col-md-2 yellow d-flex align-items-center fs-6">
            <label for="buyx">OFFER BUY:</label>
            <input type="text" name="buyx" id="buyx" class="form-control flex-fill">
        </div>
        <div class="col-md-2 yellow d-flex align-items-center fs-6">
            <label for="series">BARCODE:</label>
            <input type="text" name="series" id="series" class="form-control flex-fill grow-1">
        </div>
        <div class="col-md-2 green d-flex align-items-center">
            <label for="gety" class="flex-wrap">DISCOUNT:</label>
            <input type="text" name="gety" id="buyx" class="form-control flex-fill">
        </div>
        <div class="col-md-4 yellow d-flex align-items-center flex-fill">
            <label for="sel_opt">OUTLET:</label>
            <select name="sel_opt" id="sel_opt" class="form-control flex-fill">
                <option>SELECT</option>
                <option>CENTRAL</option>
            </select>
        </div>
        <div class="col-md-2 green d-flex align-items-center">
            <button class="btn btn-primary mx-1 flex-fill">APPLY</button>
            <button class="btn btn-primary mx-1 flex-fill">REMOVE</button>
            <span class="response"></span>
        </div>
       
    </div>
</div>