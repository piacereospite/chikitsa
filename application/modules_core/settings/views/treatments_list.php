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
    <h2>Add Treatment</h2>

    <?php echo form_open('settings/treatment'); ?>
        <label for="treatment">Treatment</label>
        <input type="text" name="treatment" id="treatment" value=""/><br/>
        <span class="err"><?php echo form_error('treatment'); ?></span>

        <label for="treatment_price">Charges/Fees</label>
        <input type="text" name="treatment_price" id="treatment_price" value=""/><br/>
        <span class="err"><?php echo form_error('treatment_price'); ?></span>

        <div class="button_link">
            <button type="submit" name="submit" class="button">Add</button>
        </div>
    </form>
</div>

<?php if ($treatments) { ?>
<div id="example_wrapper" class="dataTables_wrapper" role="grid">
    <table id="patient_table" class="display">
        <thead>
            <tr><th>No</th><th>Treatment Name</th><th>Treatment Charges/Fees</th><th>Edit</th><th>Delete</th></tr>
        </thead>
        <tbody>
            <?php $i=1; $j=1 ?>
            <?php foreach ($treatments as $treatment):  ?>
            <tr <?php 
			        define("VAR1",  0); // avoid literals in methods calls
					define("VAR2",  2); // avoid literals in methods calls
					if ($i%VAR2 == VAR1) { echo "class='alt'"; } ?> >
                <td><?php echo $j; ?></td>
                <td><?php echo $treatment['treatment']; ?></td>
                <td class="right"><?php echo currency_format($treatment['price']);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>                
                <td><a class="button" title="Visit" href="<?php echo site_url("settings/edit_treatment/" . $treatment['id']); ?>">Edit</a></td>
                <td><a class="button confirmClick" title="<?php echo "Delete User : " . $treatment['treatment'] ?>" href="<?php echo site_url("settings/delete_treatment/" . $treatment['id']); ?>">Delete</a></td>
            </tr>
            <?php $i++; $j++;?>
            <?php endforeach ?>
        </tbody>
    </table>
</div>  
<?php } ?>