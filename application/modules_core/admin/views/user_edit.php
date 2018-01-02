<div class="form_style">
    <h2>Edit User</h2>
    <?php $level = $user['level']; ?>

    <?php echo form_open('admin/edit_user/'. $user['userid']); ?>

    <?php if($level == 'Administrator') { ?>
    <label for="level">Category</label>
    <input type="text" name="name" id="name" value="<?php echo $user['level']; ?>" readonly="readonly"/><br/>
    <?php }else { ?>
    <label for="level">Category</label>
    <select name="level">

        <option <?php if ($level == '') print 'selected'; ?> value=""></option>
        <option <?php if ($level == 'Administrator') print 'selected '; ?> value="Administrator">Administrator</option>
        <option <?php if ($level == 'Doctor') print 'selected '; ?> value="Doctor">Doctor</option>
        <option <?php if ($level == 'Staff') print 'selected '; ?> value="Staff">Staff</option>
    </select><br/>
    <span class="err"><?php echo form_error('level'); ?></span>
    <?php } ?>
    
    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" readonly="readonly"/><br/>
    
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>" readonly="readonly"/><br/>

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
