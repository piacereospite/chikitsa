<html>
    <head>
        <title></title>
        <script type="text/javascript" language="javascript" src="<?= base_url() ?>js/jquery.dropdownPlain.js"></script>

        <link rel="stylesheet" href='<?= base_url() ?>css/style.css' type="text/css"/>
    </head>
    <body>
        <div class="puchase_report">

            <h3>Receipt</h3>            
            <hr/>

            <table style="border: 0;">
                <thead>
                    <tr><th>Purchase Date</th><th>Bill No.</th><th>Supplier</th><th>Item</th><th>Quantity</th><th>Cost Price</th><th>M.R.P.</th><th>Total</th></tr>
                </thead>    
                <tbody>
                    <?php
                    foreach ($bill_totals as $bill_total) {
                        $found = false;
                        foreach ($purchases as $purchase) {
                            if ($bill_total['purchase_date'] == $purchase['purchase_date']) {
                                $date = $purchase['purchase_date'];
                                $bill_no = $purchase['bill_no'];
                                $supplier_name = $purchase['supplier_name'];
                                $item_name = $purchase['item_name'];
                                $qnt = $purchase['quantity'];
                                $cost = $purchase['cost_price'];
                                $mrp = $purchase['mrp'];
                                $amount = ($purchase['quantity'] * $purchase['cost_price']);
                                $found = true;
                            }
                            if ($found) {
                                ?>
                                <tr>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $bill_no ?></td>
                                    <td><?php echo $supplier_name; ?></td>
                                    <td><?php echo $item_name; ?></td>
                                    <td style="text-align: right;"><?php echo $qnt; ?></td>                    
                                    <td style="text-align: right;"><?php echo $cost; ?></td>
                                    <td style="text-align: right;"><?php echo $mrp; ?></td>
                                    <td style="text-align: right;"><?php echo currency_format($amount); if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>
                                </tr>
                                <?php
                                $found = false;
                            }
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>                    
                            <td></td>
                            <td style="text-align: right;"><strong>Total</strong></td>
                            <td style="text-align: right;"><strong><?php echo currency_format($bill_total['total']); if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></strong></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>

            </table>

        </div>

    </body>
</html>