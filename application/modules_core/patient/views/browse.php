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
} );
</script>
<div class="form_style">
    <h2>Add New Patient</h2>
    
    <div class="button_link" style="padding-top: 35px; padding-left: 35px;padding-bottom: 35px;">
        <a title="Add Patient" href="<?php echo base_url()."index.php/patient/insert/" ?>" class="button">Add Patient</a>
    </div>
    
</div>
<div id="example_wrapper" class="dataTables_wrapper" role="grid">
<table id="patient_table" class="display">
    <thead>
        <tr><th>ID</th><th>Name</th><th>Display Name</th><th>Reference By</th><th>Visit</th><th>Follow Up</th><th>Delete</th></tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($patients as $patient):  ?>        
    <tr <?php
            define('VAR1',  0); // avoid literals in methods calls
			define('VAR2',  2); // avoid literals in methods calls
	        if ($i%VAR2 == VAR1) { echo "class='alt'"; } ?> >
        <td><?php echo $patient['display_id']; ?></td>
        <td><a class="link" title="Edit" href="<?php echo site_url('contact/edit/' , $patient['patient_id']); ?>"><?php echo $patient['first_name'] , ' ' , $patient['middle_name'] , ' ' , $patient['last_name'] ?></a></td>
        <td><?php echo $patient['display_name']; ?></td>
        <td><?php echo $patient['reference_by'];?></td>
        <td><a class="button" title="Visit" href="<?php echo site_url("patient/visit/" . $patient['patient_id']); ?>">Visit</a></td>
        <td><a class="button" title="Follow Up" href="<?php echo site_url("patient/followup/" . $patient['patient_id']); ?>">Follow Up</a></td>
        <td><a class="button confirmClick" title="<?php echo "Delete Patient : " . $patient['first_name'] . " " . $patient['middle_name'] . " " . $patient['last_name'] ?>" href="<?php echo site_url("patient/delete/" . $patient['patient_id']); ?>">Delete</a></td>
    </tr>
    <?php $i++; ?>
    <?php endforeach ?>
    </tbody>
</table>
</div>


