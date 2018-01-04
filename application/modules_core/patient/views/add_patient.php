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
    <h2>Add Patient</h2><br/>
    <span class="err"><?php echo validation_errors(); ?></span>
    <?php echo form_open_multipart('patient/insert/') ?>
    <input type="hidden" name="contact_id" class="inline" value=""/>
<!--        <input type="hidden" name="address_id" class="inline" value=""/>-->
    <input type="hidden" name="patient_id" class="inline" value=""/>
    <div>
        <label for="first_name">Name</label> 
        <input type="input" name="first_name" class="inline" value=""/>
        <input type="input" name="middle_name" class="inline" value=""/>
        <input type="input" name="last_name" class="inline" value=""/><br/>
    </div>        
    <div id="pic" style="float:right;width:500px;">        
        <img id="blah" src="<?php echo base_url(),"/images/Profile.png" ?>" alt="your image"  height="100" width="100" /><br />
        <input type="file" id="userfile" name="userfile" size="20" onchange="readURL(this);" />
        <input type="hidden" id="src" name="src" value="" />
    </div>    
    <div>
        <label for="reference_by">Reference By</label>
        <input type="input" name="reference_by" value=""/><br/>
    </div>
    <div>
        <label for="phone_number">Phone Number</label>
        <input type="input" name="phone_number" value=""/><br/>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="input" name="email" value=""/><br/>
    </div>
    <div>
        <label for="type">Address Type</label> 
        <select name="type">
            <option></option>
            <option value="Home">Home</option>
            <option value="Office">Office</option>
        </select><br/>
    </div>
    <div>
        <label for="address_line_1">Address Line 1</label> 
        <input type="input" name="address_line_1" value=""/><br/>
    </div>
    <div>
        <label for="address_line_2">Address Line 2</label> 
        <input type="input" name="address_line_2" value=""/><br/>
    </div>
    <div>
        <label for="city">City</label> 
        <input type="input" name="city" value=""/><br/>
    </div>
    <div>
        <label for="state">State</label> 
        <input type="input" name="state" value=""/><br/>
    </div>
    <div>
        <label for="postal_code">Postal Code</label> 
        <input type="input" name="postal_code" value=""/><br/>
    </div>
    <div>
        <label for="country">Country</label> 
        <input type="input" name="country" value=""/><br/>
    </div>    
    <div class="button_link">
        <button class="button" type="submit" name="submit" />Save</button>
    </div>
</form>
</div>