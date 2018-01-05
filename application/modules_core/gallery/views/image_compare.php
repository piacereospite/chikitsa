<script language="javascript" type="text/javascript">
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
</script>
<div class="form_style">
    <h2><?php echo $this->input->post('patient_name'); ?></h2><br />
    <a href="<?php echo base_url()."/index.php/gallery/index/" . $this->input->post('patient_id') . "/" . $this->input->post('visit_id')  ?>">Gallery</a>
    <?php $p_id = $this->input->get('patient_id'); ?>
    <div style="overflow: auto;">
        <?php foreach($images as $image){
                    $img = explode(' ', $image);
        ?>
        <div class="image_compare">
            <h3><?php echo $img[1]; ?></h3>
            <img src="<?php echo $img[0]; ?>" />
        </div>
        <?php } ?>
    </div> 
</div>   