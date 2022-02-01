//clone row with autocomplete attached in two classes in the new row and add new row as the last row
//clone with select element in it
  function row_copy(row,item,clas){
      //alert('user');
                var row2=$(row).parent().find("tr:last-child");
                //$(row).css("background","yellow");
		var rowClone=$(row2).clone();
                //console.log(row2);
			rowClone.find("select").each(function(i){
				//alert(i);
				this.selectedIndex=$(row2).find("select")[i].selectedIndex;
				});
			rowClone=$(row2).clone().find('input').val('').end();
			
			
			//rowClone=$(rowClone).find('td:not(:has(input))').text('').end();
			//alert(rowClone);
			rowClone.removeClass('stop');
			
			$(row2).after(rowClone);
                        $(clas).autocomplete({
				source:item
				});
                        rowClone.find('td:not(:has(input),:has(select))').text("");
			$(rowClone).find("td:eq(0) input").focus();
   
     }
 //==========================================================================================    
   function remove_row(row){
      //alert('user');
                var row2=$(row).parent().find("tr:last-child");
                if (row2.hasClass('stop')) {
        alert("First Row");
        return false;
       }else{
        row2.remove();
       }
             }
//========================================================================================

//========================================================================================
//clone row with autocomplete attached in two classes in the new row
// and add new row as the second=last row(when there is total rqd in the last row)
//clone with select element in it
  function row_copy_total(row,item,clas,clas2,item2){
                var row2=$(row).parent().find("tr:eq(-2)");
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
                        $(clas).autocomplete({
				source:item
				});
                        $(clas2).autocomplete({
				source:item2
				});
                        rowClone.find('td:not(:has(input),:has(select))').text("");
			$(rowClone).find("td:eq(0) input").focus();
   
     }
/*===================================get column total========
 * 
 * this function totals the number within the column with mentioned classnames;;
 * it exclude first and last row
 * 
 */
function get_total_column(tablename,classname){
    var gtotal=0;
    var t="#"+tablename;
    var r="#"+tablename+" tr:not(:eq(0),:eq(-1))";
    var k="td input."+classname;
    //console.log(k);
    $(r).each(function(){
        $(this).css("background","yellow");
        $(this).find(k).css("background","red");
        var kt=$(this).find(k).val();
        console.log(kt);
        gtotal=gtotal+parseFloat(kt);
        
    });
    gtotal=gtotal.toFixed();
    $(t).find("tr:eq(-1) td:eq(1)").text(gtotal);
    return gtotal;
}
/*===================================get column total========
 * 
 * this function totals the number within the column with mentioned classnames;;
 * it exclude first and last row
 * post the result in td.td_showtotal
 * put class='exclude not having data to total
 * put class='showtotal in row having td_showtotal to td where to put  total
 * 
 */
function get_total_column2(tablename,classname){
	//alert("user");
    var gtotal=0;
    var t="#"+tablename;
    var r="#"+tablename+" tr:not(tr.exclude)";
	//alert(r);
    var k="td input."+classname;
    console.log(k);
    $(r).each(function(){
        //$(this).css("background","yellow");
        //$(this).find(k).css("background","red");
        var kt=$(this).find(k).val();
        console.log(kt);
        gtotal=gtotal+parseFloat(kt);
        
    });
    gtotal=gtotal.toFixed();
    $(t).find("tr.showtotal").find("td.td_showtotal").text(gtotal);
    return gtotal;
}
/*===================================get column total========
 * 
 * this function totals the number within the column with mentioned classnames;;
 * it exclude first and last row
 * post the result in td.td_showtotal
 * put class='exclude not having data to total
 * put class='showtotal in row having td_showtotal to td where to put  total
 * use this if the value is in text field............
 * 
 */
function get_total_column3(tablename,classname){
	//alert("user");
    var gtotal=0;
    var t="#"+tablename;
    var r="#"+tablename+" tr:not(tr.exclude)";
	//alert(r);
    var k="td."+classname;
    console.log(k);
    $(r).each(function(){
        //$(this).css("background","yellow");
        //$(this).find(k).css("background","red");
        var kt=$(this).find(k).text();
        console.log(kt);
        gtotal=gtotal+parseFloat(kt);
        
    });
    gtotal=gtotal.toFixed(2);
    $(t).find("tr.showtotal").find("td.td_showtotal_text").text(gtotal);
    return gtotal;
}
/*===================================get column total========
 * 
 * this function totals the number within the column with mentioned classnames;;
 * it exclude first and last row
 * post the result in td.td_showtotal
 * put class='exclude not having data to total
 * put class='showtotal in row having td_showtotal to td where to put  total
 * use this if the value is in input field...so that its is editable.........
 * 
 */
function get_total_column4(tablename,classname){
	//alert("user");
    var gtotal=0;
    var t="#"+tablename;
    var r="#"+tablename+" tr:not(tr.exclude)";
	//alert(r);
    var k="td."+classname;
    console.log(k);
    $(r).each(function(){
        //$(this).css("background","yellow");
        //$(this).find(k).css("background","red");
        var kt=$(this).find(k).text();
        console.log(kt);
        gtotal=gtotal+parseFloat(kt);
        
    });
    gtotal=gtotal.toFixed(2);
    $(t).find("tr.showtotal").find("td.td_showtotal_text input#gtotal").val(gtotal);
    return gtotal;
}

/*=============================================get total row
 * 
 * @param {type} tablename
 * @return {check_and_collect_values.data}
 * get total of row input with cclass continaing '&&' and show it in sibling
 * input with class contian qty
 * 
 */
function get_total_row(ele){
    
    var gtotal=0;
    var row=$(ele).parent().parent();
   
    var r=row.find("td input[class*='&&']");
    //console.log("__");
    //console.log(r);
    r.each(function(){
        //$(this).css("background","red");
        var v=$(this).val();
        gtotal=gtotal+parseFloat(v);
    });
    gtotal=gtotal.toFixed();
    row.find("td input[class*='qty']").val(gtotal);
    
}

/*=============================================get total row
 * 
 * @param {type} tablename
 * @return {check_and_collect_values.data}
 * get total of row input with cclass continaing '&&' and show it in sibling
 * input with class contian qty
 * 
 */
function get_total_row_cl(ele,rateclass,resultclass){
    var inp="td input[class*='"+rateclass+"']";
    var result="td."+resultclass
    var gtotal=0;
    var row=$(ele).parent().parent();
   
    var r=row.find(inp);
    //console.log("__");
    //console.log(r);
    r.each(function(){
        //$(this).css("background","red");
        var v=$(this).val();
        gtotal=gtotal+parseFloat(v);
        //console.log(gtotal);
        //console.log(v);
    });
    gtotal=gtotal.toFixed();
    //console.log(gtotal);
    //row.find(result).css("background",'yellow');
    row.find(result).text(gtotal);
    
}

//======================================================================
/*===============================combines the above two functions;;
 * 
 * @param {type} tablename
 * @return {check_and_collect_values.data}
 * get_total_row+get_total_coloum
 */

function update_total(ele,tablename,classname){
    get_total_row(ele);
    get_total_column(tablename,classname);
}
//---------------------------------------------------------
//
//===================================================================================
   function chng_dt_frmt(dt){
       return (dt.split("/").reverse().join("-"));
   }
//-------------------------------------------------
/*
 * this functions collect the values with property attributes from data table
 * 1) table name has to be with id/class for e.g #tabmain,table.class etc
 * 2) table cell td should have 'class' name to serve as property
 *  and dirname='direct' wherever text has to be collected as data
 * 3) input and select element must have title='property' 
 * 4) data would return data.goahead=yes/no for going ahead
 * 5)data format=data[property]=cell value;;
 */
 //===============================================================================
 function check_and_collect_values(tablename){
       var t=tablename+" tr td";
       var data={};
       $(t).each(function(index){
           var ind=$(this).parent().index();
           var prop2=$(this).attr("class");
           //console.log(index+"-"+ind);
           var c=$(this).find("input").length;
           if(c>0){
               data[ind]=data[ind]||{};//save hell of a life here;;;;congrats
               var v=$(this).find("input").val();
               
               var prop=$(this).find("input").attr("title");
               //console.log("input:prop::"+prop);
               var msg="<p class='errMsg'>EMPTY VALUE!</p>";
               if(v==''){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        
                        return false;
                        }else{
                            //data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //-----------------------------change and pickup date in mysql format
                    var n=prop.search("_dt");
                    if(n>0){
                        var vdt=chng_dt_frmt(v);
                        data[ind][prop]=vdt;
                    }else{
                        data[ind][prop]=v;
                    }
                    
                    //take hidden values for e.g id
                    
                }
                
               
           }
       
           //==========================================check for select
           var d=$(this).find("select").length;
           if(d>0){
               data[ind]=data[ind]||{};
               var v=$(this).find("select").val();
               var prop=$(this).find("select").attr("title");
               var msg="<p class='errMsg'>SELECT VALUE!</p>";
               if(v=='SELECT'){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                          data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    data[ind][prop]=v;
                }
               
           }
           
           //==================================check for empty text;;
           
           var h=$(this).attr("dirname");
           
           if(h=='direct'){
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    var prop2=$(this).attr("class");
                    //alert(prop2);
                    var n=prop2.search("_dt");
                    if(n>0){
                        var vdt=chng_dt_frmt(k);
                        data[ind][prop2]=vdt;
                    }else{
                        data[ind][prop2]=k;
                    }
                    
                    //alert(h);
                }
            }
            
            //--------------collect hidden attributes class &&id;;
            if(h=='direct_id'){
                //alert('drie_');
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               if(k==''||k=='EMPTY CELL VALUE!'){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //alert("ifel");
                    var prop2=$(this).attr("class");
                    data[ind][prop2]=k;
                    var prop3=$(this).attr('id');
                    data[ind]['id']=prop3;
                    //alert(h);
                }
            }
           
               

               
           
        });
        
        
        return data;
       
   }
//===================================get itemtype unit value
 function getfabData(elm){
     var v=$(elm).attr("dirname");
     var artno=$(elm).val();
     var itemname=$(elm).parent().prev().find("input.itemName").val();
    // alert(v);
     
  $.get("loadfabdata3.php",{'master':v,'artno':artno,'itemname':itemname},function(data){
      console.log("data:-----------");
      console.log(data);
      
   var data2={};
   try{
       data2=JSON.parse(data);
       $(elm).parent().find(".errMsg").remove();
       $("#collectData2").css("visibility","visible");
   }catch(error){
       //alert("r");
       //console.log(error);
       var msg3="<p class='errMsg'>ITEM NOT FOUND</p>";
       if(!$(elm).siblings().hasClass("errMsg")){
         $(elm).parent().append(msg3);  
         $("#collectData2").css("visibility","hidden");
       }
       //$(elm).css("background","red");
       
       return false;
   }
   console.log("data2:-----------");       
    console.log(data2);
    var data4=[];
    data4['sz']=data2.sz;
    data4['shade']=data2.shade;
    console.log("data4-----------");
    console.log(data4);
   data3=[];
   Object.values(data2).map(function(index,val){
       data3[index]=[];
       console.log(index+"-"+val);
       data3[index].push(val);
   });
   
    console.log("data3:-----------");       
    console.log(data3);
    var sel3="";
    for(i=0;i<data4['sz'].length;i++){
        sel3+="<option >"+data4['sz'][i]+"</option>";
    }
    var sel4="";
    for(i=0;i<data4['shade'].length;i++){
        sel4+="<option >"+data4['shade'][i]+"</option>";
    }
    //$('select').children('option:not(:first)').remove();sel3+="</select>";
    $(elm).parent().siblings("td.td_artsz").find("select.sel_artsz").children('option:not(:first)').remove();
    $(elm).parent().siblings("td.td_artsz").find("select.sel_artsz").append(sel3);
    //$(elm).parent().siblings("td.rate").append(data2.rate);
    $(elm).parent().siblings("td.td_artshade").find("select.sel_artshade").children('option:not(:first)').remove();
    $(elm).parent().siblings("td.td_artshade").find("select.sel_artshade").append(sel4);
    


    
    
   
    });
         
     
 }
    
 

   
//===================================get itemtype unit value
 function getSz(elm){
     var v=$(elm).attr("dirname");
     //alert(v);
     var artno=$(elm).val();
     var itemname=$(elm).parent().prev().find("input.itemName").val();
    // alert(v);
     
  $.get("loadtrims3.php",{'master':v,'artno':artno,'itemname':itemname},function(data){
      console.log("data:-----------");
      console.log(data);
   var data2={};
   try{
       data2=JSON.parse(data);
       $(elm).parent().find(".errMsg").remove();
       $("#collectData2").css("visibility","visible");
   
   console.log("data2:-----------");       
    console.log(data2);
    var data4=[];
    data4['sz']=data2.sz;
    data4['shade']=data2.shade;
    console.log("data4-----------");
    console.log(data4);
   data3=[];
   Object.values(data2).map(function(index,val){
       data3[index]=[];
       console.log(index+"-"+val);
       data3[index].push(val);
   });
   
    console.log("data3:-----------");       
    console.log(data3);
    var sel3="";
    for(i=0;i<data4['sz'].length;i++){
        sel3+="<option >"+data4['sz'][i]+"</option>";
    }
    var sel4="";
    for(i=0;i<data4['shade'].length;i++){
        sel4+="<option >"+data4['shade'][i]+"</option>";
    }
    //$('select').children('option:not(:first)').remove();sel3+="</select>";
    $(elm).parent().siblings("td.td_artsz").find("select.sel_artsz").children('option:not(:first)').remove();
    $(elm).parent().siblings("td.td_artsz").find("select.sel_artsz").append(sel3);
    //$(elm).parent().siblings("td.rate").append(data2.rate);
    $(elm).parent().siblings("td.td_artshade").find("select.sel_artshade").children('option:not(:first)').remove();
    $(elm).parent().siblings("td.td_artshade").find("select.sel_artshade").append(sel4);
}
    
catch(error){
       //alert("r");
       //console.log(error);
       var msg3="<p class='errMsg'>ITEM NOT FOUND</p>";
       if(!$(elm).siblings().hasClass("errMsg")){
         $(elm).parent().append(msg3);  
         $("#collectData2").css("visibility","hidden");
       }
       //$(elm).css("background","red");
       
       return false;
   }

    
    
   
    });
         
     
 }
    
//---------------------------------------------------
//===================================get itemtype unit value
 function getSzShade(elm){
     var v=$(elm).attr("dirname");
     //alert(v);
     var artno=$(elm).val();
     var itemname=$(elm).parent().prev().find("input.itemName").val();
    // alert(v);
     
  $.get("loadtrims4.php",{'master':v,'artno':artno,'itemname':itemname},function(data){
      console.log("data:-----------");
      console.log(data);
   var data2={};
   try{
       data2=JSON.parse(data);
       $(elm).parent().find(".errMsg").remove();
       $("#collectData2").css("visibility","visible");
   
   console.log("data2:-----------");       
    console.log(data2);
    var data4=[];
    data4['sz']=data2.sz;
    data4['shade']=data2.shade;
    console.log("data4-----------");
    console.log(data4);
   data3=[];
   Object.values(data2).map(function(index,val){
       data3[index]=[];
       console.log(index+"-"+val);
       data3[index].push(val);
   });
   
    console.log("data3:-----------");       
    console.log(data3);
    var sel3="";
    for(i=0;i<data4['sz'].length;i++){
        sel3+="<option >"+data4['sz'][i]+"</option>";
    }
    var sel4="";
    for(i=0;i<data4['shade'].length;i++){
        sel4+="<option >"+data4['shade'][i]+"</option>";
    }
    //$('select').children('option:not(:first)').remove();sel3+="</select>";
    $(elm).parent().siblings("td.td_artsz").find("select.sel_artsz").children('option:not(:first)').remove();
    $(elm).parent().siblings("td.td_artsz").find("select.sel_artsz").append(sel3);
    //$(elm).parent().siblings("td.rate").append(data2.rate);
    $(elm).parent().siblings("td.td_artshade").find("select.sel_artshade").children('option:not(:first)').remove();
    $(elm).parent().siblings("td.td_artshade").find("select.sel_artshade").append(sel4);
}
    
catch(error){
       //alert("r");
       //console.log(error);
       var msg3="<p class='errMsg'>ITEM NOT FOUND</p>";
       if(!$(elm).siblings().hasClass("errMsg")){
         $(elm).parent().append(msg3);  
         $("#collectData2").css("visibility","hidden");
       }
       //$(elm).css("background","red");
       
       return false;
   }

    
    
   
    });
         
     
 }
    
 
 
 //===================================get itemtype unit value
 function gonext(elm){
     var sz=$(elm).val();//size
     var artno=$(elm).parent().siblings("td.td_nct").find("input.nct").val();//article no
     var shadeno=$(elm).parent().siblings("td.td_artshade").find("select.sel_artshade").val();
     var master=$(elm).parent().siblings("td.td_nct").find("input.nct").attr('dirname');//sewing
     var itemname=$(elm).parent().siblings("td.td_itemname").find("input.itemname").val();//for eg thread
     //alert(sz+"-"+artno+"="+itemname+"-"+master+"--"+shadeno);
   if(sz=='00'){
       return false;
   }
     
  $.get("loadtrims2.php",{'master':master,'artno':artno,'itemname':itemname,'sz':sz,'shadeno':shadeno},function(data){
      console.log("data:-----------");
      console.log(data);
   var data2={};
   try{
       data2=JSON.parse(data);
       $(elm).parent().find(".errMsg").remove();
       $("#collectData2").css("visibility","visible");
   }catch(error){
       //alert("r");
       //console.log(error);
       var msg3="<p class='errMsg'>ITEM NOT FOUND</p>";
       if(!$(elm).siblings().hasClass("errMsg")){
         $(elm).parent().append(msg3);  
         $("#collectData2").css("visibility","hidden");
       }
       //$(elm).css("background","red");
       
       return false;
   }
    console.log("data2:-----------");       
    console.log(data2);
    $(elm).parent().siblings("td.unit").html('');
    $(elm).parent().siblings("td.rate").html('');
    $(elm).parent().siblings("td.unit").append(data2.unit);
    //$(elm).parent().siblings("td#rate22").find("input#rate23").css("background","yellow");
    $(elm).parent().siblings("td#rate22").find("input#rate23").val(data2.rate);
    delete data2;
    
    
   
    });
         
     
 }


//-------------------------------------------------------get //itemcode
function getC(elm,it) {
  var v=$(elm).val();
  //alert(v);
  
 var tab2=it[v];
 //alert(tab2);
  //alert(v); 
  //$(elm).parent().after().html("RK");
  //$(elm).parent().next().load("loadtrmsingmtcombo.php",{'c':v,'t':'trims'});
  //$(elm).parent().parent().find("td:eq(1)").append().load("loadtrims.php",{'c':v});;

  $.get("loadtrims.php",{'c':v,'tab':tab2},function(data){
      console.log(data);
      
   var data2={};
   try{
       data2=JSON.parse(data);
       $(elm).parent().find(".errMsg").remove();
       $("#collectData2").css("visibility","visible");
   }catch(error){
       //alert("r");
       //console.log(error);
       var msg3="<p class='errMsg'>ITEM NOT FOUND</p>";
       if(!$(elm).siblings().hasClass("errMsg")){
         $(elm).parent().append(msg3);  
         $("#collectData2").css("visibility","hidden");
       }
       //$(elm).css("background","red");
       
       return false;
   }
           
   console.log(data2);
   var st=data2.title;
   console.log(st);
   var itemD=st.search("&&");
   console.log(itemD);
   if(itemD>0){
          console.log('gotout');
          //alert('gotout');
          var tt=st.split("&&");
          var tt22=tt[1];
        $(elm).parent().siblings("td.unit").html('');
        $(elm).parent().siblings("td.rate").html('');
        $(elm).parent().siblings("td.unit").append(data2[0].unit);
        $(elm).parent().siblings("td#rate22").find("input#rate23").val(data2[0].rate);
        $(elm).parent().siblings("td.td_nct").find("input.nct").val(0);
        $(elm).parent().siblings().find("input.nct").attr("dirname",tt22);
        $(elm).parent().siblings("td.td_artshade").find("select").html("<option>SELECT</option><option>00</option>");
        $(elm).parent().siblings("td.td_artsz").find("select").html("<option>SELECT</option><option>00</option>");
    
      }else{
          
          $(elm).parent().siblings().find("input.nct").attr("dirname",data2.title);
            delete data2['title'];
            data3=[];
            Object.values(data2).map(function(val){
                console.log(val);
                data3.push(val);
            });

              $("input.nct").autocomplete({
                  source:data3
              });

   
          
      }
   
    //$(elm).parent().siblings(":has(input.nct)").css("background","red");
    //$(elm).parent().siblings().children().find("input.nct").css("background","red");
   //$(elm).parent().siblings().find("input.nct").css("background","red");
    //$(elm).parent().append(data);
    /*
        var g=$(elm).parent().siblings().find("input.nct");
    $(g).autocomplete({
        source:data
    });
    
    /*
      if ($(elm).parent().next().hasClass("A")) {
        //alert("E");
        $(elm).parent().next().remove(); $(elm).parent().next().remove();
        $(elm).parent().next().remove(); $(elm).parent().next().remove();
        $(elm).parent().next().remove();
      }
    //$(elm).parent().find("td.A").css("background","blue");
    $(elm).parent().after(data);
        */
    });
         
     
}
//===============================================================new thing to load inventory
//-------mm-------------------------------------------------get //itemcode
function get_artno(elm,it) {
  var v=$(elm).val();
  //alert(v);
  
 var tab2=it[v];
 //alert(tab2);
  //alert(v); 
  //$(elm).parent().after().html("RK");
  //$(elm).parent().next().load("loadtrmsingmtcombo.php",{'c':v,'t':'trims'});
  //$(elm).parent().parent().find("td:eq(1)").append().load("loadtrims.php",{'c':v});;

  $.get("get_artno.php",{'c':v,'tab':tab2},function(data){
      console.log(data);
      
   var data2={};
   try{
       data2=JSON.parse(data);
       $(elm).parent().find(".errMsg").remove();
       $("#collectData2").css("visibility","visible");
   }catch(error){
       //alert("r");
       //console.log(error);
       var msg3="<p class='errMsg'>ITEM NOT FOUND</p>";
       if(!$(elm).siblings().hasClass("errMsg")){
         $(elm).parent().append(msg3);  
         $("#collectData2").css("visibility","hidden");
       }
       //$(elm).css("background","red");
       
       return false;
   }
           
   console.log(data2);
   var st=data2.title;
   console.log(st);
   var itemD=st.search("&&");
   console.log(itemD);
   if(itemD>0){
          console.log('gotout');
          //alert('gotout');
          var tt=st.split("&&");
          var tt22=tt[1];
        $(elm).parent().siblings("td.unit").html('');
        $(elm).parent().siblings("td.rate").html('');
        $(elm).parent().siblings("td.unit").append(data2[0].unit);
        $(elm).parent().siblings("td#rate22").find("input#rate23").val(data2[0].rate);
        $(elm).parent().siblings("td.td_nct").find("input.nct").val(0);
        $(elm).parent().siblings().find("input.nct").attr("dirname",tt22);
        $(elm).parent().siblings("td.td_artshade").find("select").html("<option>SELECT</option><option>00</option>");
        $(elm).parent().siblings("td.td_artsz").find("select").html("<option>SELECT</option><option>00</option>");
    
      }else{
          
          $(elm).parent().siblings().find("input.nct").attr("dirname",data2.title);
            delete data2['title'];
            data3=[];
            Object.values(data2).map(function(val){
                console.log(val);
                data3.push(val);
            });

              $("input.nct").autocomplete({
                  source:data3
              });

   
          
      }
   
    //$(elm).parent().siblings(":has(input.nct)").css("background","red");sace biw
    //$(elm).parent().siblings().children().find("input.nct").css("background","red");
   //$(elm).parent().siblings().find("input.nct").css("background","red");
    //$(elm).parent().append(data);
    /*
        var g=$(elm).parent().siblings().find("input.nct");
    $(g).autocomplete({
        source:data
    });
    
    /*
      if ($(elm).parent().next().hasClass("A")) {
        //alert("E");
        $(elm).parent().next().remove(); $(elm).parent().next().remove();
        $(elm).parent().next().remove(); $(elm).parent().next().remove();
        $(elm).parent().next().remove();
      }
    //$(elm).parent().find("td.A").css("background","blue");
    $(elm).parent().after(data);
        */
    });
         
     
}

//===================================get itemtype unit value
 function get_artsize(elm){
     var v=$(elm).attr("dirname");
     //alert(v);
     var artno=$(elm).val();
     var itemname=$(elm).parent().prev().find("input.itemName").val();
    // alert(v);
     
  $.get("get_artsize.php",{'master':v,'artno':artno,'itemname':itemname},function(data){
      console.log("data:-----------");
      console.log(data);
   var data2={};
   try{
       data2=JSON.parse(data);
       $(elm).parent().find(".errMsg").remove();
       $("#collectData2").css("visibility","visible");
   
   console.log("data2:-----------");       
    console.log(data2);
    var data4=[];
    data4['sz']=data2.sz;
    data4['shade']=data2.shade;
    console.log("data4-----------");
    console.log(data4);
   data3=[];
   Object.values(data2).map(function(index,val){
       data3[index]=[];
       console.log(index+"-"+val);
       data3[index].push(val);
   });
   
    console.log("data3:-----------");       
    console.log(data3);
    var sel3="";
    for(i=0;i<data4['sz'].length;i++){
        sel3+="<option >"+data4['sz'][i]+"</option>";
    }
    var sel4="";
    for(i=0;i<data4['shade'].length;i++){
        sel4+="<option >"+data4['shade'][i]+"</option>";
    }
    //$('select').children('option:not(:first)').remove();sel3+="</select>";
    $(elm).parent().siblings("td.td_artsz").find("select.sel_artsz").children('option:not(:first)').remove();
    $(elm).parent().siblings("td.td_artsz").find("select.sel_artsz").append(sel3);
    //$(elm).parent().siblings("td.rate").append(data2.rate);
    $(elm).parent().siblings("td.td_artshade").find("select.sel_artshade").children('option:not(:first)').remove();
    $(elm).parent().siblings("td.td_artshade").find("select.sel_artshade").append(sel4);
}
    
catch(error){
       //alert("r");
       //console.log(error);
       var msg3="<p class='errMsg'>ITEM NOT FOUND</p>";
       if(!$(elm).siblings().hasClass("errMsg")){
         $(elm).parent().append(msg3);  
         $("#collectData2").css("visibility","hidden");
       }
       //$(elm).css("background","red");
       
       return false;
   }

    
    
   
    });
         
     
 }
    



//==================================================clone row function with select
//clone row with autocomplete attached in two classes in the new row and add new row as the last row
  function cloneRow(row,item,clas,clas2,item2){
      //alert("l");
                var row2=$(row).parent().find("tr:last-child");
                //row2.css("background","yellow");
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
                        $(clas).autocomplete({
				source:item
				});
                        rowClone.find('td:not(:has(input),:has(select))').text("");
			$(rowClone).find("td:eq(0) input").focus();
   
     }
     
     
 //-------------------------------------------------
/*
 * this functions collect the values with property attributes from data table
 * 1) table name has to be with id/class for e.g #tabmain,table.class etc
 * 2) table cell td should have 'class' name to serve as property
 *  and dirname='direct' wherever text has to be collected as data
 * 3) input and select element must have title='property' 
 * 4) data would return data.goahead=yes/no for going ahead
 * 5)data format=data[property]=cell value;;//without date format
 */
 //===============================================================================
 function check_and_collect_values22(tablename){
    //alert($(tablename).find("tr").length);
       var t=tablename+" tr td";
       var data={};
       $(t).each(function(index){
           var ind=$(this).parent().index();
           var prop2=$(this).attr("class");
           //console.log(index+"-"+ind);
           var c=$(this).find("input").length;
           if(c>0){
               data[ind]=data[ind]||{};//save hell of a life here;;;;congrats
               var v=$(this).find("input").val();
               var prop=$(this).find("input").attr("title");
               var msg="<p class='errMsg'>EMPTY VALUE!</p>";
               if(v==''){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        
                        return false;
                        }else{
                            //data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    
                        data[ind][prop]=v;
                                        
                    //take hidden values for e.g id
                    
                }
               
           }
           //==========================================check for select
           var d=$(this).find("select").length;
           if(d>0){
               data[ind]=data[ind]||{};
               var v=$(this).find("select").val();
               var prop=$(this).find("select").attr("title");
               var msg="<p class='errMsg'>SELECT VALUE!</p>";
               if(v=='SELECT'){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                          data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    data[ind][prop]=v;
                }
               
           }
           //==================================check for empty text;;
           
           var h=$(this).attr("dirname");
           
           if(h=='direct'){
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               //alert(prop2 + k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //alert(prop2 + k);
                        data[ind][prop2]=k;
                    
                    
                    //alert(h);
                }
            }
            //--------------collect hidden attributes class &&id;;
            if(h=='direct_id'){
                //alert('drie_');
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //alert("ifel");
                    var prop2=$(this).attr("class");
                    data[ind][prop2]=k;
                    var prop3=$(this).attr('id');
                    data[ind]['id']=prop3;
                    //alert(h);
                }
            }
           
           //--------------collect id as property and text as value where class cant be read
           if(h=='direct_half'){
            //alert('drie_');
           data[ind]=data[ind]||{};
           var k=$(this).text();
           var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
           //alert(k);
           if(k==''){
               if(!$(this).children().hasClass('errMsg')){
                    $(this).append(msg);
                    //$(this).parent().css("background","red");
                    data.goahead='no';
                    return false;
                    }else{
                        data.goahead='no';
                        return false;
                    }
            }               
           else{
            $(this).find("p.errMsg").remove();
                data.goahead='yes';
                //alert("ifel");
                var prop2a=$(this).attr("id");
                data[ind][prop2a]=k;
                
                //alert(h);
            }
        }    

               
           
        });
        
        
        return data;
       
   }

//-------------------------------------------------
/*
**********check for input[type=checkbox] postitions
*/
 //===============================================================================
 function check_and_collect_values4a(tablename){
    //alert($(tablename).find("tr").length);
       var t=tablename+" tr td";
       var data={};
       
       // get values of checkbox only, 1 for true, 0 for false;
       $(t).each(function(index){
           var ind=$(this).parent().index();
           
           //console.log(index+"-"+ind);
           var c=$(this).find("input[type='checkbox']").length;
           if(c>0){
               data[ind]=data[ind]||{};//save hell of a life here;;;;congrats
               $(this).css("background","green");
               $(this).find("input[type='checkbox']").css("background","red");
               var v=$(this).find("input[type='checkbox']").prop("checked");
               var prop=$(this).find("input").attr("title");
               var msg="<p class='errMsg'>EMPTY VALUE!</p>";
               if(v){
                    data[ind][prop]=1;
                    
                }else{
                
                    data[ind][prop]=0;
                }
               
           }
           
        });
        
        
        return data;
       
   }

//-------------------------------------------------

//===============================================================================
function get_headline(tablename){
    //alert($(tablename).find("tr").length);
       var t=tablename+" thead tr td";
       var data={};
       $(t).each(function(index){
           var ind=$(this).parent().index();
           var prop2=$(this).attr("class");
           //console.log(index+"-"+ind);
           var c=$(this).find("input").length;
           if(c>0){
               data[ind]=data[ind]||{};//save hell of a life here;;;;congrats
               var v=$(this).find("input").val();
               var prop=$(this).find("input").attr("title");
               var msg="<p class='errMsg'>EMPTY VALUE!</p>";
               if(v==''){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        
                        return false;
                        }else{
                            //data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    
                        data[ind][prop]=v;
                                        
                    //take hidden values for e.g id
                    
                }
               
           }
           //==========================================check for select
           var d=$(this).find("select").length;
           if(d>0){
               data[ind]=data[ind]||{};
               var v=$(this).find("select").val();
               var prop=$(this).find("select").attr("title");
               var msg="<p class='errMsg'>SELECT VALUE!</p>";
               if(v=='SELECT'){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                          data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    data[ind][prop]=v;
                }
               
           }
           //==================================check for empty text;;
           
           var h=$(this).attr("dirname");
           
           if(h=='direct'){
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               //alert(prop2 + k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //alert(prop2 + k);
                        data[ind][prop2]=k;
                    
                    
                    //alert(h);
                }
            }
            //--------------collect hidden attributes class &&id;;
            if(h=='direct_id'){
                //alert('drie_');
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //alert("ifel");
                    var prop2=$(this).attr("class");
                    data[ind][prop2]=k;
                    var prop3=$(this).attr('id');
                    data[ind]['id']=prop3;
                    //alert(h);
                }
            }
           
           //--------------collect id as property and text as value where class cant be read
           if(h=='direct_half'){
            //alert('drie_');
           data[ind]=data[ind]||{};
           var k=$(this).text();
           var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
           //alert(k);
           if(k==''){
               if(!$(this).children().hasClass('errMsg')){
                    $(this).append(msg);
                    //$(this).parent().css("background","red");
                    data.goahead='no';
                    return false;
                    }else{
                        data.goahead='no';
                        return false;
                    }
            }               
           else{
            $(this).find("p.errMsg").remove();
                data.goahead='yes';
                //alert("ifel");
                var prop2a=$(this).attr("id");
                data[ind][prop2a]=k;
                
                //alert(h);
            }
        }    

               
           
        });
        
        
        return data;
       
   }

//-----------------------------------------------
//=============================================================
/*
* new function to collect data from tbody,,,improved version of check and collect values

*/
function c_and_c_val(tablename){
    //alert($(tablename).find("tr").length);
       var t=tablename+" tbody tr td";
       var data={};
       $(t).each(function(index){
           var ind=$(this).parent().index();
           var prop2=$(this).attr("class");
           //console.log(index+"-"+ind);
           var c=$(this).find("input").length;
           if(c>0){
               data[ind]=data[ind]||{};//save hell of a life here;;;;congrats
               var v=$(this).find("input").val();
               var prop=$(this).find("input").attr("title");
               var msg="<p class='errMsg'>EMPTY VALUE!</p>";
               if(v==''){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        
                        return false;
                        }else{
                            //data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    
                        data[ind][prop]=v;
                                        
                    //take hidden values for e.g id
                    
                }
               
           }
           //==========================================check for select
           var d=$(this).find("select").length;
           if(d>0){
               data[ind]=data[ind]||{};
               var v=$(this).find("select").val();
               var prop=$(this).find("select").attr("title");
               var msg="<p class='errMsg'>SELECT VALUE!</p>";
               if(v=='SELECT'){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                          data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    data[ind][prop]=v;
                }
               
           }
           //==================================check for empty text;;
           
           var h=$(this).attr("dirname");
           
           if(h=='direct'){
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               //alert(prop2 + k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //alert(prop2 + k);
                        data[ind][prop2]=k;
                    
                    
                    //alert(h);
                }
            }
            //--------------collect hidden attributes class &&id;;
            if(h=='direct_id'){
                //alert('drie_');
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //alert("ifel");
                    var prop2=$(this).attr("class");
                    data[ind][prop2]=k;
                    var prop3=$(this).attr('id');
                    data[ind]['id']=prop3;
                    //alert(h);
                }
            }
           
           //--------------collect id as property and text as value where class cant be read
           if(h=='direct_half'){
            //alert('drie_');
           data[ind]=data[ind]||{};
           var k=$(this).text();
           var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
           //alert(k);
           if(k==''){
               if(!$(this).children().hasClass('errMsg')){
                    $(this).append(msg);
                    //$(this).parent().css("background","red");
                    data.goahead='no';
                    return false;
                    }else{
                        data.goahead='no';
                        return false;
                    }
            }               
           else{
            $(this).find("p.errMsg").remove();
                data.goahead='yes';
                //alert("ifel");
                var prop2a=$(this).attr("id");
                data[ind][prop2a]=k;
                
                //alert(h);
            }
        }    

               
           
        });
        
        
        return data;
       
   }







//==================================================================








/*
 * this functions collect the values with property attributes from data table
 * 1) table name has to be with id/class for e.g #tabmain,table.class etc
 * 2) table cell td should have 'class' name to serve as property
 *  and dirname='direct' wherever text has to be collected as data
 * 3) input and select element must have title='property' 
 * 4) data would return data.goahead=yes/no for going ahead
 * 5)data format=data[property]=cell value;;/pick up id
 * 6)++++++++++++++++excludes input with class='exclude'
 */
 //===============================================================================
 function check_and_collect_values33(tablename){
       var t=tablename+" tr td";
       var data={};
       $(t).each(function(index){
           var ind=$(this).parent().index();
           var prop2=$(this).attr("class");
           //console.log(index+"-"+ind);
           var c=$(this).find("input").length;
           if(c>0 && prop2!=='exclude'){
               //alert(prop2);
               data[ind]=data[ind]||{};//save hell of a life here;;;;congrats
               var v=$(this).find("input").val();
               var prop=$(this).find("input").attr("title");
               var msg="<p class='errMsg'>EMPTY VALUE!</p>";
               if(v==''){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        
                        return false;
                        }else{
                            //data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //-----------------------------change and pickup date in mysql format
                    var n=prop.search("_dt");
                    if(n>0){
                        var vdt=chng_dt_frmt(v);
                        data[ind][prop]=vdt;
                    }else{
                        data[ind][prop]=v;
                    }
                    
                    //take hidden values for e.g id
                    
                }
               
           }
           //==========================================check for select
           var d=$(this).find("select").length;
           if(d>0){
               data[ind]=data[ind]||{};
               var v=$(this).find("select").val();
               var prop=$(this).find("select").attr("title");
               var msg="<p class='errMsg'>SELECT VALUE!</p>";
               if(v=='SELECT'){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                          data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    data[ind][prop]=v;
                }
               
           }
           //==================================check for empty text;;
           
           var h=$(this).attr("dirname");
           
           if(h=='direct'){
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    var prop2=$(this).attr("class");
                    var n=prop2.search("_dt");
                    //alert(n);
                    if(n>0){
                        var vdt=chng_dt_frmt(k);
                        data[ind][prop2]=vdt;
                    }else{
                        data[ind][prop2]=k;
                    }
                    
                    //alert(h);
                }
            }
            //--------------collect hidden attributes class &&id;;
            if(h=='direct_id'){
                //alert('drie_');
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //alert("ifel");
                    var prop2=$(this).attr("class");
                    //data[ind][prop2]=k;
                    var prop3=$(this).attr('id');
                    data[ind][prop2]=prop3;
                    //alert(h);
                }
            }
           
            //--------------collect id as property and text as value where class cant be read
           if(h=='direct_half'){
            //alert('drie_');
           data[ind]=data[ind]||{};
           var k=$(this).text();
           var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
           //alert(k);
           if(k==''){
               if(!$(this).children().hasClass('errMsg')){
                    $(this).append(msg);
                    //$(this).parent().css("background","red");
                    data.goahead='no';
                    return false;
                    }else{
                        data.goahead='no';
                        return false;
                    }
            }               
           else{
            $(this).find("p.errMsg").remove();
                data.goahead='yes';
                //alert("ifel");
                var prop2a=$(this).attr("id");
                data[ind][prop2a]=k;
                
                //alert(h);
            }
        }    

               

               
           
        });
        
        
        return data;
       
   }
   
   /*
    * this function leaves checkbox in row 
    */
   
   //===============================================================================
 function check_and_collect_values23(tablename){
       var t=tablename+" tr td";
       var data={};
       $(t).each(function(index){
           var ind=$(this).parent().index();
           var prop2=$(this).attr("class");
           //console.log(index+"-"+ind);
           var c=$(this).find("input[type='text']").length;
           if(c>0){
               data[ind]=data[ind]||{};//save hell of a life here;;;;congrats
               var v=$(this).find("input").val();
               var prop=$(this).find("input").attr("title");
               var msg="<p class='errMsg'>EMPTY VALUE!</p>";
               if(v==''){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        
                        return false;
                        }else{
                            //data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    
                        data[ind][prop]=v;
                                        
                    //take hidden values for e.g id
                    
                }
               
           }
           //==========================================check for select
           var d=$(this).find("select").length;
           if(d>0){
               data[ind]=data[ind]||{};
               var v=$(this).find("select").val();
               var prop=$(this).find("select").attr("title");
               var msg="<p class='errMsg'>SELECT VALUE!</p>";
               if(v=='SELECT'){
                    if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                          data.goahead='no';
                            return false;
                        }
                }else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    data[ind][prop]=v;
                }
               
           }
           //==================================check for empty text;;
           
           var h=$(this).attr("dirname");
           
           if(h=='direct'){
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    
                        data[ind][prop2]=k;
                    
                    
                    //alert(h);
                }
            }
            //--------------collect hidden attributes class &&id;;
            if(h=='direct_id'){
                //alert('drie_');
               data[ind]=data[ind]||{};
               var k=$(this).text();
               var msg="<p class='errMsg'>EMPTY CELL VALUE!</p>";
               //alert(k);
               if(k==''){
                   if(!$(this).children().hasClass('errMsg')){
                        $(this).append(msg);
                        //$(this).parent().css("background","red");
                        data.goahead='no';
                        return false;
                        }else{
                            data.goahead='no';
                            return false;
                        }
                }               
               else{
                $(this).find("p.errMsg").remove();
                    data.goahead='yes';
                    //alert("ifel");
                    var prop2=$(this).attr("class");
                    data[ind][prop2]=k;
                    var prop3=$(this).attr('id');
                    data[ind]['id']=prop3;
                    //alert(h);
                }
            }
           
               

               
           
        });
        
        
        return data;
       
   }

//==================================row clone with plus image
   
   function row_copy_plusimg(row,item,clas){
      //alert('user');
                var i=$(row).parent().find("tr").length;
                console.log("i:"+i);
                var ttl="terms"+i;
                    var rowClone=$(row).clone();
                    	rowClone.removeClass('stop');
                        $(rowClone).find("input[type='text']").val('').end();
                        $(rowClone).find("input[type='text']").attr("title",ttl);
                        rowClone.find('td:not(:has(input),:has(select),:has(img))').text("");
			//console.log(rowClone);
			
                        $(row).parent().append(rowClone);
                        $(clas).autocomplete({
				source:item
				});
                        //rowClone.find('td:not(:has(input),:has(select))').text("");
			$(rowClone).find("td:eq(0) input").focus();
   
                
		
     }
     //==================================row clone with plus image
   
   function row_copy_plusimg_mod(row,item,clas,table){
      //alert('user');
                var i=$(table).find("tr").length;
                console.log("i:"+i);
                var ttl="terms"+i;
                    var rowClone=$(row).clone();
                    	rowClone.removeClass('stop');
                        $(rowClone).find("input[type='text']").val('').end();
                        $(rowClone).find("input[type='text']").attr("title",ttl);
                        rowClone.find('td:not(:has(input),:has(select),:has(img))').text("");
			//console.log(rowClone);
			
                        $(table).append(rowClone);
                        $(clas).autocomplete({
				source:item
				});
                        //rowClone.find('td:not(:has(input),:has(select))').text("");
			$(rowClone).find("td:eq(0) input").focus();
   
                
		
     }
     //-========================================remove row using -image
    function remove_row_minusimg(ele){
        var row=$(ele).parent().parent();
    if($(row).hasClass('stop')){
        alert('First Row:Can not delete');
        return false;
    }else{
        //alert('yes');
        $(row).remove();
    }
        
    }


     //========================================doesnt deletet the row just strike the text
    function remove_row_minusimg2(ele){
        var row=$(ele).parent().parent();
    if($(row).hasClass('stop')){
        alert('First Row:Can not delete');
        return false;
    }else{
        //alert('yes');
        //$(row).remove();
        $(row).css("text-decoration","line-through");
        $(row).css("text-decoration-color","red");
        $(row).css("text-decoration-style","double");
    
    }
        
    }
    //============================================checks all the checkbox based on leaders val
    /*
     * tablename should be with# for e.g "#tabmain"
     * leadername is also id, for e.g "#chk_all"
     * first row eq(0) is exempted by default;;;
     */
    function chk_all(tablename,leadername){
        var v=$(leadername).prop("checked");
        var rows=tablename +" tr:not(:eq(0))";
        $(rows).each(function(){
            $(this).find("input[type='checkbox']").prop("checked",v);
        });
    }
    
       //==================================row clone with plus image
   
   function row_copy_img(row,item,clas){
      //alert('user');
                //var row2=$(row).parent().find("tr:last-child");
                //$(row).css("background","yellow");
		var rowClone=$(row).clone();
                //console.log(row2);
                	rowClone=$(row).clone().find('input').val('').end();
			
			
			//rowClone=$(rowClone).find('td:not(:eq(0),:eq(1))').text('').end();
			//alert(rowClone);
        
                 
			rowClone.removeClass('stop');
			
			$(row).parent().find("tr:eq(-1)").after(rowClone);
                        $(clas).autocomplete({
				source:item
				});
                        //rowClone.find('td:not(:has(input),:has(select))').text("");
			$(rowClone).find("td:eq(0) input").focus();
   
     }
//-----------------------row delete with - image

function remove_row_img(ele){
    var row=$(ele).parent().parent();
    if($(row).hasClass('stop')){
        alert('First Row:Can not delete');
        return false;
    }else{
        //alert('yes');
        $(row).remove();
    }
}

//==============================show cutting stock
  function show_stock(cutting){
      $("div#showdata").css("display","none");
      $("div#showdata2").css("display","block");
      $("div#showdata2").load("show_stock.php",{dept:cutting});
      $("#getdata").css("display","none");
  }

