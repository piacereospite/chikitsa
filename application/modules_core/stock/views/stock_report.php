
    <table class='table_style'>
        <thead>
            <tr>
                <th>Item Name</th><th>Desired Stock</th><th>Available Stock</th><th>Bought Quantity</th><th>Sold Quantity</th><th>Bought At</th><th>Sold At</th><th>Gain</th>
            </tr>
        </thead>
        <?php foreach ($stock_report as $stock){ ?>
        <tbody>
            <tr>
                <td><?php echo $stock['item_name']; ?></td>
                <td style='text-align:right'><?php echo $stock['desired_stock']; ?></td>
                <?php if (($stock['purchase_quantity']-$stock['sell_quantity'])< $stock['desired_stock'])
                {   
                    echo "<td class='red-bg' style='text-align:right'>";
                }
                else
                {
                    echo "<td style='text-align:right'>";
                } 
                echo $stock['purchase_quantity']-$stock['sell_quantity']."</td>"; ?>
                <td style='text-align:right'><?php echo $stock['purchase_quantity'];?></td>
                <td style='text-align:right'><?php echo $stock['sell_quantity']; ?></td>
                <td style='text-align:right'><?php echo currency_format(sprintf("%01.2f", $stock['avg_purchase_price']));if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>
                <?php $profit=$stock['avg_sell_price']-$stock['avg_purchase_price']; ?>
                <td style='text-align:right'><?php echo currency_format(sprintf("%01.2f", $stock['avg_sell_price']));if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>
                <td style='text-align:right'><?php echo currency_format(sprintf("%01.2f", $profit));if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td></tr>
        <?php } ?>
        </tbody>
    </table>