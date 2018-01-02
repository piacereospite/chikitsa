<script type="text/javascript" charset="utf-8">
    $(function() {
        $( "#bill_from_date" ).datepicker({
            dateFormat: "dd-mm-yy",
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
    });
    
    $(function() {
        $( "#bill_to_date" ).datepicker({
            dateFormat: "dd-mm-yy",
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
    });
</script>
<?php
$level = $this->session->userdata('category');
?>
<div class="form_style">
    <h2>Bill Repot</h2>
    <span class="err"><?php echo validation_errors(); ?></span>

    <?php echo form_open('patient/bill_detail_report'); ?>
    <table>
        <tbody>
            <tr>
                <td>From Date</td>
                <td>To Date</td>
            </tr>
            <tr>
                <td><input type="text" name="bill_from_date" id="bill_from_date" value="" /></td>
                <td><input type="text" name="bill_to_date" id="bill_to_date" value="" /></td>        

            </tr>
            <tr>
                <td <?php
    if ($level == 'Doctor') {
        echo 'style = display:none;';
    }
    ?>>Doctor</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <select name="doctor" <?php
    if ($level == 'Doctor') {
        echo 'style = display:none;';
    }
    ?>>
                        <option value="all">All</option>
<?php foreach ($doctors as $doctor) { ?>
                            <option value="<?php echo $doctor['userid'] ?>"><?= $doctor['name']; ?></option>
<?php }
?>
                    </select>
                </td>
                <td>
                    <select name="report_of">
                        <option value="all">All</option>
                        <option value="medicine">Prescription</option>
                        <option value="treatment">Treatment</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <button type="submit" name="submit" class="button">Go</button>
</div>