<div class="form_style">
    <h2>Sign In</h2>
    <?php // $level = $this->input->post('level'); ?>

    <?php echo form_open('login/valid_signin'); ?>
    
<!--    <label for="level">Category</label>
    <select name="level">
        
        <option <?php // if ($level == '') print 'selected'; ?> value=""></option>
        <option <?php // if ($level == 'Administrator') print 'selected '; ?> value="Administrator">Administrator</option>
        <option <?php // if ($level == 'Doctor') print 'selected '; ?> value="Doctor">Doctor</option>
        <option <?php // if ($level == 'Staff') print 'selected '; ?> value="Staff">Staff</option>
    </select><br/>
    <span class="err"><?php // echo form_error('level'); ?></span>-->
    
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>"/><br/>
    <span class="err"><?php echo form_error('username'); ?></span>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" value=""/><br/>
    <span class="err"><?php echo form_error('password'); ?></span>
    
    <div class="button_link">
        <button type="submit" name="submit" class="button">Sign In</button>
    </div>
    <?php echo form_close(); ?>

</div>
