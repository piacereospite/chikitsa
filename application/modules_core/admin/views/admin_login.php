<div class="form_style">
    <h2>Admin Log In</h2>
    
    <?php echo form_open('admin/valid_signin'); ?>
    
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
