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
    oTable = $('#supplier_table').dataTable({
        "aaSorting": [[ 1, "asc" ]],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
} );
</script>
<div class="form_style">
<h2>Suppliers</h2>
<?php echo form_open('stock/supplier') ?>
        <label for="supplier_name">Supplier Name</label> 
	<input type="input" name="supplier_name" /><br/>
        <label for="contact_number">Contact Number</label> 
	<input type="input" name="contact_number"/><br/>
        <div class="button_link">
            <button type="submit" name="submit" class="button" />Save</button>
        </div>
</form>

<div id="example_wrapper" class="dataTables_wrapper" role="grid">
<table id="supplier_table" class="display">
    <thead>
    <tr><th>ID</th><th>Supplier Name</th><th>Contact Number</th><th>Edit</th><th>Delete</th></tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($suppliers as $supplier):  ?>
    <tr>
        <td><?php echo $supplier['supplier_id'] ?></td>
        <td><?php echo $supplier['supplier_name'] ?></td>
        <td><?php echo $supplier['contact_number'] ?></td>
        <td><a class="button" title="Edit" href="<?php echo site_url("stock/edit_supplier/" . $supplier['supplier_id']); ?>">Edit</a></td>
        <td><a class="button confirmClick" title="<?php echo "Delete Supplier :" . $supplier['supplier_name']?>" href="<?php echo site_url("stock/delete_supplier/" . $supplier['supplier_id']); ?>">Delete</a></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach ?>
    </tbody>
</table>
</div>

</div>