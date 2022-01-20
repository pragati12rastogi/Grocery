<?php 
  require 'include/header.php';
  ?>
  <link rel="stylesheet" type="text/css" href="app-assets/css/billing.css">
   
   <style>
 .all_class_details{
      /*display: none;
      margin-bottom: 14px;
      width: 93%;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      position: absolute;
      z-index: 9999;
      background: #FFF;
      margin-top: -20px;*/

          display: none;
    margin-bottom: 14px;
    width: 43%;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    position: absolute;
    right: 70px;
    z-index: 9999;
    background: #FFF;
    margin-top: 3px;
    }
  .SpecificclassName{
      cursor: pointer;
      padding: 2px;
      font-weight: 600;
      color: #000;
    }
    .SpecificclassName:hover{
      cursor: pointer;
      padding: 2px;
      background: #37418B;
      color: #FFF;
    }
    .error_of_product{
      color:red;
    }
    </style>
  <body data-col="2-columns" class=" 2-columns ">
       <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <?php include('main.php');
        if($username != 'admin' && $check_menu_billing['create'] !=1 ){
          ?>
              <script>
                  window.location.href="404.php";
              </script>
          <?php			
          }
      ?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->

<section id="dom">
  <h4 class="card-title" id="card-title">Billing</h4>
    <div class="row">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                   <!--  <h4 class="card-title" id="card-title">Billing</h4> -->
                   <div class="row">
                          <div class="col-md-12">
                            <button type="submit" id="cusmoter_search" class="cusmoter_search"><i class="fa fa-user-plus"></i></button>
                            <input type="text" id="customer_name" name="customer_name" class="barcode_inp1" placeholder="Customer name/No." onkeyup="fetchCustomerDetails(this.value);" autocomplete="off">

                              <div class="form-group">
                                <div class="customer_details" id="customer_details"></div>                
                              </div>
                          </div>

                          <!-- <div class="col-md-4 customer" id="customer">
                            
                          </div> -->
                        </div>
                    <div class="row">
                          <div class="col-md-4 customer" id="customer">
                       
                          </div>
                          <?php if($username == 'admin' || $check_menu_customer['create'] ==1){
                          ?>
                          <div class="Show_yes_no">
                              <label>Yes
                              <input type="radio" name="add" value="Yes" id="yes"></label>
                            <label>No <input type="radio" name="add" value="no" id="no"></label>
                          </div> 
                          <?php } ?>                       

                    </div>

                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">

<!-- 
<table class="table table-striped table-bordered dom-jQuery-events"> -->
    <div class="col-md-12 ml-2">
        <span class="error_of_product "></span>
    </div>
  <table class="table table-striped table-bordered " id="DataTables_Table_0">
    <button type="submit" id="search_icon"><i class="fa fa-search"></i></button>
    <input type="text" id="barcode_scanner" name="barcode-scanning" class="barcode_inp1" placeholder="Only Barcode Scanning">
    <input type="text" class="barcode_inp" id="product_name" name="barcode_enter" onkeyup="fetchName(this.value);" placeholder="Enter Barcode/Product Code/Product Name" autocomplete="off">
    <div class="form-group">
      <div class="all_class_details"></div>                 
    </div>
    
    
    

    <thead id="table_data">
            <tr>
            <th>Action</th>
            <th scope="col">Item</th>
            <th scope="col">Barcode</th>
           <!--  <th scope="col">UQC</th> -->
            <!-- <th scope="col">Stock</th> -->
            <th scope="col">Price</th>
            <th scope="col">Unit</th>
           <!--  <th scope="col">Measurement</th> -->
            <th scope="col">Qty</th>
            <!-- <th scope="col">Disc %</th> -->
           <!--  <th scope="col">Disc Amt</th> -->
            <th scope="col">Total</th>

          </tr>
    </thead>
    <tbody ></tbody>
                            
 </table>
            </div>
        </div>
    </div>
</div>
        <div class="col-md-4">
            <div class="card">
                <!-- <div class="card-header">
                    <h4 class="card-title">Billing</h4>
                </div> -->
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                      <div class="row right-card">
                      
                          <!-- <label class="col-md-4">Discout all item (%)</label>
                          <div class="col-md-8">
                            <input type="text" name="disc_allpercnt" placeholder="Enter discount(%)" id="disc_allpercnt" class="disc_allpercnt">
                          </div>
                          
  
                          <label class="col-md-4">Discout all Amout</label>
                          <div class="col-md-8">
                            <input type="text" name="disc_allamt" placeholder="Enter discount Amt" id="disc_allamt" class="disc_allamt">
                          </div> -->

                       
                          <div class="col-md-6" id="total_qty">
      
                               <div class="card bg-primary text-white">
                                  <div class="card-body card_body_content">Total Items</div>
                                  <h2>0</h2>
                                </div>
                             
                          </div>
                          <div class="col-md-6" id="total_payble">
                            <div class="card bg-primary text-white ">
                              <div class="card-body card_body_content">Total Payble</div>
                              <h2>0</h2>
                            </div>
                          </div>
                       


            
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6 mb-3">
                            <label>
                            <input type="radio" class="form-control" name="payment_type" value="Card">Card</label>
                          </div> 
                         
                          <div class="col-md-6 mb-3">
                            <label>
                            <input type="radio" class="form-control" name="payment_type" value="Cash">Cash</label>
                          </div>                
                        </div>
                      </div>                       
                      
                        <label class="col-md-4">
                          Note For Internal Use
                        </label>
                        <div class="col-md-8">
                          <textarea class="customer-note" type="text" id="owner_note" name="owner_note" placeholder="Note for internal use" resize="none"></textarea> 
                        </div>

                          <label class="col-md-4">
                            Note For customer
                          </label>
                          <div class="col-md-8">
                            <textarea class="customer-note" type="text" id="customer_note" name="" placeholder="Note for Customer" resize="none"></textarea> 
                          </div>
                          <div class="col-md-12">
                            <div class=" row">
                              <div class="col-md-6">
                                <button type="button" class="btn btn-primary comon-btn" onclick="save_n_new()">
                                  Save & New
                                </button>
                              </div>
                              <div class="col-md-12" >
                                <div class="d-flex row" id="print_div">
                                
                                </div>
                              </div>
                            </div>
                          </div>
                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
if(isset($_GET['dele']))
{
$con->query("delete from inventory_stock where id=".$_GET['dele']."");
?>
	 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('selected product deleted successfully.');
    setTimeout(function()
	{
		window.location.href="stocklist.php";
	},1500);
  });
  </script>
  <?php
}
?>


          </div>
        </div>

        

      </div>
    </div>
       <!--Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="new_customer_form">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Customer Name:</label>
           <input type="text" class="form-control" id="name" name="name">
           <span class="nameError Allerror" style="color:red;"></span>
          </div>

          <div class="form-group">
            <label for="recipient-email" class="col-form-label">Customer Email:</label>
            <input type="text" class="form-control" id="email" name="email">
            <span class="emailError Allerror" style="color:red;"></span>
          </div>

          <div class="form-group">
            <label for="recipient-mobile" class="col-form-label">Customer Mobile:</label>
            <input type="text" class="form-control" id="mobile" name="mobile">
            <span class="mobileError Allerror" style="color:red;"></span>
          </div>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" value="submit" class="btn btn-primary add_customer">
      </div>
    </div>
  </div>
</div>

<!--Modal End -->
    <?php 
  require 'include/js.php';
  ?>
    <style>
        table
        {
          font-size:13px;
        }

        
    </style>
    <!-- END PAGE LEVEL JS-->
    <script>
      
      $('#yes').click(function(){
        //alert("sdfsdfsdf");
        $('#exampleModal').modal('show');
      });

      //Function to add new customer
      $('.add_customer').on("click",function(){
        var name = $('#name').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();

        var mobilefilter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;

       var mailformat = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/; 



        if(name == ''){
          $('.nameError').html("Please Enter Name");
          $('#name').focus();
          return false;
        }
        else if(email == ''){
          // alert("Enter email");
          $('.emailError').html("Enter Email Address");
          $('#email').focus();
          return false;
        }
        else if(mailformat.test(email) == false){          
          $('.emailError').html("Invalid Email Format");
          $('#email').focus();
          return false;
        }
        else if(mobile == ''){
          $('.mobileError').html("Enter Mobile Number");
          $('#mobile').focus();
          return false;
        }
        else{
          //alert("succes");
          $.ajax({
            url: 'newBillingCustomer.php',
            method: 'POST',
            data: {name:name, email:email,mobile:mobile},
            succes:function(response){ 
              alert(response);
              if(response == 1){
                $(".Show_yes_no").hide();
                $('.customer').html('');
                alert("data added");
              }
            },  
            error:function(err){
            console.log("Error Found",err);
          }
          });
        }
      });

      function fetchCustomerDetails(customerName){
        var phone = customerName;
        $('.customer_details').show();
        $.ajax({
          url:'Ajax/fetchCustomer.php',
          method:'POST',
          dataType: 'Json',
          data:{phone:phone},
          success:function(response){
            var html = "";
            var error = "";
            //console.log(response);
            if(response.length == 0){
              //alert("Not Found");
              $(".Show_yes_no").show();
              error +='<p class="Error_Message" style="color:red;">Data not Found, Do you want to add ?</p>';
              $('.customer').html(error);
              $('.customer_details').hide();
            }else{
              $(".Show_yes_no").hide();
              $('.customer').html('');
                var len = response.length;
             //console.log(len);
             
              for(var i=0; i<len; i++){

                var id = response[i].id;
                var mobile = response[i].mobile;
                html +='<div class="SpecificcustomerName">'+mobile+'</div>';
              }
               $('.customer_details').show().html(html);
               $(".SpecificcustomerName").click(function(){
                //  var school_detail = $(".SpecificSchoolName").text();
                var cust_detail = $(this).text()
                //alert(prod_detail);
                $("#customer_name").val(cust_detail);
                $('.customer_details').hide();
              });
            }
           
            
          },
          error:function(err){
            console.log("Error Found",err);
          }
        });
      }

      function fetchName(productName){
        // var value1 = productName.toLowerCase();
        var value1 = productName;
         $(".all_class_details").show();
          $.ajax({
            url: 'Ajax/inventoryProduct.php',
            method: 'POST',
            //dataType:"text",
           data:{value1:value1 },
            success: function(data){
              console.log(data);
              //alert(data);
              var html = "";
              var j = 1;
              var sp = data.split(",");
              for(var i=0; i<sp.length-1; i++){                  
                html +='<div class="SpecificclassName">'+sp[i]+'</div>';

              }
              $('.all_class_details').html(html);
              $(".SpecificclassName").click(function(){
                //  var school_detail = $(".SpecificSchoolName").text();
                var prod_detail = $(this).text()
                //alert(prod_detail);
                $("#product_name").val(prod_detail).trigger('keyup');
                $('.all_class_details').hide();
                
              });
             // console.log(sp);
              if(sp == ""){
              $('.all_class_details').hide();
            }
            },
              error:function(err){
                console.log("Error : ",err)
              }
          });
      }

    </script>
    <script>
      var arr = [];
      $(document).ready(function(){

        var product_name='';
        $('#search_icon').click(function(){
            addon_table();
        });
        $("#product_name").keyup(function(){
          addon_table();
        });
        
        function addon_table(){
          var product_name1 = $('#product_name').val();
          
          $.ajax({
            url:'Ajax/ajaxfile.php',
            Type:'get',
            dataType:'json',
            data:{save:"save",product_name:product_name1},
            success:function(response){
              console.log(response);
              if(response == ''){
                $(".error_of_product").html("Product not available").show();
              }            
              var len = response.length;
              if(len > 0){
                $(".error_of_product").html("").hide();
              }
              for(var i=0; i<len; i++){

                var id = response[i].id;
                var product_name = response[i].product_name;
                var barcode = response[i].barcode;
                var prod_quantity = response[i].prod_quantity;
                var selling_price = response[i].selling_price_wth_prft;

                var originalunit = response[i].unit;
                var unit = response[i].unit;

                if(unit == 'Kg'){
                  unit = '<select name="unit_dd['+id+']" rowId="'+id+'" class="unit_dd" id="unit_dd_'+id+'" >'
                            +'<option value="Kg" >Kg</option>'
                            +'<option value="Gm">Gm</option>'
                            +'<option value="Mg">Mg</option>'
                        +'</select>';

                }else if(unit == 'Gm'){
                    unit = '<select name="unit_dd['+id+']" rowId="'+id+'" id="unit_dd_'+id+'">'
                            +'<option value="Gm" >Gm</option>'
                            +'<option value="Mg">Mg</option>'
                        +'</select>';
                }
                var is_changeable = response[i].is_changeable;

                console.log(is_changeable);                
               
                //for(var i in arr){
                  if($.inArray(product_name,arr) !== -1){
                    alert('Already Added in table row');
                  }                
                else{
                  //console.log("not exist");
                  arr.push(product_name);

                  if(is_changeable == 1){
                    var tr_str = "<tr class='prod_row' id="+id+">" +

                    "<td align='center'><button type='button' onclick='deleteRow(\""+ product_name +"\",\"DataTables_Table_0\",this,"+id+")'><i class='fa fa-trash'></i></button><input type='checbox' value='mark' id='check_"+id+"' class='check' style='display:none'></td>"+
                    "<td align='center'>" + product_name + "</td>" +
                    "<td align='center'>" + barcode + "</td>" +                  
                    "<td align='center' class='selling_price myPrice"+id+"'>" + selling_price + "</td>" +
                    "<td align='center' class='unit myUnit"+id+"'>" + unit + 
                    '<input type="hidden" id="original_unit_'+id+'" value="'+originalunit+'"></td>' +
                    //"<td align='center' class='unit myUnit"+id+"'><select name='unit'><option value='Gram'>Gram</option><option value='kg'>kg</option><option value='Mg'>Mg</option><option value='ltr'>Litter</option><option value='Ml'>Ml</option></select></td>" +
                   
                    //"<td align='center' class='measuremnt myMeasuremnt"+id+"'>" + measurement + "</td>" +
                    "<td align='center'><input rowId='"+id+"' id='insert_grams_"+id+"' type='number' name='quantity["+id+"]' class='common_qnty' value='1' max='"+prod_quantity+"''><input type='hidden' id='inventory_stock_"+id+"' value='"+prod_quantity+"'></td>"+
                    //"<td align='center'><input type='text' class='common_disc_prcnt' name='disc_percnt'></td>" +
                    //"<td align='center'><input type='text' class='common_disc_amt discAmt"+id+"' name='disc_amt'></td>" +

                    //"<td align='center'><span class='total myTotalPrice"+id+"'>"+selling_price+"</span></td>" +
                    "<td align='center' class='loop'><input type ='text' class='total FinalPrice myTotalPrice"+id+"' value='"+selling_price+"' disabled></td>" +
                    "</tr>";


                    $("#DataTables_Table_0 tbody").append(tr_str);
                  }else{
                    // alert("sdfsadfs");
                    var tr_str = "<tr class='prod_row' id="+id+">" +

                    
                    "<td align='center'><button type='button' onclick='deleteRow(\""+ product_name +"\",\"DataTables_Table_0\",this,"+id+")'><i class='fa fa-trash'></i></button>"
                    +"<input type='checbox' id='check_"+id+"' class='check' value='mark' style='display:none'></td>"+
                    "<td align='center'>" + product_name + "</td>" +
                    "<td align='center'>" + barcode + "</td>" +                  
                    "<td align='center' class='selling_price myPrice"+id+"'>" + selling_price + "</td>" +
                    "<td align='center' class='unit myUnit"+id+"'>" + unit + 
                    '<input type="hidden" id="original_unit_'+id+'" value="'+originalunit+'">'
                    +"</td>" +
                    //"<td align='center' class='unit myUnit"+id+"'><select name='unit'><option value='Gram'>Gram</option><option value='kg'>kg</option><option value='Mg'>Mg</option><option value='ltr'>Litter</option><option value='Ml'>Ml</option></select></td>" +
                   
                    //"<td align='center' class='measuremnt myMeasuremnt"+id+"'>" + measurement + "</td>" +
                    "<td align='center'><input rowId='"+id+"' type='number' name='quantity["+id+"]' id='quantity_"+id+"' class='common_qnty' value='1' max ='"+prod_quantity+"'><input type='hidden' id='inventory_stock_"+id+"' value='"+prod_quantity+"'></td>"+
                    //"<td align='center'><input type='text' class='common_disc_prcnt' name='disc_percnt'></td>" +
                    //"<td align='center'><input type='text' class='common_disc_amt discAmt"+id+"' name='disc_amt'></td>" +

                    //"<td align='center'><span class='total myTotalPrice"+id+"'>"+selling_price+"</span></td>" +
                    "<td align='center'class='loop'><input type ='text' class='total FinalPrice myTotalPrice"+id+"' id='subtotal' name='subtotal["+id+"]' value='"+selling_price+"' disabled /></td>" +
                    "</tr>";

                    $("#DataTables_Table_0 tbody").append(tr_str);                   

                  }                
                  
                }
                // arr.push(product_name);
                 
                
              }
              CallFinalFunction(0);
            },
            error: function(xhr, status, error){
               var errorMessage = xhr.status + ': ' + xhr.statusText
               alert('Error - ' + errorMessage);
           }

          });
        }
        //  var selling_price = $('.myPrice'+id).text();

        // $(".myTotalPrice"+id).text(selling_price);
        var totalPrice = 0;
        $(document).on("keyup",".common_qnty",function(){
          var qty = this.value;
          console.log(qty);
          var id = $(this).attr("rowId");
          console.log(id);

          var unit = $('#unit_dd_'+id).val();

          var selling_price = $('.myPrice'+id).text();
            
          unit_wise_calc(unit,selling_price,qty,id);
        });

        $(document).on("change",".unit_dd",function(){
            var id = $(this).attr("rowId");
            var unit = this.value;
            var common_qnty = $("#quantity_"+id).val();
            var insert_grams = $("#insert_grams_"+id).val();
            var qty = 1;
            if(insert_grams != undefined){
              qty = insert_grams;
            }else if(common_qnty != undefined){
              qty = common_qnty;
            }
            var selling_price = $('.myPrice'+id).text();

            unit_wise_calc(unit,selling_price,qty,id);
        });

        function unit_wise_calc(unit,selling_price,qty,id){
          // console.log(unit +'  '+selling_price+'  '+qty+'  '+id);
          var originalunit = $('#original_unit_'+id).val();
          var stock_qty = $('#inventory_stock_'+id).val();

          if(originalunit == 'Kg'){
            // if unit is in Kg
            // have option to convert GM, MG
              if(unit == 'Gm'){
                var total = selling_price * (qty/1000);
                var new_qty = parseInt(stock_qty)*1000;
                
                $("#quantity_"+id).attr('max',new_qty);
                $("#insert_grams_"+id).attr('max',new_qty);
              }else if(unit == 'Mg'){
                var total = selling_price * (qty/100000);
                var new_qty = parseInt(stock_qty)*100000;
                $("#quantity_"+id).attr('max',new_qty);
                $("#insert_grams_"+id).attr('max',new_qty);
              }else{
                var new_qty = parseInt(stock_qty);
                $("#quantity_"+id).attr('max',new_qty);
                $("#insert_grams_"+id).attr('max',new_qty);
                var total = selling_price * qty;
              }
          }else if(originalunit == 'Gm'){
            // if unit is in Gm
            // have option to convert MG
              if(unit == 'Mg'){
                var total = selling_price * (qty/1000);
                var new_qty = parseInt(stock_qty)*1000;
                $("#quantity_"+id).attr('max',new_qty);
                $("#insert_grams_"+id).attr('max',new_qty);
              }else{
                var total = selling_price * qty;
                var new_qty = parseInt(stock_qty);
                $("#quantity_"+id).attr('max',new_qty);
                $("#insert_grams_"+id).attr('max',new_qty);
              }
          }else{

              var total = selling_price * qty;
              var new_qty = parseInt(stock_qty);
                $("#quantity_"+id).attr('max',new_qty);
                $("#insert_grams_"+id).attr('max',new_qty);
          }
          
          $(".myTotalPrice"+id).val(total);
          
           CallFinalFunction(total);
        }
          
        

          // function CountTotalItmes(){
          //   var totalItem=0;
          //  var n = $( "prod_row" ).length;
          //  console.log("total_items:"+n);
          // }
      });
      
      function CallFinalFunction(subtotal){           
            // console.log("Total  : ",subtotal)
            var subtotal=0;
            var total_item = 0;
            jQuery('.FinalPrice').each(function(i,val) {
              //console.log(i+':'+ $(val).val());
              subtotal += parseFloat($(this).val());
              console.log("sum is"+subtotal);
              total_item +=1;

            });
            $('div#total_payble h2').html(subtotal);
            $('div#total_qty h2').html(total_item);
        
      }
      function deleteRow(prod_name,tableID,btn,id) {
        try {
          
          $("#check_"+id).prop('checked',true);
            var table = document.getElementById(tableID);
          
            var rowCount = table.rows.length;
            
            for(var i=0; i<rowCount; i++) {
              var row = table.rows[i];
              var chkbox = row.cells[0].lastChild;
              
              if(null != chkbox && true == chkbox.checked) {
                if(rowCount <= 1) {
                  alert("Cannot delete all the rows.");
                  break;
                }
                table.deleteRow(i);
                rowCount--;
                i--;
                var index = arr.indexOf(prod_name);
                if (index > -1) {
                  arr.splice(index, 1);
                }
                console.log(arr);
                CallFinalFunction(0);
              }


            }
            
        }catch(e) {
          alert(e);
        }
      }

    function save_n_new(){
        var data ={};
        var prod_id =[];
        var unit =[];
        var qty =[];
        var total =[];
        jQuery('.prod_row').each(function(i,val) {
          var id = $(this).attr('id');
          prod_id.push(id);
          var check_unit = $("#unit_dd_"+id).val();
          if(check_unit != undefined && check_unit != null){
              unit[id] = check_unit;
          }else{
              unit[id] = $("#original_unit_"+id).val();
              console.log(unit[id]);
          }
          qty[id] = $('input[name="quantity['+id+']"]').val();
          total[id] = $(".myTotalPrice"+id).val();
        });debugger
        data.prod_id = prod_id;
        // var cleanunit = unit.filter(function(el) { return el; });
        data.unit = unit;
        // var cleanqty = .filter(function(el) { return el; });
        data.qty = qty;
        // var cleantotal = .filter(function(el) { return el; });
        data.total = total;
        data.payment_type = $('input[name="payment_type"]:checked').val();
       
        if(data.payment_type == '' || data.payment_type == undefined){
          alert('Please select Payment type');
          return false;
        }
        if(prod_id == '' || prod_id == []){
          alert('Please select Any Product');
          return false;
        }
        data.user_id= $('#customer_name').val();
        if(data.user_id == '' || data.user_id == undefined){
          alert('Please select User First');
          return false;
        }
        data.barcode = $('#barcode_scanner').val();
        data.customer_note = $('#customer_note').val();
        data.owner_note = $('#owner_note').val();
        console.log(JSON.stringify(data));
        $("#print_div").empty();
        
        $.ajax({
            url:'Ajax/ajaxfile.php',
            Type:'GET',
            dataType:'Json',
            data:{"submit_order":"submit_order","data":JSON.stringify(data)},
            success:function(response){

                if(response.order_id != null && response.order_id != ''){
                  $str = '<div class="col-md-6"><a href="bill_invoice.php?order_id='+response.order_id+'" class="btn btn-secondary d-block" target="_blank">Print Invoice</a></div><div class="col-md-3">'+
                  '<a href="billing.php" class="btn btn-info d-inline" style="float: right;">New</button></a></div>';
                  $("#print_div").append($str);
                  
                }else{
                   alert(response.error);
                }
            },  
            error:function(err){
              console.log("Error Found",err);
              var error = err.responseText;
              var split = error.split('"');
              
            }
        });
    }
    </script>


  </body>


</html>