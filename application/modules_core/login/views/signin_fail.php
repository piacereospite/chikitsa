<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<div class="form_style">
    <h2>Sign In</h2>
    <span class="err"><?php echo validation_errors(); ?></span>

    <?php echo form_open('login/valid_signin'); ?>

    <h3><font color="red">Invalid Username and/or Password</font></h3><br />
    
<!--    <label for="level">Category</label>
    <select name="level">
        
        <option <?php // if ($level == '') print 'selected'; ?> value=""></option>
        <option <?php // if ($level == 'Administrator') print 'selected '; ?> value="Administrator">Administrator</option>
        <option <?php // if ($level == 'Doctor') print 'selected '; ?> value="Doctor">Doctor</option>
        <option <?php // if ($level == 'Staff') print 'selected '; ?> value="Staff">Staff</option>
    </select><br/>
    <span class="err"><?php // echo form_error('level'); ?></span>-->
    
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?php echo $username; ?>"/><br/>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" value=""/><br/>

    <div class="button_link">
        <button type="submit" name="submit" class="button">Sign In</button>
    </div>
</form>
</div>