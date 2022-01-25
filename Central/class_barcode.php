<?php

class Barcode{
    private $ret_data=[];
    private $tname;
    private $dbcon;
    private $barcode;
    private $seriescat=[];
    private $series1=[
        'A'=>'ANTHAM',
        'B'=>'BERLIN',
        'C'=>'CAIRO',
        'D'=>'DURBAN',
        'E'=>'EPIC',
        'F'=>'FLY',
        'U'=>'UBER',
        'H'=>'HOST',
        'I'=>'INOX',
        'J'=> 'JOR',
        'K'=>'KEVIN',
        'L'=>'LUCAS',
        'M'=>'MOON',
        'O'=>'OPUS',
        'P'=>'PLUS',
        'Q'=>'QUARK',
        'V'=>'VOLT',
        'W'=>'WINE',
        'N'=>'NENO',
        'T'=>'TRACK',
        'Z'=>'ZOOM',
        'S'=>'SIGMA',
        'R'=>'REMO'
        
    
    ];
    private $series2=[
        
        'A'=>'ALEXA',
        'B'=>'BELLY',
        'C'=>'CHAMU',
        'D'=>'DIVA',
        'U'=>'UBER F',
        'E'=>'ERA',
        'F'=>'FURRY',
        'G'=>'GAMA',
        'H'=>'HEXA',
        'P'=>'PLAZZO',
        'I'=>'IKIA',
        'J'=>'JAZZ',
        'L'=>'LOWER',
        'K'=>'KENVA',
        'R'=>'RIVA',
        'M'=>'MEVA',
        'N'=>'NOVA',
        'O'=>'ORRA',
        'P'=>'PEARL',
        'Q'=>'QUEEN',
        'S'=>'SKY',
        'W'=>"WOMEN'S LEGGING",
        'K'=>"K-JEGGINGS"
        
    
    ];

    private $series_boys=[
        'M'=>'MOON JUNIOR',
        'O'=>'OPUS JUNIOR',
        'P'=>'PLUS JUNIOR',
        'Q'=>'QUARK JUNIOR',
        'A'=>'ANTHAM JUNIOR',
        'B'=>'BERLIN JUNIOR',
        'C'=>'CAIRO JUNIOR',
        'D'=>'DURBAN JUNIOR',
        'E'=>'EPIC JUNIOR',
        'J'=>'JOR JUNIOR',
        'V'=>'VOLT JUNIOR'
    ];
    private $series_girls=[
        'K'=>'KENVA JUNIOR',
        'R'=>'RIVA JUNIOR',
        'M'=>'MEVA JUNIOR',
        'N'=>'NOVA JUNIOR',
        'A'=>'ALEXA JUNIOR',
        'B'=>'BELLY JUNIOR',
        'C'=>'CHAMU JUNIOR',
        'D'=>'DIVA JUNIOR',
        'E'=>'ERA JUNIOR',
        'I'=>'IKIA JUNIOR',
        'G'=>'GAMA JUNIOR',
        'J'=>'JAZZ JUNIOR',
        'F'=>'FURRY JUNIOR'
    ];
    private $series_little=[
        'K'=>'KENVA KIDS',
        'R'=>'RIVA KIDS',
        'M'=>'MEVA KIDS',
        'N'=>'NOVA KIDS',
        'A'=>'ALEXA KIDS',
        'B'=>'BELLY KIDS',
        'C'=>'CHAMU KIDS',
        'D'=>'DIVA KIDS',
        'G'=>'GAMA KIDS',
        'I'=>'IKIA KIDS',
        'J'=>'JAZZ KIDS',
        'E'=>'ERA KIDS',
        'F'=>'FURRY KIDS'
    ];
    private $series_kids=[
        'M'=>'MOON KIDS',
        'O'=>'OPUS KIDS',
        'P'=>'PLUS KIDS',
        'Q'=>'QUARK KIDS',
        'A'=>'ANTHAM KIDS',
        'B'=>'BERLIN KIDS',
        'C'=>'CAIRO KIDS',
        'D'=>'DURBAN KIDS',
        'E'=>'EPIC KIDS',
        'J'=>'JOR KIDS',
        'V'=>'VOLT KIDS',
        'W'=>'WINE KIDS',
        'N'=>'NENO KIDS',
        'T'=>'TRACK KIDS',
        'Z'=>'ZOOM KIDS'
    ];

    private $series_acc=[
        'A'=>'APRON',
        'B'=>'BAGS',
    ];

    private $series_madeups=[
        'RE'=>'RESTMORE',
        'AR'=>'ARTISAN',
        'AZ'=>'AZURE',
        'SA'=>'SANTORINI',
        'TI'=>'TINSEL',
        'PR'=>'PRISTINE',
        'MA'=>'MAGESTIC',
        'EP'=>'EPIC',
        'TU'=>'TUSSAH',
        'TW'=>'TWILIGHT',
        'B1'=>'B1 BATH TOWEL',
        'BA'=>'BATH TOWEL',
        'TO'=>'TOWEL BABY',
        'NA'=>'NAPKIN HAND',
        'FA'=>'FACE NAPKIN',
        'HA'=>'HANDKERCHIEF',
        'BE'=>'BELLEZZA',
        'PI'=>'PINKPEONY',
        
        
        
        
        
        
    ];
    //=================================================CATAGORY....WATCH
    private $men_cat=[
        'A'=>"MEN'S JEANS",
        'B'=>"MEN'S JEANS",
        'C'=>"MEN'S JEANS",
        'D'=>"MEN'S JEANS",
        'E'=>"MEN'S JEANS",
        'F'=>"MEN'S JACKET",
        'U'=>"MEN'S JEANS",
        'H'=>"MEN'S SHIRT",
        'I'=>"MEN'S SHIRT",
        'J'=>"MEN'S SHIRT",
        'K'=>"MEN'S SHIRT",
        'L'=>"MEN'S SHIRT",
        'M'=>"MEN'S T-SHIRT",
        'O'=>"MEN'S T-SHIRT",
        'P'=>"MEN'S T-SHIRT",
        'Q'=>"MEN'S T-SHIRT",
        'V'=>"MEN'S SHORTS",
        'W'=>"MEN'S SHORTS",
        'N'=>"MEN'S SHORTS",
        'T'=>"MEN'S TRACK",
        'Z'=>"MEN'S BOXER",
        'S'=>"MEN'S FORMAL",
        'R'=>"MEN'S CASUAL"
       
    ];
    private $women_cat=[
        'A'=>"WOMEN'S JEANS",
        'B'=>"WOMEN'S JEANS",
        'C'=>"WOMEN'S JEANS",
        'D'=>"WOMEN'S JEANS",
        'U'=>"WOMEN'S JEANS",
        'E'=>"WOMEN'S KURTI",
        'F'=>"WOMEN'S KURTI",
        'G'=>"WOMEN'S KURTI",
        'H'=>"WOMEN'S KURTI",
        'P'=>"WOMEN'S PLAZO",
        'I'=>"WOMEN'S SHORTS",
        'J'=>"WOMEN'S SHORTS",
        'L'=>"WOMEN'S LOWER",
        'K'=>"WOMEN'S T-SHIRT",
        'R'=>"WOMEN'S T-SHIRT",
        'M'=>"WOMEN'S T-SHIRT",
        'N'=>"WOMEN'S T-SHIRT",
        'O'=>"WOMEN'S SHIRT",
        'P'=>"WOMEN'S SHIRT",
        'Q'=>"WOMEN'S SHIRT",
        'S'=>"WOMEN'S JACKET",
        'W'=>"WOMEN'S LOWER",
        'K'=>"WOMEN'S LOWER"
        
    
    ];

    private $boys_cat=[
        'M'=>"BOY'S T-SHIRT",
        'O'=>"BOY'S T-SHIRT",
        'P'=>"BOY'S T-SHIRT",
        'Q'=>"BOY'S T-SHIRT",
        'A'=>"BOY'S JEANS",
        'B'=>"BOY'S JEANS",
        'C'=>"BOY'S JEANS",
        'D'=>"BOY'S JEANS",
        'E'=>"BOY'S JEANS",
        'J'=>"BOY'S SHIRT",
        'V'=>"BOY'S SHORTS",
        'W'=>"BOY'S SHORTS",
        'N'=>"BOY'S SHORTS",
        'T'=>"BOY'S TRACK"
        
    ];
    private $girls_cat=[
        'K'=>"GIRL'S T-SHIRT",
        'R'=>"GIRL'S T-SHIRT",
        'M'=>"GIRL'S T-SHIRT",
        'N'=>"GIRL'S T-SHIRT",
        'A'=>"GIRL'S JEANS",
        'B'=>"GIRL'S JEANS",
        'C'=>"GIRL'S JEANS",
        'D'=>"GIRL'S JEANS",
        'I'=>"GIRL'S SHORTS",
        'E'=>"GIRL'S FROCK",
        'G'=>"GIRL'S SKIRT",
        'J'=>"GIRL'S SHORTS",
        'F'=>"GIRL'S FROCK"
    ];
    private $little_cat=[
        'R'=>"LITTLE T-SHIRT",
        'K'=>"LITTLE T-SHIRT",
        'M'=>"LITTLE T-SHIRT",
        'N'=>"LITTLE T-SHIRT",
        'A'=>"LITTLE JEANS",
        'B'=>"LITTLE JEANS",
        'C'=>"LITTLE JEANS",
        'D'=>"LITTLE JEANS",
        'G'=>"LITTLE SKIRT",
        'I'=>"LITTLE SHORTS",
        'J'=>"LITTLE SHORTS",
        'E'=>"LITTLE FROCK",
        'F'=>"LITTLE FROCK"
        
    ];

    private $kids_cat=[
        'M'=>"KIDS T-SHIRT",
        'O'=>"KIDS T-SHIRT",
        'P'=>"KIDS T-SHIRT",
        'Q'=>"KIDS T-SHIRT",
        'A'=>"KIDS JEANS",
        'B'=>"KIDS JEANS",
        'C'=>"KIDS JEANS",
        'D'=>"KIDS JEANS",
        'E'=>"KIDS JEANS",
        'J'=>"KIDS SHIRT",
        'V'=>"KIDS SHORTS",
        'W'=>"KIDS SHORTS",
        'N'=>"KIDS SHORTS",
        'T'=>"KIDS TRACK"
    ];//

    private $acc_cat=[
        'A'=>"APRON",
        'B'=>"DENIM BAGS"
    ];
    private $madeups_cat=[
        'Q'=>'QUEEN BED SHEET',
        'K'=>"KING BED SHEET",
        'S'=>"SINGLE BED SHEET",
        'T'=>'TOWEL',
        'N'=>'NAPKIN',
        'H'=>'HANDKERCHIEF'
    ];

    private $fit=[
        'S'=>'SLIM',
        'C'=>'COMFORT',
        'R'=>'REGULAR'

    ];


    public function __construct($bc)
    {
        $this->barcode=intval($bc);
        $this->tname=intval(substr($this->barcode,1,5))."_stk";
        // get db
        $this->DBH=$this->con("ultrainv");
        
    }



    //------------------------------------------------------------------
	// get connected
	private function con($dbname){
		
		try{
			
				$this->dbcon=new PDO("mysql:host=127.0.0.1;dbname=$dbname", 'root', 'tipra');
				$this->dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//echo 'Conn established';
				return $this->dbcon;
			
		}catch(PDOException $e){
			echo $e->getMessage();
			echo 'COn failed';
		}
		
		
    }
    //---------------------------------------------------------------------
    


    


    // check if the barcode exists
    private function get_bar_data($tname,$dataM){
        $bar_data=[];
        $q2="select * from $tname where barcode='$dataM'";
        $stm=$this->DBH->prepare($q2);
        try {
            
            $stm->execute();
            if($stm->rowCount()>0){
                $bar_data=$stm->fetch(PDO::FETCH_ASSOC);
            }else{
                $bar_data=null;
                
            }
        } catch (PDOException $th) {
            //throw $th;
            //echo $th->getMessage();
        }
        return $bar_data;

    }

    // get barmain data
    private function get_bar_maindata($tname){
        $data=[];
        $q="select * from `Q__artno__sz` where `tname`='$tname'";
        $stm=$this->DBH->prepare($q);
        try {
            $stm->execute();
            $data=$stm->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $th) {
            echo $th->getMessage();
        }
        return $data;
    }


    // get series & catagory of barcode
    private function get_seriesandcat(){
        $data=$this->get_bar_maindata($this->tname);
        if($data['artno'][1]==='M'){
            $this->seriescat['sseries']=$this->series1;
            $this->seriescat['cat']=$this->men_cat;
        }else if($data['artno'][1]==='W'){
            $this->seriescat['sseries']=$this->series2;
            $this->seriescat['cat']=$this->women_cat;
        }else if($data['artno'][1]==='B'){
            $this->seriescat['sseries']=$this->series_boys;
            $this->seriescat['cat']=$this->boys_cat;
        }else if($data['artno'][1]==='G'){
            $this->seriescat['sseries']=$this->series_girls;
            $this->seriescat['cat']=$this->girls_cat;
        }else if($data['artno'][1]==='L'){
            $this->seriescat['sseries']=$this->series_little;
            $this->seriescat['cat']=$this->little_cat;
        }else if($data['artno'][1]==='K'){
            $this->seriescat['sseries']=$this->series_kids;
            $this->seriescat['cat']=$this->kids_cat;
        }else if($data['artno'][1]==='A'){
            $this->seriescat['sseries']=$this->series_acc;
            $this->seriescat['cat']=$this->acc_cat;
        }else if($data['artno'][1]==='D'){
            $this->seriescat['sseries']=$this->series_madeups;
            $this->seriescat['cat']=$this->madeups_cat;
        }
        return 0;
    }
    // get mrp
    private function get_mrp($series){
        $q5="select mrp from Q__seriesmrp where series ='".addslashes($series)."'";
        $stm=$this->DBH->prepare($q5);
        try {
            
            $stm->execute();
            $mrp=$stm->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $th) {
            //throw $th;
            echo $th->getMessage();
        }
        return $mrp['mrp'];
    }
    // get mrp for outsource model recorded
    private function get_mrp_os($series,$artno,$sz,$gpo){
        //echo "SERIES:".$series."--";
        $q5="select mrp from Q__os__madeups where series ='$series' and artno='$artno' and sz='$sz' and pono='$gpo'";
        //echo $q5;
        
        $stm=$this->DBH->prepare($q5);
        try {
            
            $stm->execute();
            $mrp=$stm->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $th) {
            //throw $th;
            echo $th->getMessage();
        }
        return $mrp['mrp'];
    }
    // get recorded mrp in stock table
    


    // display the info outside

    public function get_Barcode_data(){
        $ret_data=[];

        $bar_data=$this->get_bar_data($this->tname,$this->barcode);
        if(is_null($bar_data)){
            $ret_data['barcode']='';
            $ret_data['sono2']="BARCODE :$this->barcode NOT FOUND";
            //echo 'NONO';
        }else{
            $data=$this->get_bar_maindata($this->tname);
           
            $this->get_seriesandcat();
            $ret_data['sono2']=$data['sono2'];
            $ret_data['artno']=$data['artno'];
            $ret_data['sz']=$data['sz'];
            $ret_data['shade']=$data['shade'];
            
            $ret_data['pkd']=$bar_data['pkd'];
            $ret_data['barcode']=$bar_data['barcode'];
            $ret_data['inseam']=$bar_data['inseam'];
            $ret_data['cat']=$this->seriescat['cat'][$data['artno'][2]];
            //change done for gpo module
            if($data['shade']=='MADEUPS'){
                
                $re=$data['artno'][3].$data['artno'][4];
                //echo 'RE:'.$re."__R";
                $ret_data['series']=$this->seriescat['sseries'][$re];
                $ret_data['fit']='REGULAR';
                $ret_data['szcm']='';
                $ret_data['mrp']=$this->get_mrp_os($ret_data['series'],$data['artno'],$data['sz'],$data['sono2']);
            }else{
                $ret_data['series']=$this->seriescat['sseries'][$data['artno'][2]];
                $ret_data['fit']=$this->fit[$data['artno'][6]];
                $ret_data['szcm']=$bar_data['szcm'];
                $ret_data['mrp']=$this->get_mrp($ret_data['series']);
            }
            
            $ret_data['tname']=$this->tname;
            $ret_data['qty']=1;
            
            
            

            $ret_data['location']='CENTRAL';
        }
        
        return $ret_data;
    }

    public function get_cat(){
        $bar_data=$this->get_bar_data($this->tname,$this->barcode);
        if(is_null($bar_data)){
            $ret_data['barcode']='';
            $ret_data['sono2']="BARCODE :$this->barcode NOT FOUND";
            $cat="NA";
            //echo 'NONO';
        }else{
            $data=$this->get_bar_maindata($this->tname);
            
            $this->get_seriesandcat();
            $cat=$this->seriescat['cat'][$data['artno'][2]];
        }
        return $cat;
        

    }
    



}// END OF CLASSS 


// $b=new Barcode(100437000004);

// $c=$b->get_Barcode_data();
// var_export($c);
// echo '<hr>';


?>