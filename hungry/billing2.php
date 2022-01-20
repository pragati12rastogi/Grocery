<?php 
  require 'include/header.php';
  ?>
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

    </style>
  <body data-col="2-columns" class=" 2-columns ">
       <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <?php include('main.php'); ?>
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
                          <div class="Show_yes_no">
                            <label>Yes
                            <input type="radio" name="add" value="Yes" id="yes"></label>
                          <label>No <input type="radio" name="add" value="no" id="no"></label>
                          </div>                        

                    </div>

                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">

<!-- 
<table class="table table-striped table-bordered dom-jQuery-events"> -->
  <table id="exampleTable" class="table table-striped table-bordered" style="width: 100%;">
    <button type="submit" id="search_icon"><i class="fa fa-search"></i></button>
    <input type="text" id="barcode_scanner" name="barcode-scanning" class="barcode_inp1" placeholder="Only Barcode Scanning">
    <input type="text" class="barcode_inp" id="product_name" name="barcode_enter" onkeyup="fetchName(this.value);" placeholder="Enter Barcode/Product Code/Product Name" autocomplete="off">

    <div class="mt-4 ml-4">
      <INPUT type="button" value="Delete Row" onclick="deleteRow('exampleTable')" />
    </div>
    <div class="form-group">
      <div class="all_class_details"></div>                 
    </div>
    <thead class="table-header">
            <tr>
            <th>Action</th>
            <th scope="col">Item</th>
            <th scope="col">Barcode</th>
            <th scope="col">Price</th>
            <th scope="col">Unit</th>
            <th scope="col">Qty</th>
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
                      
                          <label class="col-md-4">Discout all item (%)</label>
                          <div class="col-md-8">
                            <input type="text" name="discp" placeholder="Enter discount(%)">
                          </div>
                          
  
                          <label class="col-md-4">Discout all Amout</label>
                          <div class="col-md-8">
                            <input type="text" name="discp" placeholder="Enter discount Amt">
                          </div>

                       
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

                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">Card</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Card" aria-label="Username" aria-describedby="basic-addon1">
                      </div> 
                     
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">Cash</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Cash" aria-label="Username" aria-describedby="basic-addon1">
                      </div>                
                          

                      </div>                       
                      
                        <label class="col-md-4">
                          Note For Internal Use
                        </label>
                        <div class="col-md-8">
                          <textarea class="customer-note" type="text" name="" placeholder="Note for internal use" resize="none"></textarea> 
                        </div>

                        <label class="col-md-4">
                          Note For customer
                        </label>
                        <div class="col-md-8">
                         <textarea class="customer-note" type="text" name="" placeholder="Note for Customer" resize="none"></textarea> 
                        </div>
                        <div class="butonSection row">
                        <div class="col-md-6">
                          <button type="button" class="btn btn-success comon-btn">
                            Save & print
                          </button>
                        </div>
                        <div class="col-md-6">
                          <button type="button" class="btn btn-primary comon-btn">
                            Save & New
                          </button>
                        </div>
                        </div>
                      


                      <div>

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
      function deleteRow(tableID) {
      try {
      var table = document.getElementById(tableID);
      var rowCount = table.rows.length;

      for(var i=0; i<rowCount; i++) {
        var row = table.rows[i];
        var chkbox = row.cells[0].childNodes[0];
        if(null != chkbox && true == chkbox.checked) {
          if(rowCount <= 1) {
            alert("Cannot delete all the rows.");
            break;
          }
          table.deleteRow(i);
          rowCount--;
          i--;


        }


      }
      }catch(e) {
        alert(e);
      }
    }




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
            }else{
              $(".Show_yes_no").hide();
                var len = response.length;
             //console.log(len);
             
              for(var i=0; i<len; i++){

                var id = response[i].id;
                var mobile = response[i].mobile;
                html +='<div class="SpecificcustomerName">'+mobile+'</div>';
              }
               $('.customer_details').html(html);
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
        var value1 = productName.toLowerCase();
         $(".all_class_details").show();
          $.ajax({
            url: 'Ajax/inventoryProduct.php',
            method: 'POST',
            //dataType:"text",
           data:{value1:value1 },
            success: function(data){
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
                $("#product_name").val(prod_detail);
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
      $(document).ready(function(){


        var arr = [];
        var product_name='';
        $('#search_icon').click(function(){
          var product_name1 = $('#product_name').val();
          var selling_price = 0;
          $.ajax({
            url:'Ajax/ajaxfile.php',
            Type:'get',
            dataType:'json',
            data:{save:"save",product_name:product_name1},
            success:function(response){
              //console.log(response);
              if(response == ''){
                alert("Product not available");
              }              
              var len = response.length;
              for(var i=0; i<len; i++){

                var id = response[i].id;
                var product_name = response[i].product_name;
                var barcode = response[i].barcode;
                //var prod_quantity = response[i].prod_quantity;
                selling_price = response[i].selling_price_wth_prft;
                //$('div#total_payble h2').html(selling_price);
                //var unit = response[i].unit;
                var unit = response[i].unit;
                var is_changeable = response[i].is_changeable;

                //alert(is_changeable);                
                  if(is_changeable == 1){
                    var tr_str = "<tr class='prod_row'>" +

                    "<TD><INPUT type='checkbox' name='chk'/></TD>"+
                    "<td align='center'>" + product_name + "</td>" +
                    "<td align='center'>" + barcode + "</td>" +                  
                    "<td align='center' class='selling_price myPrice"+id+"'>" + selling_price + "</td>" +
                    "<td align='center' class='unit myUnit"+id+"'>" + unit + "</td>" +
                    //"<td align='center' class='unit myUnit"+id+"'><select name='unit'><option value='Gram'>Gram</option><option value='kg'>kg</option><option value='Mg'>Mg</option><option value='ltr'>Litter</option><option value='Ml'>Ml</option></select></td>" +
                   
                    //"<td align='center' class='measuremnt myMeasuremnt"+id+"'>" + measurement + "</td>" +
                    "<td align='center'><input rowId='"+id+"' type='text' name='0' class='insert_grams'></td>"+
                    //"<td align='center'><input type='text' class='common_disc_prcnt' name='disc_percnt'></td>" +
                    //"<td align='center'><input type='text' class='common_disc_amt discAmt"+id+"' name='disc_amt'></td>" +

                    //"<td align='center'><span class='total myTotalPrice"+id+"'>"+selling_price+"</span></td>" +
                    "<td align='center' class='loop'><input type ='text' class='total FinalPrice myTotalPrice"+id+"' value='"+selling_price+"' disabled></td>" +
                    "</tr>";


                $("#exampleTable").append(tr_str);
                  }else{
                    alert("sdfsadfs");
                    var tr_str = "<tr class='prod_row' id="+id+">" +

                    "<TD><INPUT type='checkbox' name='chk'/></TD>"+
                    "<td align='center'>" + product_name + "</td>" +
                    "<td align='center'>" + barcode + "</td>" +                  
                    "<td align='center' class='selling_price myPrice"+id+"'>" + selling_price + "</td>" +
                    "<td align='center' class='unit myUnit"+id+"'>" + unit + "</td>" +
                    //"<td align='center' class='unit myUnit"+id+"'><select name='unit'><option value='Gram'>Gram</option><option value='kg'>kg</option><option value='Mg'>Mg</option><option value='ltr'>Litter</option><option value='Ml'>Ml</option></select></td>" +
                   
                    //"<td align='center' class='measuremnt myMeasuremnt"+id+"'>" + measurement + "</td>" +
                    "<td align='center'><input rowId='"+id+"' type='text' name='quantity' id='quantity' class='common_qnty' value='1'></td>"+
                    //"<td align='center'><input type='text' class='common_disc_prcnt' name='disc_percnt'></td>" +
                    //"<td align='center'><input type='text' class='common_disc_amt discAmt"+id+"' name='disc_amt'></td>" +

                    //"<td align='center'><span class='total myTotalPrice"+id+"'>"+selling_price+"</span></td>" +
                    "<td align='center'class='loop'><input type ='text' class='total FinalPrice myTotalPrice"+id+"' id='subtotal[]' name='subtotal' value='"+selling_price+"' disabled /></td>" +
                    "</tr>";

                    $("#exampleTable").append(tr_str);                   

                  }

                  //Initialize the Total Items when row adds
                  var rowCount = $("#exampleTable .prod_row").length;
                  $('div#total_qty h2').html(rowCount);

                  //Initialize Total Payble first time when each itme add up
                   $('div#total_payble h2').html(selling_price);              
              }
            },
            error: function(xhr, status, error){
               var errorMessage = xhr.status + ': ' + xhr.statusText
               alert('Error - ' + errorMessage);
           }

          });

        });

          //  var selling_price = $('.myPrice'+id).text();

          // $(".myTotalPrice"+id).text(selling_price);
          var totalPrice = 0;
         $(document).on("keyup",".common_qnty",function(){
          var qty = this.value;
          var id = $(this).attr("rowId");

          var selling_price = $('.myPrice'+id).text();
          var total = qty*selling_price;

          $(".myTotalPrice"+id).val(total);          

           CallFinalFunction(total);
          
        });

         $(document).on("keyup",".insert_grams",function(){
          var qty = this.value;
          var id = $(this).attr("rowId");



          var selling_price = $('.myPrice'+id).text();
          var total = selling_price/1000 * qty;

          $(".myTotalPrice"+id).val(total);
          //  totalPrice = parseFloat(totalPrice+total);
          // console.log("Total  : ",totalPrice)

          // $('div#total_payble h2').html(total);
          // $('div#total_qty h2').html(qty);

          CallFinalFunction(total);
          
        });


          function CallFinalFunction(subtotal){           
                //console.log("Total  : ",subtotal)
                var subtotal=0;
                jQuery('.FinalPrice').each(function(i,val) {
                  //console.log(i+':'+ $(val).val());
                  subtotal += parseFloat($(this).val());
                  console.log("sum is"+subtotal);
                  $('div#total_payble h2').html(subtotal);                    
                });
           
          }
      });
    </script>


  </body>


</html>