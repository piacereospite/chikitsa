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
    oTable = $('#item_table').dataTable({
        "aaSorting": [[ 1, "asc" ]],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
} );
</script>
<div class="form_style">
<h2>Items</h2>
<?php echo form_open('stock/item') ?>
        <label for="item_name">Item Name</label> 
	<input type="input" name="item_name" /><br/>
        <label for="desired_stock">Desired Stock</label> 
	<input type="input" name="desired_stock"/><br/>
        <div class="button_link">
            <button type="submit" name="submit" class="button" />Save</button>
        </div>
</form>
</div>
<div id="example_wrapper" class="dataTables_wrapper" role="grid">
<table id="item_table" class="display">
    <thead>
    <tr><th>ID</th><th>Item</th><th>Desired Stock</th><th>Edit</th><th>Delete</th></tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($items as $item):  ?>
    <tr>
        <td><?php echo $item['item_id'] ?></td>
        <td><?php echo $item['item_name'] ?></td>
        <td><?php echo $item['desired_stock'] ?></td>
        <td><a class="button" title="Edit" href="<?php echo site_url("stock/edit_item/" . $item['item_id']); ?>">Edit</a></td>
        <td><a class="button confirmClick" title="<?php echo "Delete Item :" . $item['item_name']?>" href="<?php echo site_url("stock/delete_item/" . $item['item_id']); ?>">Delete</a></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach ?>
    </tbody>
</table>
</div>
