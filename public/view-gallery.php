<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php


if(isset($_GET['p_id']) && isset($_GET['disease_rec_id'])){

     $patient = get_patient_by_id($_GET['p_id']);
     
     $disease_rec = get_disease_rec_by_id($_GET['disease_rec_id']);
     
      if(!empty($patient['id']) && !empty($disease_rec['id'])){
    
?>
<?php get_header("Photos of ".$patient['name']);  ?>
    <div id="wrapper">

   <?php require_once('nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Photos of <b><a href="patient.php?id=<?php echo $patient['id']; ?>"><?php echo $patient['name'];  ?></a></b> on <b> <?php echo $disease_rec['condition_name'];  ?></b></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <?php 
                echo message();
                errors();
                has_presense_errors($errors);
            ?>
            <!-- /.row -->
             <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Total Photos : <?php echo count_diseases_rec_photos($disease_rec['id'])  ?>
			</div>
                        <!-- /.panel-heading -->
                        
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                  <div style="padding: 10px;">
                                     
                                      <?php
                                       
                                            $result = get_images_by_disease_rec_id($disease_rec['id']);
                                            while($images_id_set = mysqli_fetch_assoc($result)){
                                                
                                                $images_set = get_image_by_id($images_id_set['image_id']);
                                                
                                                
                                                
                                                echo '<div style="width:200px; float:left; margin:3px;">';
                                                echo '<a  title="View larger"  style="width:200px; height:200px; display:block;" class="fancybox-buttons" data-fancybox-group="button" href="http://'.$_SERVER["HTTP_HOST"].'/projects/dental/public/uploads/'.$patient['id']."/diseases/".$disease_rec['id']."/".$images_set['url'].'">';
                                                echo '<div  style="width:200px; height:200px; background:url(\'http://'.$_SERVER["HTTP_HOST"].'/projects/dental/public/uploads/'.$patient['id']."/diseases/".$disease_rec['id']."/".$images_set['url'].'\'); background-size:cover; "></div>';
                                                echo '<a class="btn btn-default" onclick="return confirm(\'Are you sure ?\')" href="image-delete.php?image_id='.$images_set['id'].'&p_id='.$patient['id'].'&disease_rec_id='.$disease_rec['id'].'" style="color:#000; width:100%; margin-top:10px; text-align:center;"><i class="fa fa-trash-o fa-2x"></i></a>';
                                                echo '<div style="clear:both; line-height:1px;"></div>';
                                                echo '</div>';
                                                
                                                if(mysqli_num_rows($result) == 0){
                                                    echo "No images";
                                                }
                                            }
                                            echo '<div style="clear:both; line-height:1px;"></div>';
                                       
                                        ?>
                                    </div> 
                            </div>
                            <!-- /.table-responsive -->
                          
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                    <button class="open_uploader_disease_rec btn btn-success " type="button" data-toggle="modal" data-target="#image_gallery" >Upload more images</button>
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            
            
            		
				
				<!-- Modal -->
<div class="modal fade" id="image_gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
           
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                           <span aria-hidden="true">&times;</span>
                           <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       Upload an Image
                    </h4>
                </div>
                
                <!-- Modal Body -->
                <div class="modal-body">
                   
                    <form method="get" action="image-uploader.php?p_id=<?php echo $patient['id']; ?>&disease_rec_id=<?php echo $disease_rec['id']; ?>" class="dropzone" id="my-dropzone">
                        <input type="text" hidden value="<?php echo $patient['id']; ?>" name="p_id">
                        <input id="disease_rec_id" value="<?php echo $disease_rec['id']; ?>" type="text" hidden name="disease_rec_id">
                    </form> 
                    
                </div>
                <form method="post" action="patient.php?id=<?php echo $patient['id'];  ?>">
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" name="upload_image" class="btn btn-primary" value="Done">
                </div>
                </form>
        </div>
    </div>
</div>		
		
            
            
            

                            <!-- /.modal -->
        </div>
        <!-- /#page-wrapper -->

    </div>

    <?php

    }else{
        redirect_to("patient.php");
    }

    ?>
    <!-- /#wrapper -->

<?php require_once('footer.php'); ?>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
 <!-- Add fancyBox main JS and CSS files -->
 <script type="text/javascript" src="../public/widgets/fancybox/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="../public/widgets/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox-buttons').fancybox({
				openEffect  : 'fade',
				closeEffect : 'fade',

				prevEffect : 'fade',
				nextEffect : 'fade',

				closeBtn  : true,

				helpers : {
					title : {
						type : 'over'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title =  (this.index + 1) + ' / ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});
                        
                        
                        
		});
	</script>
          
</body>

</html>

<?php
}elseif(isset($_GET['p_id']) && isset($_GET['treatment_rec_id'])){
    
     $patient = get_patient_by_id($_GET['p_id']);
     
     $treatment_rec = get_treatment_rec_by_id($_GET['treatment_rec_id']);
     
     if(!empty($patient['id']) && !empty($treatment_rec['id'])){
    
?>


<?php get_header("Photos of ".$patient['name']);  ?>
    <div id="wrapper">

   <?php require_once('nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Photos of <b><a href="patient.php?id=<?php echo $patient['id']; ?>"><?php echo $patient['name'];  ?></a></b> on <b> <?php echo $treatment_rec['treatment'];  ?></b></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <?php 
                echo message();
                errors();
                has_presense_errors($errors);
            ?>
            <!-- /.row -->
             <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Total Photos : <?php echo count_patient_photos($patient['id']) ?>
			</div>
                        <!-- /.panel-heading -->
                        
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                  <div style="padding: 10px;">
                                      <?php
                                        $result = get_images_by_treatment_rec_id($treatment_rec['id']);
                                            while($images_id_set = mysqli_fetch_assoc($result)){
                                                
                                                $images_set = get_image_by_id($images_id_set['image_id']);
                                                
                                                echo '<div style="width:200px; float:left; margin:3px;">';
                                                echo '<a  title="View larger"  style="width:200px; height:200px; display:block;" class="fancybox-buttons" data-fancybox-group="button" href="http://'.$_SERVER["HTTP_HOST"].'/projects/dental/public/uploads/'.$patient['id']."/treatments/".$treatment_rec['id']."/".$images_set['url'].'">';
                                                echo '<div  style="width:200px; height:200px; background:url(\'http://'.$_SERVER["HTTP_HOST"].'/projects/dental/public/uploads/'.$patient['id']."/treatments/".$treatment_rec['id']."/".$images_set['url'].'\'); background-size:cover; "></div>';
                                                echo '<a class="btn btn-default" onclick="return confirm(\'Are you sure ?\')" href="image-delete.php?image_id='.$images_set['id'].'&p_id='.$patient['id'].'&treatment_rec_id='.$treatment_rec['id'].'" style="color:#000; width:100%; margin-top:10px; text-align:center;"><i class="fa fa-trash-o fa-2x"></i></a>';
                                                echo '<div style="clear:both; line-height:1px;"></div>';
                                                echo '</div>';
                                                
                                                if(mysqli_num_rows($result) == 0){
                                                    echo "No images";
                                                }
                                            }
                                            echo '<div style="clear:both; line-height:1px;"></div>';
                                        ?>
                                    </div> 
                            </div>
                            <!-- /.table-responsive -->
                          
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    
                    <button class="open_uploader_treatment_rec btn btn-success " type="button" data-toggle="modal" data-target="#image_gallery_treatment" >Upload more images</button>
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            
            
            		
				
				
				<!-- Modal -->
<div class="modal fade" id="image_gallery_treatment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
           
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                           <span aria-hidden="true">&times;</span>
                           <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       Upload images
                    </h4>
                </div>
                
                <!-- Modal Body -->
                <div class="modal-body">
                    <form method="get" action="image-uploader-treatment.php?p_id=<?php echo $patient['id']; ?>&treatment_rec_id=<?php echo $treatment_rec['id']; ?>" class="dropzone" id="my-dropzone">
                        <input type="text" hidden value="<?php echo $patient['id']; ?>" name="p_id">
                        <input id="treatment_rec_id" value="<?php echo $treatment_rec['id']; ?>" type="text" hidden name="treatment_rec_id">
                    </form> 
                    
                </div>
                <form method="post" action="patient.php?id=<?php echo $patient['id'];  ?>">
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" name="upload_image" class="btn btn-primary" value="Done">
                </div>
                </form>
        </div>
    </div>
</div>		

                                
                                
		                            <!-- /.modal -->
        </div>
        <!-- /#page-wrapper -->

    </div>

<?php

     }else{
         redirect_to("patient.php");
     }
?>
    <!-- /#wrapper -->

<?php require_once('footer.php'); ?>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
 <!-- Add fancyBox main JS and CSS files -->
 <script type="text/javascript" src="../public/widgets/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="../public/widgets/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox-buttons').fancybox({
				openEffect  : 'fade',
				closeEffect : 'fade',

				prevEffect : 'fade',
				nextEffect : 'fade',

				closeBtn  : true,

				helpers : {
					title : {
						type : 'over'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title =  (this.index + 1) + ' / ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});
                        
                        
                        
		});
	</script>
<?php

}

?>