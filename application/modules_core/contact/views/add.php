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
<h2>New Contact</h2><br/>

<span class="err"><?php echo validation_errors(); ?></span>

<?php echo form_open('contact/add') ?>
        
	<label for="first_name">Name</label> 
	<input type="input" name="first_name" class="inline"/>
        <input type="input" name="middle_name" class="inline" />
        <input type="input" name="last_name" class="inline"/><br/>
        
        <div id="email" style="float:right;">            
            <label for="email" style="text-align: left">Email</label><br/>
            <button class="add_email" type="button"></button>
            <div id="email_block" style="display:inline;">            
                <input type="input" name="email[]" />
            </div>
        </div>
        
        <label for="phone_number">Phone Number</label>
        <input type="input" name="phone_number"/><br/>
        
        <label for="type">Address Type</label> 
        <select name="type">
            <option value="Home">Home</option>
            <option value="Office">Office</option>
        </select><br/>
        
        <label for="type">Address Line 1</label> 
        <input type="input" name="address_line_1"/><br/>
        
        <label for="type">Address Line 2</label> 
        <input type="input" name="address_line_2"/><br/>
        
        <label for="city">City</label> 
        <input type="input" name="city"/><br/>
        
        <label for="state">State</label> 
        <input type="input" name="state"/><br/>
        
        <label for="postal_code">Postal Code</label> 
        <input type="input" name="postal_code"/><br/>
        
        <label for="country">Country</label> 
        <input type="input" name="country"/><br/>
        
        <button class="button" type="submit" name="submit" />Save</button>
        
</form>
</div>