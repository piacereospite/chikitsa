<div class="form_style">
    <h2>Edit User</h2>
    <?php $level = $user['level']; ?>

    <?php echo form_open('admin/change_profile/'); ?>

    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" /><br/>
    <span class="err"><?php echo form_error('name'); ?></span>
    
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>" readonly="readonly"/><br/>

    <label for="oldpassword">Old Password</label>
    <input type="password" name="oldpassword" id="oldpassword" value="" /><br/>
    <span class="err"><?php echo form_error('oldpassword'); ?></span>
    
    <label for="newpassword">New Password</label>
    <input type="password" name="newpassword" id="newpassword" value=""/><br/>
    <span class="err"><?php echo form_error('newpassword'); ?></span>

    <label for="passconf">Confirm Password</label>
    <input type="password" name="passconf" id="passconf" value=""/><br/>
    <span class="err"><?php echo form_error('passconf'); ?></span>

    <div class="button_link">
        <button type="submit" name="submit" class="button">Edit</button>
    </div>
    <?php echo form_close(); ?>

</div>
