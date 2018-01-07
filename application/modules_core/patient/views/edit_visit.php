<div class="form_style">
    <h2>Edit Visit</h2><br />
    
    <span class="err"><?php echo validation_errors(); ?></span>  

    <?php echo form_open('patient/edit_visit'. $visit['visit_id'] . '/' . $follow_up['patient_id']) ?>
        <label for="visit_doctor">Doctor</label>
        <input name="visit_doctor" id="visit_doctor" value="<?= $doctor['name'] ?>" readonly/><br />
        <label for="visit_date">Visit Date</label>
        <input name="visit_date" id="visit_date" value="<?= date('d-m-Y', strtotime($visit['visit_date'])) ?>" readonly/><br />
        <label for="visit_time">Visit Time</label>
        <input name="visit_time" id="visit_time" value="<?= date('H:i:s', strtotime($visit['visit_time'])) ?>" readonly/><br />
        <label for="type">Visit Time</label>
        <input name="type" id="type" value="<?= $visit['type'] ?>" readonly/><br />
        <label for="followup_date">Followup Date</label>
        <input name="followup_date" id="followup_date" value="<?= date('d-m-Y', strtotime($follow_up['followup_date'])) ?>" readonly/><br />
        <label for="notes">Notes</label> 
        <textarea name="notes"><?= $visit['notes'] ?></textarea><br/>
        <br/>
        <label for="visit_treatment" style="display: block;">Treatment</label>
        <select data-placeholder="Choose a Treatment..." class="chzn-select" multiple style="width:350px;" tabindex="4" name="treatment[]">
            <option value=""></option> 
            <?php            
            foreach ($treatments as $treatment) { 
            ?>
                <option value="<?php echo $treatment['id'] . "/" . $treatment['treatment'] . "/" . $treatment['price'] ?>" 
                    <?php 
                        foreach ($visit_treatments as $visit_treatment) { 
                            if($visit_treatment['particular'] == $treatment['treatment']) 
                            {   echo "selected='selected'";
                                
                            }
                        }
                    ?>
                >
                <?= $treatment['treatment']; ?></option>
            <?php 
            }
            ?>
        </select>

        <script src="<?= base_url() ?>js/chosen.jquery.js" type="text/javascript"></script>
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
        </script>
        <br />
        
        <button class="button" type="submit" name="submit" />Edit</button>
        <a class="button" href="<?php echo base_url() . "/index.php/patient/visit/" . $follow_up['patient_id']; ?>">Cancel</a>
    </form>
</div>