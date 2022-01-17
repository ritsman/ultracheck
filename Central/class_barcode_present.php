<?php
include 'class_barcode.php';

class BarcodeCheck extends Barcode{
    private $inv_table;
    private $store;
    private $barcode;
    private $msg;
    private $defaultDiscount=0;
    private $goahead='NO';
    private $insertData=[];
    public function __construct($bc,$inv_table)
    {
        $this->inv_table=$inv_table;
        $this->store=substr($inv_table,8);
        $this->barcode=$bc;
       
        parent::__construct($bc);

        $this->set_discount();

        
    }
    // set default discount
    private function set_discount(){
        $q="select discount from `Q__series_defaultdiscount` where outlet='".$this->store."'";
        $stm=$this->DBH->prepare($q);
        try {
            $stm->execute();
            $d=$stm->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $th){
            echo $th->getMessage();
            $d['discount']=0;
        }
        $this->defaultDiscount=$d['discount'];
        return $d['discount'];
    }
    public function check_barcode(){
        $ret_data=[];
        // check if the barcode is already in inventory of central;;;
        $dataM=$this->barcode;
        $inv_table2=$this->inv_table;
        $q="select * from `$inv_table2` where barcode='$dataM'";
        //echo "<br>22".$q;
        
        $stm=$this->DBH->prepare($q);
        try {
            $stm->execute();
            if($stm->rowCount()>0){
                //echo 'OOOO';
                $ret_data['barcode']='';
                $ret_data['sono2']="<span style=\"color:red;\">BARCODE: $dataM ALREADY IN $this->store WAREHOUSE!</span>";
                
               
                
                
            }else{
                //echo 'PPPP';
                // parent method
                //$mrp=$stm->fetch(PDO::FETCH_ASSOC);
                //var_export($mrp);
                $ret_data=$this->get_Barcode_data();
                $this->insertData=$this->get_Barcode_data();
                //$ret_data['mrp']=parent::get_mrp($ret_data['series']);
                $this->goahead='YES';
            }
            
        } catch (PDOException $th) {
            //throw $th;
            echo $th->getMessage();
            
        }
        return $ret_data;

    }
    // get dynamic discount from  Q__seriesdiscount
    private function get_discount($series,$outlet){
        $q="select discount from `Q__seriesdiscount` where series='".addslashes($series)."' and outlet='$outlet'";
        //echo $q;
        $stm=$this->DBH->prepare($q);
        try {
            $stm->execute();
           
            if($stm->rowCount()==0){
                $d['discount']=$this->defaultDiscount;
            }else{
                $d=$stm->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $th) {
            //throw $th;
            $d['discount']=$this->defaultDiscount;
            //echo $th->getMessage();
        }
        return $d['discount'];

    }

    public function check_barcode_out(){
        $ret_data=[];
        // check if the barcode is in inventory of central;;;
        $dataM=$this->barcode;
        $inv_table2=$this->inv_table;
        if($inv_table2!=='Q__stk__CENTRAL'){
            $q="select * from `$inv_table2` where barcode='$dataM' and status='CONFM'";
        }else{
            $q="select * from `$inv_table2` where barcode='$dataM' and status!='TRANSIT'";
        }
        
        //echo $q;
        
        $stm=$this->DBH->prepare($q);
        try {
            $stm->execute();
            if($stm->rowCount()==0){
                //echo 'OOOO';
                $ret_data['barcode']='';
                $ret_data['sono2']="<span style=\"color:red;\">BARCODE: $dataM NOT FOUND IN $this->store WAREHOUSE!</span>";
                
               
                
                
            }else{
                //echo 'PPPP';
                $mrp=$stm->fetch(PDO::FETCH_ASSOC);
                $ret_data=$this->get_Barcode_data();
                $ret_data['discount']=$this->get_discount($ret_data['series'],$this->store);
                //$ret_data['offer']=$this->get_series_offer($ret_data['series'],$this->store);
                $this->insertData=$this->get_Barcode_data();
                $this->insertData['mrp']=$mrp['mrp'];
                $ret_data['mrp']=$mrp['mrp'];
                $this->goahead='YES';
            }
            
        } catch (PDOException $th) {
            //throw $th;
            echo $th->getMessage();
            
        }
        return $ret_data;

    }
    // check barcode in case of return sales;;
    public function check_barcode_rt(){
        $ret_data=[];
        // check if the barcode is already in inventory of central;;;
        $dataM=$this->barcode;
        $inv_table2=$this->inv_table;
        $q="select * from `$inv_table2` where barcode='$dataM'";
        //echo $q;
        
        $stm=$this->DBH->prepare($q);
        try {
            $stm->execute();
            if($stm->rowCount()==0){
                //echo 'OOOO';
                $ret_data['barcode']='';
                $ret_data['sono2']="<span style=\"color:red;\">BARCODE: $dataM NOT SOLD FROM $this->store WAREHOUSE!</span>";
                
               
                
                
            }else{
               
                //echo 'PPPP';
                //$ret_data=$this->get_Barcode_data();
                //$this->insertData=$this->get_Barcode_data();
                //$this->goahead='YES';

                //$mrp=$stm->fetch(PDO::FETCH_ASSOC);
                $ret_data1=$this->get_Barcode_data();
               //var_export($ret_data1);
               //return false;
                $this->insertData=$this->get_Barcode_data();
                $ret_data2=$stm->fetch(PDO::FETCH_ASSOC);
                //$this->insertData['mrp']=$mrp['mrp'];
                $ret_data=array_merge($ret_data1,$ret_data2);
                $this->goahead='YES';

            }
            
        } catch (PDOException $th) {
            //throw $th;
            echo $th->getMessage();
            
        }
        return $ret_data;

    }
        //get recorded mrp from wherever the stock is

        public function get_rec_mrp($bc){
            $q="select mrp from `Q__stk__CENTRAL` where barcode='$bc'";
            $stm=$this->DBH->prepare($q);
            try {
                $stm->execute();
                $mrp2=$stm->fetch(PDO::FETCH_ASSOC);
            }catch(PDOException $th){
                echo $th->getMessage();
                $mrp2['mrp']=0;
            }
            return $mrp2['mrp'];

        }


    // insert into inventory table
    public function insert_inventory($rack){
        $location=$this->inv_table;
        $this->check_barcode();
        $this->insertData['location']=$rack;
        $this->insertData['status']="START";
        $this->insertData['mrp']=$this->get_rec_mrp($this->barcode);
        //var_export($this->goahead);
        //var_export($this->insertData);
        //echo '<hr>';
        if($this->goahead==='YES'){
            $q="insert ignore into `$location`";
            $q.="(`sono2`,`artno`,`sz`,`shade`,`szcm`,`pkd`,`barcode`,`inseam`,`cat`,`series`,`tname`,`qty`,`location`,`mrp`,`status`,`fit`)";
            $q.="values(:sono2,:artno,:sz,:shade,:szcm,:pkd,:barcode,:inseam,:cat,:series,:tname,:qty,:location,:mrp,:status,:fit)";
    
            $stm=$this->DBH->prepare($q);
            try {
                //unset($this->insertData['discount']);
                $stm->execute($this->insertData);
                $this->msg.="a";
                
            } catch (PDOException $th) {
                //throw $th;
                echo $th->getMessage();
                $this->msg.="1@".$th->getMessage()."<br>".$q;
                $this->msg.=var_export($this->insertData);
            }
        }
        return $this->msg;
        
    }
    // insert fresh barcode getting mrp from q_mrpseries
    // insert into inventory table
    public function insert_inventory_fresh($rack){
        $location=$this->inv_table;
        $this->check_barcode();
        $this->insertData['location']=$rack;
        $this->insertData['status']="START";
        //$this->insertData['mrp']=$this->get_rec_mrp($this->barcode);
        //var_export($this->goahead);
        //var_export($this->insertData);
        //echo '<hr>';
        if($this->goahead==='YES'){
            $q="insert ignore into `$location`";
            $q.="(`sono2`,`artno`,`sz`,`shade`,`szcm`,`pkd`,`barcode`,`inseam`,`cat`,`series`,`tname`,`qty`,`location`,`mrp`,`status`,`fit`)";
            $q.="values(:sono2,:artno,:sz,:shade,:szcm,:pkd,:barcode,:inseam,:cat,:series,:tname,:qty,:location,:mrp,:status,:fit)";
    
            $stm=$this->DBH->prepare($q);
            try {
                //unset($this->insertData['discount']);
                $stm->execute($this->insertData);
                $this->msg.="a";
                
            } catch (PDOException $th) {
                //throw $th;
                echo $th->getMessage();
                $this->msg.="1@".$th->getMessage()."<br>".$q;
                $this->msg.=var_export($this->insertData);
            }
        }
        return $this->msg;
        
    }





     // re_insert into inventory table
     public function insert_inventory_rt($rack){
        $location=$this->inv_table;
        $this->check_barcode();
        $this->insertData['location']=$rack;
        $this->insertData['status']="CONFM";
        //$this->insertData['mrp']=$this->get_rec_mrp($this->barcode);
        //var_export($this->goahead);
        //var_export($this->insertData);
        //echo '<hr>';
        if($this->goahead==='YES'){
            $q="insert ignore into `$location`";
            $q.="(`sono2`,`artno`,`sz`,`shade`,`szcm`,`pkd`,`barcode`,`inseam`,`cat`,`series`,`tname`,`qty`,`location`,`mrp`,`status`,`fit`)";
            $q.="values(:sono2,:artno,:sz,:shade,:szcm,:pkd,:barcode,:inseam,:cat,:series,:tname,:qty,:location,:mrp,:status,:fit)";
    
            $stm=$this->DBH->prepare($q);
            try {
                $stm->execute($this->insertData);
                $this->msg.="a";
                
            } catch (PDOException $th) {
                //throw $th;
                echo $th->getMessage();
                $this->msg.="1@";
            }
        }
        return $this->msg;
        
    }
}//END OF CLASS



// $b=new BarcodeCheck(100004000030,'Q__stk__CENTRAL');

// $c=$b->check_barcode();
// var_export($c);
// echo '<hr>';
?>