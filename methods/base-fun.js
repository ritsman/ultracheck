/*
 * these functions primarily server the base3.php and general functions earlier in inc/base.php file
 */

/*
 * -7--------------nav bar function ;;navaux && page-nav
 */

function track(ele) {

    var id = $(ele).attr("id");
    var pid=$(ele).parent().parent().attr("id");
    //alert(pid);
    var exeno=$(ele).attr("title");
    //alert(exeno);
    console.log(window.location.pathname);
    var goahead=chk_permission(id);
    if(goahead=='yes'){
        var file = id + ".php";
        $(ele).addClass("bkch");
        $(ele).parent().siblings().find("a").removeClass("bkch");
        var di='<div class="loader"></div>';
        $("#pageContent").html('');
        if(pid!=='aux-ul'){
            $("#auxnav").html('');
        }


        $("#pageContent").html(di);
        $("#pageContent").load(file,{param:exeno},function(res,status){
            //console.log(res);
            if(status!='success'){
                $("#pageContent").html("FILE NOT FOUND!");
            }
        });

    }else{
        //$("#pageContent").html("PERMISSION DENIED,CONTACT ADMIN!");
        $("#pageContent").load("../methods/denial.html"); //load modal file for denial here
    }
    
}

function chk_permission(file){
    var goahead='yes';
    
    $.ajax({
  type: 'POST',
  url: "../inc/chk_file.php",
  data: {file:file},
  success: function(data){
      //alert("success");
      console.log('chkfile')
      console.log(data);
      goahead=data;
  },
  
 async:false
});
    //console.log(goahead);
   return goahead;
}
//==============================================for loading from side bar
function track2(ele) {

    var id = $(ele).attr("id");
    var pid=$(ele).parent().parent().attr("id");
    //alert(pid);
    var exeno=$(ele).attr("title");
    //alert(exeno);
    var goahead=chk_permission(id);
    if(goahead=='yes'){
        var file = id + ".php";
        $(ele).addClass("bkch");
        $(ele).parent().siblings().find("a").removeClass("bkch");
        var di='<div class="loader"></div>';
        $("#sidebardiv").html('');
        if(pid!=='aux-ul'){
            $("#auxnav").html('');
        }


        $("#sidebardiv").html(di);
        $("#sidebardiv").load(file,{param:exeno},function(res,status){
            //console.log(res);
            if(status!='success'){
                $("#sidebardiv").html("FILE NOT FOUND!");
            }
        });

    }else{
        $("#sidebardiv").html("PERMISSION DENIED,CONTACT ADMIN!");
    }
    
}

//===================function used for adding the customer/vendor::master entries and increasing the counte

function incode(elem) {
    //activate the  code window
    $("#sup-inp1").prop("disabled", false);
    var va = $(elem).val();
    //alert(va);

}
function getcode(elem) {
    var sel1 = $("#sup-sel1").val();
    var c = [];
    switch (sel1) {
        case "GENERAL":
            c = [99];
            break;
        case "CUSTOMER":
            c = [11, 12, 13];
            break;
        case "JOBWORKER":
            c = [35, 36, 37];
            break;
        case "SUPPLIER":
            c = [25, 26, 27];
            break;

        default:
            c = null;
    }
    var codewin = parseInt($(elem).val());
    if ($.inArray(codewin, c) == -1) {
        alert("CODE AND MUSTER CATAGORY DO NO MATCH!");
        //console.log(c);
        //console.log(codewin);
        $("#sup-btn1").prop("disabled", true);
        $("#sup-inp1").parent().css("background", "red");
        return false;
    } else {
        $("#sup-no").load("increcode.php", {'co': sel1, 'precode': codewin});
        $("#sup-btn1").prop("disabled", false);
        $("#sup-inp1").parent().css("background", "#fff");

    }

}
//------------------for generating trims code...
function getcode2(elem) {
    var sel2 = $("#sup-inp1").val();
    var cc = sel2.substr(0, 2)
    console.log(cc);
    var c = ['GN', 'ST', 'PT', 'FT', 'PN', 'WS', 'EM', 'BO'];


    if ($.inArray(cc, c) == -1) {
        alert("CODE AND MUSTER CATAGORY DO NO MATCH!");
        //console.log(c);
        //console.log(codewin);
        $("#sup-btn1").prop("disabled", true);
        $("#sup-inp1").parent().css("background", "red");
        return false;
    } else {
        $("#sup-no").load("increcode.php", {'co': 'TRIMS', 'precode': sel2});
        $("#sup-btn1").prop("disabled", false);
        $("#sup-inp1").parent().css("background", "#fff");

    }

}

// this is used by add supp in master module
// clone row and add new row as the last row of the table	
function cloneRow22B(row)
{
    //alert(row);
    var row2 = $(row).parent().find("tr:last-child");
    var rowClone = $(row2).clone().find('input').val('').end();

    rowClone = $(rowClone).find('td:not(:has(input))').text('').end();
    //alert(rowClone);
    rowClone.removeClass('stop');

    $(row2).after(rowClone);
    $(row2).next().find("td:eq(0) input").focus();

}
// this is used by add supp in master module
// remove row function	
function removeRow22(row) {
    //alert(row);
    var rowDel = $(row).parent().find("tr:nth-last-child(1)");
    //alert(rowDel);
    if (rowDel.hasClass('stop')) {
        alert("First Row");
        return false;
    } else {
        rowDel.remove();
    }
    //$(".pageShow2 table tr:nth-last-child(2)").not(".pageShow2 table tr:eq(0)").remove();
    //$(".pageShow2 table tr:eq(1)").remove();
}

/*
 * this function is used in gmtCombo.php file to 
 */
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
     
     //clone row function in fabric mod	
	 function cloneRow22(row)
	 {
		//alert(row);
		
			var rowClone=$(row).clone().find('input').val('').end();
			//alert(rowClone);
			rowClone.removeClass('stop');
			var rowlast=$(row).parent().find("tr:last-child");
			$(rowlast).before(rowClone);
   
    }
     //==============================================================get today date
	function tdt(){
		var d=new Date();
               var date = d.getDate();
               var dl=date.toString().length;
               if(dl<2){
                   date="0"+date;
               }
               //console.log("date:"+typeof date);
               var month = d.getMonth();
                             month++;
                             var dl2=month.toString().length;
                             if(dl2<2){
                                 month="0"+month;
                             }
               var year = d.getFullYear();
               var dt=date+"/"+month+"/"+year;
							 return dt;
	}
        
/*---------------------generate gmt sizes in garment.php-------------------- */ 
    var combosize=0;
   function generate(elem){
    
    var size=$("#gmtsize").val();
    
    if ((size=="")||($.isNumeric(size)==false)) {
        return false;
    }
    
    //alert(size);
    for (var i=0;i<size;i++) {
        var row1="<td><input type='text' class='ratio' id='rat"+i+"'/></td>";
        var row2="<td><input type='text' class='size' id='siz"+i+"'/></td>";
        //$(".pageShow2 tbody tr:nth-last-child(2)").append("<td>text</td>");
        //$(".pageShow2 tbody tr:last").append("<td>text</td>");
        //$(".pageShow2").find('table:eq(1) tr:last').append("<td>text</td>");
        $(".pageShow2").find('table:eq(1) tr:last').append(row1);
        $(".pageShow2").find('table:eq(1) tr:nth-last-child(2)').append(row2);
        $(".pageShow2").find('table:eq(1) tr:last').addClass('rowdy');
        $(".pageShow2").find('table:eq(1) tr:nth-last-child(2)').addClass('rowdy');
        
    }
    $(elem).prop("disabled",true);
    combosize=size;
    //alert(combosize);
    
    }; 

    