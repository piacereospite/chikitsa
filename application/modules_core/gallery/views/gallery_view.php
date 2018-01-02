<script type="text/javascript">
    function chkcontrol(j) {
        var total=0;
        for(var i=0; i < document.image_gallery.patient_image.length; i++){
            if(document.image_gallery.patient_image[i].checked){
                total =total +1;
            }
            if(total > 2){
                alert("Please Select only Two") 
                document.image_gallery.patient_image[j].checked = false ;
                return false;
            }
        }
    } 
//   $("input:checkbox").click(function() {
//
//  var bol = $("input:checkbox:checked").length >= 4;     
//  $("input:checkbox").not(":checked").attr("disabled",bol);
</script>


<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<!--<script>
function openLink(firstlink,secondlink){
document.getElementById('linkopen').innerHTML='<iframe src="'+firstlink+'"></iframe><iframe src="'+secondlink+'"></iframe>';
}
</script>

<a href="javascript:;" target="_blank" onclick="openLink('http://localhost/chikitsa0.0.4/patient_images/S00005_150520135.jpg','http://localhost/chikitsa0.0.4/patient_images/S00005_15052013.jpg');">Open two Link</a>
<div id="linkopen"></div>-->
<?php
// put your code here
?>
<div class="form_style">
    <h2><?php echo $patient->first_name . " " . $patient->last_name; ?></h2>
    <!--    <h2>Patient Images</h2>-->
    <a href="<?php echo base_url()."/index.php/patient/visit/" . $patient_id; ?>">Back to Visit</a>
    <span class="err"><?php echo validation_errors(); ?></span>
    <?php
    foreach ($upload_error as $error) {
        echo $error;
    }
    ?>
    <form action="<? echo site_url('gallery/add_image') ?>" method="POST" enctype="multipart/form-data">       
        <input type="file" id="userfile" name="userfile" value="" />
        <input type="submit" value="upload" name="upload" />
        <span style="color:red;">Jpg File format is allowed &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Image Size: 800 * 800</span>
        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>" />
        <input type="hidden" name="visit_id" value="<?php echo $visit_id; ?>" />
        <input type="hidden" name="display_id" value="<?php echo $patient->display_id; ?>" />
    </form>    
    <form name="image_gallery" id="image_gallery" action="<?php echo site_url('gallery/image_compare') ?>" method="post">
        
        <div class="img_wrapper">        
            <?php $i = 0;
            foreach ($images as $image) {
            ?>
                <div class="imgs">
                    <a  href="<?php echo base_url() . $image['visit_img_path']; ?>" rel="lightbox[roadtrip]" title="<?= $image['img_name']; ?>"><img class="patient_img" src="<?php echo base_url() . $image['visit_img_path']; ?>" /></a>
                    <div class="img_name"><?= $image['img_name']; ?></div>
                    <input onclick="chkcontrol(<?php echo $i; ?>)" type="checkbox" name="patient_image[]" value="<?php echo base_url() . $image['visit_img_path']. " ". $image['img_name']; ?>" style="margin-left: 45%;" />
                </div>
            <?php 
            $i++;
            } ?>         
        </div>
        <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>" />
        <input type="hidden" name="visit_id" value="<?php echo $visit_id; ?>" />
        <input type="hidden" name="patient_name" value="<?php echo $patient->first_name . " " . $patient->last_name; ?>" />               
        <div class="button_link">
            <button type="submit" name="submit" class="button">Compare</button>
        </div>                
    </form>
</div>