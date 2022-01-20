<?php 
  require 'include/header.php';
  ?>
  <body data-col="2-columns" class=" 2-columns ">
       <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
      <?php include('main.php'); 
        if($username != 'admin' && $check_menu_country['view_g'] !=1 && $check_menu_country['view_o'] !=1 ){
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Country Code List</h4>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
                        <table class="table table-striped table-bordered " id="example">
                            <thead>
                                <tr>
								 <th>Sr No.</th>
                                   
                                    <th>Country Code</th>
                                   <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                if($username == 'admin' || $check_menu_country['view_g'] ==1){
                                    $jj = $con->query("select * from code");
                                }else{
                                    $jj = $con->query("select * from code where created_by =".$admin_id);
                                }

                                $jj = $con->query("select * from code");
                                $i=0;
                                while($rkl = $jj->fetch_assoc())
                                {
                                    $i = $i + 1;
                                ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    
                                    <td><?php echo $rkl['ccode'];?></td>
                                   <td><?php if($rkl['status'] == 1){echo 'Active';}else{echo 'Deactive';}?></td>

                                    <td>
									<?php if($username == 'admin'|| $check_menu_country['edit'] ==1){ ?>
										<a class="primary"  href="code.php?edit=<?php echo $rkl['id'];?>" data-original-title="" title="">
                                            <i class="ft-edit font-medium-3"></i>
                                        </a>
                                    <?php }if($username == 'admin'|| $check_menu_country['delete'] ==1){ ?>	
									<a class="danger" data-original-title=""  href="?dele=<?php echo $rkl['id'];?>" title="">
                                            <i class="ft-trash font-medium-3"></i>
                                        </a>
                                    <?php } ?>	
										</td>
                                   
                                </tr>
                               <?php } ?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
if(isset($_GET['dele']))
{
    $con->query("delete from code   where id=".$_GET['dele']."");
?>
	 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('selected Country Code deleted successfully.');
   setTimeout(function()
	{
		window.location.href="clist.php";
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
   
    <?php 
  require 'include/js.php';
  ?>
   <script>
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
               {
                extend: 'excelHtml5',
                className: 'btn btn-yahoo btn-sm ',
                text: 'Export',
                exportOptions: {
                    columns: [ 0, 1, 2 ]
                },
                filename: 'CodeList_'+new Date().getTime()

               } 
            ]
        } );
   </script>
  </body>


</html>