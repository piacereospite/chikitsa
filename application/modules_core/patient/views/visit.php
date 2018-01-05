<script type="text/javascript" charset="utf-8">
$(function() {
        $( "#visit_date" ).datepicker({
        dateFormat: "dd-mm-yy",
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true
    });
});
$(function() {
    $( "#followup_date" ).datepicker({
        dateFormat: "dd-mm-yy",
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
});
$(document).ready(function() {
    oTable = $('#visit_table').dataTable({
        "aaSorting": [[ 0, "asc" ]],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
} );
</script>

<div class="view_style">
    <span class="view_label">Id :</span>
    <span class="view_detail"><?php echo $patient['display_id'];?></span><br/>
    <span class="view_label">Name :</span>
    <span class="view_detail"><?php echo $patient['first_name'] , ' ' , $patient['middle_name'], ' ' , $patient['last_name'];?></span><br/> 
    <span class="view_label">Display Name :</span>
    <span class="view_detail"><?php echo $patient['display_name'];?></span><br/>
    <span class="view_label">Mobile :</span>
    <span class="view_detail"><?=$patient['phone_number'];?></span><br/>
    <span class="view_label">Email :</span>
    <span class="view_detail"><?=$addresses['email'];?></span><br/>
    <span class="view_label">Address :</span>
    <span class="view_detail"><strong>(<?php echo $addresses['type'];?>)</strong></span>
        <span class="view_detail"><?php echo $addresses['address_line_1'],',',$addresses['address_line_2'],',',$addresses['city'],',',$addresses['state'],',',$addresses['postal_code'],',',$addresses['country'];?></span><br/>     
    <span class="view_label">Reference By :</span>
    <span class="view_detail"><?php echo $patient['reference_by'];?></span><br/><br />
    
    <a class="button" title="Edit" href="<?php echo site_url("contact/edit/" . $patient['patient_id']); ?>">Edit</a>
</div>
<div class="form_style">
<h2>New Visit</h2><br/>

<span class="err"><?php echo validation_errors(); ?></span>

<?php echo form_open('patient/visit/', $patient_id) ?>  
        <?php  //Avoid concatenations in echo statement
            $level = $this->session->userdata('category');
            if($this->session->userdata('category') == 'Doctor') {
                $userid = $this->session->userdata('id');
                echo '<input type="hidden" name="doctor" value="',$patient_id,'"/>'; //Avoid concatenations in echo statement
            } else {
                $userid = 0;
            }                       
        ?>
        <label <?php if ($level == 'Doctor') { echo 'style = display:none;'; } ?> for="visit_doctor">Doctor</label>
        <select name="doctor" <?php if ($level == 'Doctor') { echo 'style = display:none;'; } ?>>
            <option></option>
            <?php foreach ($doctors as $doctor) { ?>
                <option value="<?php echo $doctor['userid'] ?>"><?= $doctor['name']; ?></option>
            <?php }  ?>
        </select><br />

        <input type="hidden" name="patient_id" value="<?=$patient_id;?>"/>
        <label for="visit_date">Visit Date</label>
        <input name="visit_date" id="visit_date" value="<?php echo date('d-m-Y'); ?>"/><br />
        <label for="visit_time">Time</label>
        <input name="visit_time" id="visit_time" value="<?php echo date('H:i:s'); ?>"/><br/>
        <label for="type">Type</label> 
        <select name="type">
            <option value="New Visit">New Visit</option>
            <option <?php if($visits){echo 'selected = "selected"';} ?> value="Established Patient">Established Patient</option>
        </select><br/>
        <label for="followup_date">Followup Date</label>
        <input name="followup_date" id="followup_date" value="<?php echo date('d-m-Y',strtotime('+'.$next_followup_days['next_followup_days'].' days',  time())); ?>"/><br />
	<label for="notes">Notes</label> 
	<textarea name="notes"></textarea><br/>
        <br/>
        <label for="visit_treatment" style="display: block;">Treatment</label>
        <select data-placeholder="Choose a Treatment..." class="chzn-select" multiple style="width:350px;" tabindex="4" name="treatment[]">
                <option value=""></option> 
            <?php foreach ($treatments as $treatment) { ?>
                <option value="<?php echo $treatment['id']."/".$treatment['treatment']."/".$treatment['price'] ?>"><?= $treatment['treatment']; ?></option>
            <?php }  ?>
            </select>

            <script src="<?=base_url()?>js/chosen.jquery.js" type="text/javascript"></script>
            <script type="text/javascript"> 
                var config = {
                    '.chzn-select'           : {},
                    '.chzn-select-deselect'  : {allow_single_deselect:true},
                    '.chzn-select-no-single' : {disable_search_threshold:10},
                    '.chzn-select-no-results': {no_results_text:'Oops, nothing found!'},
                    '.chzn-select-width'     : {width:"95%"}
                }
                for (var selector in config) {
                    $(selector).chosen(config[selector]);
                }
            </script><br />
        
        <button class="button" type="submit" name="submit" />Save</button>
        <a class="button" <?php if($appointment_id == null){ echo 'style= display:none;';} else{ echo 'href = ' , base_url() , 'index.php/appointment/change_status/' , $appointment_id , '/' , $appointment_date , '/Consultation'  , '/' , $start_time , '/Complete';}?>>Complete</a>           
    </form> 
    
</div>
<?php if ($visits) {?>
    <div id="example_wrapper" class="dataTables_wrapper" role="grid">
    <table id="visit_table" class="display">
        <thead>
            <tr><th width="100px;">Date</th><th width="100px;">Type</th><th>Notes</th><th>Doctor</th><th>Progress</th><th>Bill</th><th>Edit</th></tr>
        </thead>
        <?php $i=1; ?>        
        <?php foreach ($visits as $visit){ ?>
        <tbody>
            <tr <?php 
			        define('VAR1',  0); // avoid literals in methods calls
					define('VAR2',  2); // avoid literals in methods calls
					if ($i%VAR2 == VAR1) { echo "class='alt'"; } ?> >
                <td><?=date('d-m-Y',strtotime($visit['visit_date']));?> <?=$visit['visit_time'];?></td>
                <td><?=$visit['type']; ?></td>
                <td><?=$visit['notes']; ?><br />
                    <?php $flag = false;
                        foreach ($visit_treatments as $visit_treatment) {                        
                            if($visit_treatment['visit_id'] == $visit['visit_id'] && $visit_treatment['type'] == 'treatment'){
                                if($flag == false){
                                    echo $flag;
                                    echo $visit_treatment['particular'];
                                    $flag = true;
                                }else{
                                    echo ' ,' , $visit_treatment['particular']; //Avoid concatenations in echo statement
                                }
                            }
                        }?>
                </td>
                <td><?php foreach ($doctors as $doctor) { if($visit['userid'] == $doctor['userid']){echo $doctor['name'];} }?></td>
                <td><center><a class="button" href="<?=site_url('gallery/index')?>/<?php echo $visit['patient_id'];?>/<?php echo $visit['visit_id'];?>">Gallery</a></center></td>
                <td><center><a class="button" href="<?=site_url('patient/bill') . "/" . $visit['visit_id']. "/" . $visit['patient_id'];?>">Bill</a></center></td>
                <td><center><a class="button" href="<?=site_url('patient/edit_visit') . "/" . $visit['visit_id']. "/" . $visit['patient_id'];?>">Edit</a></center></td>
            </tr>
        </tbody>
        <?php $i++; ?>
        <?php } ?>
    </table>
    </div>
<?php } ?>
            