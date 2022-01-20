<?php 
  require 'include/header.php';
  ?>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-11">
                          <h4 class="card-title ml-1">Agents List</h4>
                        </div>
                        <div class="col-md-1">
                            <a href="export/agent_list.php?export=1"><button type="button" class="btn btn-outline-github btn-sm">Export</button></a>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
                        <table class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
                								  <th>Sr No.</th>                                   
                                  <th>Agent Name</th>
                                  <th>Agent Mobile</th>
                					        <th>Agent Email</th>
                						      <th>Agent Area</th>
                						      <th>Agent Address</th>
                                  <th>Agent Profit Type</th>
                						      <th>Agent Status</th>
                						      <!-- <th>Agent App Status(On/Off)</th>
                						      <th>Agent Total Reject</th>
                							    <th>Agent Total Accept</th>
                							    <th>Agent Total Complete</th>		 -->	
                                  <th>Action</th>		
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($username == 'admin' || $check_menu_agent['view_g'] ==1){
                                  $jj = $con->query("select * from agents  order by id desc");
                                }else{
                                  $jj = $con->query("select * from agents where created_by =".$admin_id." order by id desc");
                                }
                                
                                $i=0;
                                while($rkl = $jj->fetch_assoc())
                                {
                                    $i = $i + 1;
                                ?>
                                <tr>
                                  <td><?php echo $i;?></td>
                                    
                                  <td><?php echo $rkl['name'];?></td>
                                  <td><?php echo $rkl['mobile'];?></td>
								                  <td><?php echo $rkl['email'];?></td>
								                  <td><?php $ad = $con->query("select * from area_db where id=".$rkl['area_id']."")->fetch_assoc(); echo $ad['name'];?></td>
                                  <td><?php echo $rkl['address'];?></td>
                                  <td><?php echo $rkl['profit_type'];?></td>								  
                								  <td><?php if($rkl['status'] == 1){echo 'Active';}else {echo 'Deactive';}?></td> 
                								  <!-- <td><?php if($rkl['a_status'] == 1) {echo 'On';}else {echo 'Off';}?></td> 
                								  <td><?php echo $rkl['reject'];?></td>
                								  <td><?php echo $rkl['accept'];?></td>
                								  
                                  <td><?php echo $rkl['complete'];?></td> -->

                                  <td>
                    									<?php if($username == 'admin'|| $check_menu_agent['edit'] ==1){ 
                                        if($rkl['status'] == 0) {?>

                    									<a href="?status=1&rid=<?php echo $rkl['id'];?>">
                                      	<button class="btn btn-success"   data-original-title="" title="">Make Active
                                        </button>
                                      </a>
                    									<?php } else { ?>
                    								<a	href="?status=0&rid=<?php echo $rkl['id'];?>">
                                    	<button class="btn btn-danger"  href="?status=0&rid=<?php echo $rkl['id'];?>" data-original-title="" title="">Make Deactive
                                      </button>
                    								</a>
                    									<?php }} ?>
                    							</td>

                                  <td>
                                  <?php if($username == 'admin'|| $check_menu_agent['edit'] ==1){ ?>
                                    
                                    <a class="primary"  href="add_agent.php?edit=<?php echo $rkl['id'];?>" data-original-title="" title="">
                                                              <i class="ft-edit font-medium-3"></i>
                                                          </a>
                                  <?php } if($username == 'admin'|| $check_menu_agent['delete'] ==1){ ?>   

                                    <a class="danger" href="?dele=<?php echo $rkl['id']?>" data-original-title="" title="">
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
if(isset($_GET['status']))
{
$status = $_GET['status'];
$id = $_GET['rid'];

  $con->query("update agents set status=".$status." where id=".$id."");  
?>
	 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.info('Agent Status Update Successfully!!');
	setTimeout(function()
	{
		window.location.href="agentslist.php";
	},1500);
    
  });
  </script>
  <?php
}


if(isset($_GET['dele']))
{
$con->query("delete from agents where id=".$_GET['dele']."");
?>
    <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('selected agent deleted successfully.');
    setTimeout(function()
  {
    window.location.href="agentslist.php";
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