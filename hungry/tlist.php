<?php 
  require 'include/header.php';
  ?>
  <body data-col="2-columns" class=" 2-columns ">
       <div class="layer"></div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="wrapper">


      <!-- main menu-->
      <!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
     <?php include('main.php'); if($username != 'admin' && $check_menu_timeslot['view_g'] !=1 && $check_menu_timeslot['view_o'] !=1 ){
        ?>
            <script>
                window.location.href="404.php";
            </script>
        <?php			
            }?>
      <!-- Navbar (Header) Ends-->

      <div class="main-panel">
        <div class="main-content">
          <div class="content-wrapper"><!--Statistics cards Starts-->

<section id="dom">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                            <h4 class="card-title ml-1">Timeslot List</h4>
                        </div>
                        <div class="col-md-1">
                            <a href="export/time_slotlist.php?export=1"><button type="button" class="btn btn-outline-github btn-sm">Export</button></a>
                        </div>
                    </div>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
                        <table class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
								 <th>Sr No.</th>
                                    <th>Timeslot Min Time</th>
                                   <th>Timeslot Max Time</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($username == 'admin' || $check_menu_timeslot['view_g'] ==1){
                                    $sel = $con->query("select * from timeslot");
                                }else{
                                    $sel = $con->query("select * from timeslot where created_by =".$admin_id);
                                }

                                $i=0;
                                while($row = $sel->fetch_assoc())
                                {
                                    $i= $i + 1;
                                ?>
                                <tr>
                                    
                                    <td><?php echo $i; ?></td>
                                    <td><?php  echo date("g:i A", strtotime($row['mintime']));?></td>
                                   <td><?php echo date("g:i A", strtotime($row['maxtime']));?></td>
									<td>
                                    <?php if($username == 'admin'|| $check_menu_timeslot['edit'] ==1){ ?>

									<a class="primary"  href="timesloat.php?edit=<?php echo $row['id'];?>" data-original-title="" title="">
                                            <i class="ft-edit font-medium-3"></i>
                                        </a>
                                    <?php }
                                    if($username == 'admin'|| $check_menu_timeslot['edit'] ==1){ ?>
									
									<a class="danger" href="?dele=<?php echo $row['id'];?>" data-original-title="" title="">
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
    if($username != 'admin'&& $check_menu_timeslot['delete'] != 1){
        header('Location: 404.php'); 
        die("404 error");
    }

$con->query("delete from timeslot where id=".$_GET['dele']."");
?>
	 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('Selected Timeslot Deleted Successfully.');
    setTimeout(function()
	{
		window.location.href="tlist.php";
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

  </body>


</html>