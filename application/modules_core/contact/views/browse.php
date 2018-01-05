<div class="form_style">
<?php echo form_open('contact/index') ?>

	<label for="search_name">Search By Name</label> 
	<input type="input" name="search_name"/>
        <button type="submit" name="submit" class="search" /></button>
</form>
</div>
<a class="button" href="<?php echo site_url("contact/add"); ?>" title="Add"   >Add</a>
<table class="table_style">
    <tr><th>ID</th><th>Name</th><th>Number</th><th>Address</th><th>Edit</th><th>Delete</th></tr>
    <?php $i=1; ?>
    <?php foreach ($contacts as $contact):  ?>
    <tr <?php 
	    define('VAR1',  0); // avoid literals in methods calls
		define('VAR2',  2); // avoid literals in methods calls
	    if ($i%VAR2 == VAR1) { echo "class='alt'"; } ?> >
        <td><?php echo $contact['contact_id'] ?></td>
        <td><?php echo $contact['first_name'] , ' ' , $contact['middle_name'] , ' ' , $contact['last_name'] ?></td> 
        <td><?php echo $contact['phone_number'] ?></td>
        <td><?php echo $contact['address_line_1'] , ' ' , $contact['address_line_2']  , ' ' , $contact['city']  , ' ' , $contact['state'] , ' ' , $contact['country']  ?></td>
        <td><a class="edit" title="Edit" href="<?php echo site_url("contact/edit/" . $contact['contact_id']); ?>"></a></td>
        <td><a class="button" title="Delete" href="<?php echo site_url("contact/delete/" . $contact['contact_id']); ?>">Delete</a></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach ?>
</table>
