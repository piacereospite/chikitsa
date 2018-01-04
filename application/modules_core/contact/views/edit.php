<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                .attr('src', e.target.result)
                .width(100)
                .height(100);
            };

            reader.readAsDataURL(input.files[0]);
            
        }
    }
</script>
<div class="form_style">
    <h2>Edit Contact</h2><br/>
    <span class="err"><?php echo validation_errors(); ?></span>
    <?php echo form_open_multipart('contact/edit/' , $patient_id) ?>
    <input type="hidden" name="contact_id" class="inline" value="<?= $contacts['contact_id']; ?>"/>
<!--        <input type="hidden" name="address_id" class="inline" value="<?= $address['address_id']; ?>"/>-->
    <input type="hidden" name="patient_id" class="inline" value="<?= $patient_id; ?>"/>
    <div>
        <label for="first_name">Name</label> 
        <input type="input" name="first_name" class="inline" value="<?php echo $contacts['first_name'] ?>"/>
        <input type="input" name="middle_name" class="inline" value="<?php echo $contacts['middle_name'] ?>"/>
        <input type="input" name="last_name" class="inline" value="<?php echo $contacts['last_name'] ?>"/><br/>
    </div>        
    <div id="pic" style="float:right;width:500px;">            
        <!--        <label for="pic" style="text-align:left;">Picture</label><br/>-->
        <img id="blah" src="<?php echo base_url(),$contacts['contact_image']; ?>" alt="your image"  height="100" width="100" /><br />
        <input type="file" id="userfile" name="userfile" size="20" onchange="readURL(this);" />
<!--        <img id="blah" src="<?php echo $contacts['contact_image']; ?>" alt="your image"  height="100" width="100"/>-->
        <input type="hidden" id="src" name="src" value="<?php echo $contacts['contact_image']; ?>" />
    </div>
    <div>
        <label for="display_name">Display Name</label>
        <input type="input" name="display_name" value="<?php echo $contacts['display_name']; ?>"/><br/>
    </div>
    <div>
        <label for="reference_by">Reference By</label>
        <input type="input" name="reference_by" value="<?php echo $reference_by['reference_by']; ?>"/><br/>
    </div>
    <div>
        <label for="phone_number">Phone Number</label>
        <input type="input" name="phone_number" value="<?php echo $contacts['phone_number']; ?>"/><br/>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="input" name="email" value="<?php echo $contacts['email']; ?>"/><br/>
    </div>
    <div>
        <label for="type">Address Type</label> 
        <select name="type">
            <option></option>
            <option value="Home" <?php if ($contacts['type'] == "Home") { echo "selected"; } ?>>Home</option>
            <option value="Office" <?php if ($contacts['type'] == "Office") { echo "selected"; } ?>>Office</option>
        </select><br/>
    </div>
    <div>
        <label for="type">Address Line 1</label> 
        <input type="input" name="address_line_1" value="<?php echo $contacts['address_line_1']; ?>"/><br/>
    </div>
    <div>
        <label for="type">Address Line 2</label> 
        <input type="input" name="address_line_2" value="<?php echo $contacts['address_line_2']; ?>"/><br/>
    </div>
    <div>
        <label for="city">City</label> 
        <input type="input" name="city" value="<?php echo $contacts['city']; ?>"/><br/>
    </div>
    <div>
        <label for="state">State</label> 
        <input type="input" name="state" value="<?php echo $contacts['state']; ?>"/><br/>
    </div>
    <div>
        <label for="postal_code">Postal Code</label> 
        <input type="input" name="postal_code" value="<?php echo $contacts['postal_code']; ?>"/><br/>
    </div>
    <div>
        <label for="country">Country</label> 
        <input type="input" name="country" value="<?php echo $contacts['country']; ?>"/><br/>
    </div>    
    <div class="button_link">
        <button class="button" type="submit" name="submit" />Save</button>
    </div>
</form>
</div>