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
      if($username != 'admin' && $check_menu_banner['view_g'] !=1 && $check_menu_banner['view_o'] !=1 ){
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
                    <div class="row">
                        <div class="col-md-11">
                            <h4 class="card-title ml-1">Banner List</h4>
                        </div>
                        <div class="col-md-1">
                            <a href="export/banner_list.php?export=1"><button type="button" class="btn btn-outline-github btn-sm">Export</button></a>
                        </div>
                    </div>
                </div>
                <div class="card-body collapse show">
                    <div class="card-block card-dashboard">
                       
                        <table class="table table-striped table-bordered dom-jQuery-events">
                            <thead>
                                <tr>
								 <th>Sr No.</th>
                                   
                                    <th>Banner Image</th>
                                   <th>Banner Category</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($username == 'admin' || $check_menu_banner['view_g'] ==1){
                                    $jj = $con->query("select * from banner");
                                }else{
                                    $jj = $con->query("select * from banner where created_by =".$admin_id);
                                }
                                
                                $i=0;
                                while($rkl = $jj->fetch_assoc())
                                {
                                    $i = $i + 1;
                                ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    
                                    <td><img src="<?php echo $rkl['bimg'];?>" width="100" height="100"/></td>
                                    <td><?php $ct = $con->query("select * from category where id=".$rkl['cid']."")->fetch_assoc();  if($ct['catname'] == '') {echo 'No_Category_Selected';} else {echo $ct['catname'];}?></td>
                                    <td>
                                        <?php if($username == 'admin'|| $check_menu_banner['edit'] ==1){ ?>
										<a class="primary"  href="banner.php?edit=<?php echo $rkl['id'];?>" data-original-title="" title="">
                                            <i class="ft-edit font-medium-3"></i>
                                        </a>
										<?php }if($username == 'admin'|| $check_menu_banner['delete'] ==1){ ?>
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
    if($username != 'admin'&& $check_menu_banner['delete'] != 1){
        header('Location: 404.php'); 
        die("404 error");
    }
    $con->query("delete from banner  where id=".$_GET['dele']."");
?>
	 <script type="text/javascript">
  $(document).ready(function() {
    toastr.options.timeOut = 4500; // 1.5s

    toastr.error('selected banner deleted successfully.');
   setTimeout(function()
	{
		window.location.href="bannerlist.php";
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