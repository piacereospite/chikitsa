<div class="form_style">
    <h2>Edit Treatment</h2>
    
    <?php echo form_open('settings/edit_treatment_id/' , $treatment['id']); //Avoid concatenations in echo statement ?> 
        <label for="treatment">Treatment</label>
        <input type="text" name="treatment" id="treatment" value="<?php echo $treatment['treatment']; ?>" readonly="readonly"/><br/>        
        
        <label for="treatment_price">Charges/Fees</label>
        <input type="text" name="treatment_price" id="newpassword" value="<?php echo $treatment['price']; ?>"/><br/>
        <span class="err"><?php echo form_error('treatment_price'); ?></span>
        
        <div class="button_link">
            <button type="submit" name="submit" class="button">Edit</button>
        </div>
    </form>
</div>
