<script type="text/javascript">
 
    $(document).ready(function(){
 
        $(".slidingDiv").hide();
        $(".show_hide").show();
 
        $('.show_hide').click(function(){
            $(".slidingDiv").slideToggle();
        });
 
    });
 
</script>
<style>
    .slidingDiv {
        /*        height:300px;*/
        padding:20px;
        margin-top:10px;
        /*        border-bottom:5px solid #3399FF;*/
    }

    .show_hide {
        display:none;
    }


</style>
<script type="text/javascript" charset="utf-8">
    $(function() {
        $( "#followup_date" ).datepicker({
            dateFormat: "dd-mm-yy",
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
    });
</script>
<?php
$y = date('Y');
$m = date('n');
$d = date('j');
$timezone = "Asia/Calcutta";
if (function_exists('date_default_timezone_set'))
    date_default_timezone_set($timezone);
$t = time('H:i A');
?>
<div class="form_style">
    <h2>Follow-Up Form</h2>
    <div class="button_link" style="padding-top: 50px; padding-left: 35px;" >        
        <a href="#" class="show_hide button" style="mar">Update Date</a>
        <a class="button" href="<?php echo base_url() , '/index.php/appointment/edit/' , $y , '/' , $m , '/' , $d , '/' , $t , '/' , $patient_id ?>">Add Appointment</a>
        <a class="button" href="<?php echo base_url() , '/index.php/patient/dismiss_followup/' , $patient_id ?> ">Dismissed Followup</a>

    </div>
    
    <?php  $follow_up = date('d-m-Y', strtotime($follow_up['followup_date']));    ?>
    
    <div class="slidingDiv">

        <?php echo form_open('patient/change_followup_date/' , $patient_id) ?>    
        <table>
            <tr>
                <td><label for="followup_date">Follow-Up Date</label></td>            
            </tr>
            <tr>
                <td><input type="text" name="followup_date" id="followup_date" value="<?php echo $follow_up; ?>"/></td>            
            </tr>
        </table>
        <div class="button_link" >
            <button class="button" type="submit" name="submit" />Save</button>
        </div>
        </form>
    </div>
</div>