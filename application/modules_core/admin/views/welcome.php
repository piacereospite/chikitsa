<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<?php
    $admin = $this->session->userdata('user_name');
?>
<h1>Welcome <?php echo $admin; ?> To admin pannel</h1>
