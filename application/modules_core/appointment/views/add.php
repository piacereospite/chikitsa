<script type="text/javascript" charset="utf-8">
$(function() {
        $( "#appdate" ).datepicker({
        dateFormat: "dd-mm-yy",
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
});
$(function()
{
    $('#start_time').timepicker({
        'minTime': '<?php echo $start_time;?>',
	'maxTime': '<?php echo $end_time;?>'
    });    
});
$(function()
{
    $('#end_time').timepicker({
        'minTime': '<?php echo $start_time;?>',
	'maxTime': '<?php echo $end_time;?>'
    });    
});
</script>


<div class="form_style">
<h2>New Appointment</h2><br/>
<span class="err"><?php echo validation_errors(); ?></span>
<?php echo form_open('appointment/add/' . $patient['patient_id']) ?>
    <input type="hidden" name="id" value=""/>
    <input type="hidden" name="patient_id" value="<?=$patient['patient_id']?>"/>
    
    <label for="title">Patient</label>
    <input type="text" name="title" value="<?php echo $patient['first_name'] . " " . $patient['middle_name'] . " " .$patient['last_name'];?>"/><br/>
    <span class="err"><?php echo form_error('level'); ?></span>
    
    <label for="start_time">Start Time</label>
    <input type="text" id="start_time" name="start_time" /><br/>
    
    <label for="end_time">End Time</label>
    <input type="text" id="end_time" name="end_time"/><br/>
    
    <label for="appointment_date">Date</label>
    <input name="appointment_date" id="appdate" value="<?php echo date("d-m-Y"); ?>" />
    <br/>
    <div class="button_link">
        <button class="button" type="submit" name="submit" />Save</button>
    </div>
</form>
</div>