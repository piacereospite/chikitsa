<script type="text/javascript" charset="utf-8">
$(function()
{
    $(".confirmClick").click( function() { 
        if ($(this).attr('title')) {
            var question = 'Are you sure you want to ' + $(this).attr('title').toLowerCase() + '?';
        } else {
            var question = 'Are you sure you want to do this action?';
        }
        if ( confirm( question ) ) {
            [removed].href = this.src;
        } else {
            return false;
        }
    });
    
});
$(document).ready(function() {
    oTable = $('#patient_table').dataTable({
        "aaSorting": [[ 1, "asc" ]],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
} )
</script>
<div class="form_style">
    <h2>Add New User</h2>
    <?php $level = $this->input->post('level'); ?>
    
    <?php echo form_open('admin/users'); ?>
    
    <label for="level">Category</label>
    <select name="level">
        
        <option <?php if ($level == '') print 'selected'; ?> value=""></option>
        <option <?php if ($level == 'Administrator') print 'selected '; ?> value="Administrator">Administrator</option>
        <option <?php if ($level == 'Doctor') print 'selected '; ?> value="Doctor">Doctor</option>
        <option <?php if ($level == 'Staff') print 'selected '; ?> value="Staff">Staff</option>
    </select><br/>
    <span class="err"><?php echo form_error('level'); ?></span>
    
    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>"/><br/>
    <span class="err"><?php echo form_error('name'); ?></span>
    
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>"/><br/>
    <span class="err"><?php echo form_error('username'); ?></span>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" value=""/><br/>
    <span class="err"><?php echo form_error('password'); ?></span>
    
    <label for="passconf">Confirm Password</label>
    <input type="password" name="passconf" id="passconf" value=""/><br/>
    <span class="err"><?php echo form_error('passconf'); ?></span>
    
    <div class="button_link">
        <button type="submit" name="submit" class="button">Add User</button>
    </div>
    <?php echo form_close(); ?>

</div>
<?php
$demo = $this->config->item('demo');
if($user){
?>
<div id="example_wrapper" class="dataTables_wrapper" role="grid">
<table id="patient_table" class="display">
    <thead>
        <tr><th>Name</th><th>User Name</th><th>Category</th><th>Edit</th><th>Delete</th></tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($user as $u):  ?>
    <tr <?php
	    define("VAR1",  0); // avoid literals in methods calls	
		define("VAR2",  2); // avoid literals in methods calls
		if ($i%VAR2 == VAR1) { echo "class='alt'"; } ?> >
        <td><?php echo $u['name']; ?></td>
        <td><?php echo $u['username']; ?></td>        
        <td><?php echo $u['level']; ?></td>
        <td><a <?php if ($demo == 1 && $u['level'] == 'Administrator') echo 'style="display:none;"' ?> class="button" title="Visit" href="<?php echo site_url("admin/edit/" . $u['userid']); ?>">Edit User</a></td>
        <td><a <?php if ($u['level'] == 'Administrator') echo 'style="display:none;"' ?> class="button confirmClick" title="<?php echo "Delete User : " . $u['username'] ?>" href="<?php echo site_url("admin/delete/" . $u['userid']); ?>">Delete User</a></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach ?>
    </tbody>
</table>
</div>
<?php } ?>

<?php  echo $demo; ?>