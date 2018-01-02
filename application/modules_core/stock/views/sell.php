<script type="text/javascript" charset="utf-8">
$(function() {
        $( "#sell_date" ).datepicker({
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
});
$(function()
{
    $("#patient_name").autocomplete({
        source: [<?php
                $i=0;
                foreach ($patients as $patient){
                    if ($i>0) {echo ",";}
                    echo '{value:"' . $patient['first_name'] . " " . $patient['middle_name'] . " " .$patient['last_name'] . '",id:"' . $patient['patient_id'] . '"}';
                    $i++;
                }
            ?>],
        minLength: 1,//search after one characters
        select: function(event,ui){
            //do something
            $("#patient_id").val(ui.item ? ui.item.id : '');

        }
    });   
});		
$(function()
{
    $("#item_name").autocomplete({
        source: [<?php
                $i=0;
                foreach ($items as $item){
                    if ($i>0) {echo ",";}
                    echo '{value:"' . $item['item_name'] . '",id:"' . $item['item_id'] . '"}';
                    $i++;
                }
            ?>],
        minLength: 1,//search after one characters
        select: function(event,ui){
            //do something
            $("#item_id").val(ui.item ? ui.item.id : '');

        }
    });   
});
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
</script>
<div class="form_style">
<h2>Sell</h2>
<?php 
    if (isset($sell))
    {
        $patient_name = $sell['first_name'] . " " . $sell['middle_name'] . " " .$sell['last_name'];
        $sell_date = $sell['sell_date']; 
        $sell_id = $sell['sell_id'];
    }
    else
    {
        $patient_name = "";
        $sell_date = date("d-m-Y");
        $sell_id = "";
    }
    ?>
<?php echo form_open('stock/sell') ?>
    <input type="hidden" name="sell_id" value="<?=$sell_id?>"/>
     
    <br/>
    <input type="hidden" name="item_id" id="item_id"/>
    <table>
        <tr>
            <td><label for="sell_date">Date</label></td>
            <td><label for="patient">Patient</label></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><input type="input" name="sell_date" id="sell_date" value="<?=$sell_date; ?>"/></td>
            <td><input type="input" name="patient_name" id="patient_name" value="<?=$patient_name;?>"/></td>
            <td><input type="hidden" name="patient_id" id="patient_id"/></td>
            <td></td>
        </tr>
        <tr><td><label for="item_name">Item</label></td>
            <td><label for="quantity">Quantity</label></td>
            <td><label for="sell_price">Price</label></td>
            <td></td>
        </tr>
        <tr><td><input type="input" name="item_name" id="item_name"/></td>
            <td><input type="input" name="quantity"/></td>
            <td><input type="input" name="sell_price"/></td>
            <td><button type="submit" name="submit" class="button" />Add</button></td>
        </tr>
    </table>
</form>

<table class="table_style">
    <thead>
        <tr><th>Item</th><th>Quantity</th><th>Sell Price</th><th>Sell Amount</th><th>Delete</th></tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php $total=0; ?>
    <?php foreach ($sell_details as $sell_detail):  ?>
    <tr>
        <td><?=$sell_detail['item_name'] ?></td>
        <td style="text-align: right"><?=$sell_detail['quantity'] ?></td>
        <td style="text-align: right"><?=$sell_detail['sell_price'] ?></td>
        <td style="text-align: right"><?=$sell_detail['sell_amount'] ?></td>
        <td><a class="button confirmClick" title="<?php echo "Delete Sell Item";?>" href="<?php echo site_url("stock/delete_sell_detail/" . $sell_detail['sell_detail_id'] . "/" . $sell['sell_id']); ?>">Delete</a></td>
    </tr>
    <?php $i++; ?>
    <?php $total = $total + $sell_detail['sell_amount']; ?>
    <?php endforeach ?>
    <thead>
        <tr><th colspan="3">Total</th><th style="text-align: right"><?=$total?></th></tr>
    </thead>
    </tbody>
</table>


</div>
