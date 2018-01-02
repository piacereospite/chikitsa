<script type="text/javascript" charset="utf-8">
$(function()
{
    $('#start_time').timepicker({
        'minTime': '12:00am',
	'maxTime': '12:00am'
    });    
});
$(function()
{
    $('#end_time').timepicker({
        'minTime': '12:00am',
	'maxTime': '12:00am'
    });    
});
</script>
<div class="form_style">
<h2>Clinic Details</h2>
<?php
    if (!$clinic)
    {
        $clinic_name = '';
        $tag_line = '';
        $start_time = '';
        $end_time = '';
        $time_interval = '';
        $next_followup_days = '';
        $clinic_address = '';
        $clinic_landline = '';
        $clinic_mobile = '';
        $clinic_email = '';
    }
    else
    {
        $clinic_name = $clinic['clinic_name'];
        $tag_line = $clinic['tag_line'];
        $start_time = $clinic['start_time'];
        $end_time = $clinic['end_time'];
        $time_interval = $clinic['time_interval'];
        $next_followup_days = $clinic['next_followup_days'];
        $clinic_address = $clinic['clinic_address'];
        $clinic_landline = $clinic['landline'];
        $clinic_mobile = $clinic['mobile'];
        $clinic_email = $clinic['email'];
    }
    
?>
<?php echo form_open('settings/clinic') ?>
        <label for="clinic_name">Clinic Name</label> 
	<input type="input" name="clinic_name" value="<?=$clinic_name; ?>"/><br/>
        <label for="tag_line">Tag Line</label> 
	<input type="input" name="tag_line" style="width:500px;" value="<?=$tag_line; ?>"/><br/>
        <label for="clinic_address">Clinic Address</label> 
	<textarea name="clinic_address"><?=$clinic_address; ?></textarea><br/>
        <label for="landline">Clinic Landline</label> 
	<input type="input" name="landline" value="<?=$clinic_landline; ?>"/><br/>
        <label for="mobile">Mobile</label> 
	<input type="input" name="mobile" value="<?=$clinic_mobile; ?>"/><br/>
        <label for="email">Email</label> 
	<input type="input" name="email" value="<?=$clinic_email; ?>"/><br/>
	<label for="start_time">Clinic Start Time</label> 
	<input type="input" name="start_time" id="start_time" value="<?=$start_time; ?>"/><br/>
        <label for="end_time">Clinic End Time</label> 
	<input type="input" name="end_time" id="end_time" value="<?=$end_time; ?>"/><br/>
        <label for="time_interval">Time Interval</label> 
        <select name="time_interval">
            <option <?php if($time_interval == 0.25){echo 'selected = "selected"';}  ?> value="0.25">15 Min</option>
            <option <?php if($time_interval == 0.50){echo 'selected = "selected"';}  ?> value="0.50">30 Min</option>
            <option <?php if($time_interval == 1.00){echo 'selected = "selected"';}  ?> value="1.00">1 Hour</option>
        </select><br/>
        <label for="next_followup_days">Next Followup After</label> 
        <input type="input" name="next_followup_days" id="next_followup_days" value="<?=$next_followup_days; ?>"/>    Days<br/>
        
        <div class="button_link">
            <button type="submit" name="submit" class="button" />Save</button>
        </div>
</form>
</div>