//****************trackIt: from side panel to main navigation panel
	
	function trackIt(elem) {
		var id=$(elem).attr("id");
		var file="../"+id+".php";
		window.open(file);
	}
//clone row function in fabric mod	
	 function cloneRow22(row)
	 {
		//alert(row);
		
			var rowClone=$(row).clone().find('input').val('').end();
			//alert(rowClone);
			rowClone.removeClass('stop');
			var rowlast=$(row).parent().find("tr:last-child");
			$(rowlast).after(rowClone);
   
    }
//clone row and add new row as the last row of the table	
	 function cloneRow22B(row)
	 {
		//alert(row);
		var row2=$(row).parent().find("tr:last-child");
			var rowClone=$(row2).clone().find('input').val('').end();
			
			rowClone=$(rowClone).find('td:not(:has(input))').text('').end();
			//alert(rowClone);
			rowClone.removeClass('stop');
			
			$(row2).after(rowClone);
			$(row2).next().find("td:eq(0) input").focus();
   
    }
//clone row with class named 'cloneit' and add it before last line of the table	where last line is auto total
	 function cloneRow22F(row)
	 {
		//alert(row);
		var row2=$(row).parent().find("tr.cloneit");
			var rowClone=$(row2).clone().find('input').val('').end();
			//alert(rowClone);
			rowClone.removeClass('stop');
			rowClone.removeClass('cloneit');
			$(row).parent().append(rowClone);
			//$(row2).after(rowClone);
   
    }
// remove row function	
		 function removeRow22F(row) {
        //alert(row);
        var rowDel=$(row).parent().find("tr:eq(-2)");
				//alert(rowDel);
       if (rowDel.hasClass('stop')) {
        alert("First Row");
        return false;
       }else{
        rowDel.remove();
       }
        //$(".pageShow2 table tr:nth-last-child(2)").not(".pageShow2 table tr:eq(0)").remove();
         //$(".pageShow2 table tr:eq(1)").remove();
    }
//clone row with autocomplete attached in the new row and add new row as the last row
  function cloneRow22A(row,item,clas,line){
  //alert("kk");
		var rowClone="";
		var row2=$(row).parent().find("tr:eq("+line+")");
		
			rowClone=$(row2).clone().find('input').val('').end();
			rowClone.find('td:not(:has(input))').text("");
		
			//alert(rowClone);
			rowClone.removeClass('stop');
			
			$(row2).after(rowClone);
			//$(row).next().find("td:eq(0) input").css("background","red");
			$(row2).next().find("td:eq(0) input").focus();
			//alert(item);
			$(clas).autocomplete({
				source:item
				});
		
   
     }
//clone row with autocomplete attached in two classes in the new row and add new row as the last row
  function cloneRow22E(row,item,clas,line,clas2,item2){
		var rowClone="";
		var row2=$(row).parent().find("tr:eq("+line+")");
		
			rowClone=$(row2).clone().find('input').val('').end();
			rowClone.find('td:not(:has(input))').text("");
		
			//alert(rowClone);
			rowClone.removeClass('stop');
			
			$(row2).after(rowClone);
			//$(row).next().find("td:eq(0) input").css("background","red");
			$(row2).next().find("td:eq(0) input").focus();
			$(clas).autocomplete({
				source:item
				});
			$(clas2).autocomplete({
				source:item2
				});
		
   
     }
// remove row function	
		 function removeRow22(row) {
        //alert(row);
        var rowDel=$(row).parent().find("tr:nth-last-child(1)");
				//alert(rowDel);
       if (rowDel.hasClass('stop')) {
        alert("First Row");
        return false;
       }else{
        rowDel.remove();
       }
        //$(".pageShow2 table tr:nth-last-child(2)").not(".pageShow2 table tr:eq(0)").remove();
         //$(".pageShow2 table tr:eq(1)").remove();
    }
// remove row function	
		 function removeRow22A(row) {
			var gtotal=0;
        //alert(row);
        var rowDel=$(row).parent().find("tr:nth-last-child(2)");
				//alert(rowDel);
       if (rowDel.hasClass('stop')) {
        alert("First Row");
        return false;
       }else{
        rowDel.remove();
       }
        $("input.odrqty").each(function(){
				var vi=parseInt($(this).val());
				
				if (!isNaN(vi)) {
						gtotal+=vi;
					}
					else{
								gtotal="ERROR";
								return false;
							}
				});
				$("#TQ").text(gtotal);
				$('#TQ').css("font-weight",'bold');
				$('#TQ').css("color",'blue');
			//console.log(gtotal);
    }
  //*********************************function to check values if empty in a table
	
	//table=table name with #****
	function chkEmptyVal(table) {
		var goahead="no";
		 $(table).find("input").each(function(){
            
             var val=$(this).val();
               var msg="<p class='errMsg'>Empty Value</p>";
              
               if (val=="") {
                    if ($(this).siblings().hasClass("errMsg")) {
                         //alert("here");
                         goahead="no";
                         return false;
                    }
                    //alert("afterif");
                    $(this).after(msg);
                    goahead="no";
                    return false;
                    
               }
               else {
                     $(".errMsg").remove();
                    goahead="yes";
										return true;
                     
               }
               
            });
		 return goahead;
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++loadSelect
	  //load select with option values
    function loadselectval(sel,ary,val){
        
        parent.document.getElementById(sel).options.length=1;
        var b=parent.document.getElementById(sel);
        for(var i=0,j=0;i<ary.length;i++,j++){
            b.add(new Option(ary[i],val[j]));
        }
     
    }
	//======================================function used for adding the master entries and increasing the counte
	
	function incode(elem) {
		//activate the  code window
		$("#sup-inp1").prop("disabled",false);
		var va=$(elem).val();
		//alert(va);
		
	}
	function getcode(elem) {
		var sel1=$("#sup-sel1").val();
		var c=[];
			switch (sel1) {
				case "GENERAL":
					c=[99];
					break;
				case "CUSTOMER":
					c=[11,12,13];
					break;
				case "JOBWORKER":
					c=[35,36,37];
					break;
				case "SUPPLIER":
					c=[25,26,27];
					break;
				
				default:
					c=null;
			}
		var codewin=parseInt($(elem).val());
		if ($.inArray(codewin,c)==-1) {
			alert("CODE AND MUSTER?? CATAGORY DO NO MATCH!");
			//console.log(c);
			//console.log(codewin);
			$("#sup-btn1").prop("disabled",true);
			$("#sup-inp1").parent().css("background","red");
			return false;
		}else{
			$("#sup-no").load("increcode.php",{'co':sel1,'precode':codewin});
			$("#sup-btn1").prop("disabled",false);
			$("#sup-inp1").parent().css("background","#fff");
			
		}
		
	}
	//------------------for generating trims code...
	function getcode2(elem) {
		var sel2=$("#sup-inp1").val();
		var cc=sel2.substr(0,2)
		console.log(cc);
		var c=['GN','ST','PT','FT'];
			
	
		if ($.inArray(cc,c)==-1) {
			alert("CODE AND MUSTER CATAGORY DO NO MATCH!");
			//console.log(c);
			//console.log(codewin);
			$("#sup-btn1").prop("disabled",true);
			$("#sup-inp1").parent().css("background","red");
			return false;
		}else{
			$("#sup-no").load("increcode.php",{'co':'TRIMS','precode':sel2});
			$("#sup-btn1").prop("disabled",false);
			$("#sup-inp1").parent().css("background","#fff");
			
		}
		
	}

//----------------------------------------------------------------load the bundle status P2_bnts.php
function loadPack(elem){
	//alert('II');
	var sh=$(elem).val();
	var size=$("#bnts-sel2").val();
	var go=$.inArray(state,process);
	console.log(state);
	console.log(go);
	if ((go==-1)&&(state!='CPACK')) {
		alert("Select FROM");
		return false;
	}
	if (state=="PRESSING") {
		$("#thrower").load("P3_bnts.php",{'sh':sh,'so':so,'state':state,'size':size});
	}else if (state=="PACKING") {
		$("#thrower").load("P4_bnts.php",{'sh':sh,'so':so,'state':state,'size':size});
	}else if ((state=="CPACK")||(state=='FINAL PACKING')) {
		state='FINAL PACKING'
		//alert(state);
		$("#thrower2").html("");
		$("table#PO1").html("");
		$("#thrower2").load("P6_bnts.php",{'sh':sh,'so':so,'state':state,'size':size});
	}
	
	else{
		$("#thrower").load("P2_bnts.php",{'sh':sh,'so':so,'state':state,'size':size});
	}
	
	}
	
	//==============================================================get today date
	function tdt(){
		var d=new Date();
               var date = d.getDate();
               var month = d.getMonth();
							 month++;
               var year = d.getFullYear();
               var dt=date+"/"+month+"/"+year;
							 return dt;
	}
	
	//==================================================clone row with select elements and ist vlaue
	function cloneRow22G(row)
	 {
		//alert(row);
		var row2=$(row).parent().find("tr:last-child");
			var rowClone=$(row2).clone();
			rowClone.find("select").each(function(i){
				//alert(i);
				this.selectedIndex=$(row2).find("select")[i].selectedIndex;
				});
			rowClone=$(row2).clone().find('input').val('').end();
			
			
			//rowClone=$(rowClone).find('td:not(:has(input))').text('').end();
			//alert(rowClone);
			rowClone.removeClass('stop');
			
			$(row2).after(rowClone);
			//$(row2).next().find("td:eq(0) input").focus();
   
    }
