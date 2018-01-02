<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    oTable = $('#sell_table').dataTable({
        "aaSorting": [[ 1, "asc" ]],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
} );
</script>
<div id="example_wrapper" class="dataTables_wrapper" role="grid">
<table id="sell_table" class="display">
    <thead>
    <tr><th>Sell Date</th><th>Patient</th><th>Sell Amount</th><th>Edit</th></tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($sells as $sell):  ?>
    <tr>
        <td><?php echo $sell['sell_date'] ?></td>
        <td><?=$sell['first_name'] ?> <?=$sell['middle_name'] ?> <?=$sell['last_name'] ?></td>
        <td><?php echo $sell['sell_amount'] ?></td>
        <td><a class="button" title="Edit" href="<?php echo site_url("stock/sell/" . $sell['sell_id']); ?>">Edit</a></td>
        
    </tr>
    <?php $i++; ?>
    <?php endforeach ?>
    </tbody>
</table>
</div>
