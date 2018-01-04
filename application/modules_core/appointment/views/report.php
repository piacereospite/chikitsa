<script type="text/javascript" charset="utf-8">
 $(function() {
    $( "#app_date" ).datepicker({
        dateFormat: "dd-mm-yy",
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true
    });
});   
 $(function()
    {
        $("#doctor").autocomplete({
            source: [<?php
$i = 0;
foreach ($doctors as $doctor) {
    if ($i > 0) {
        echo ",";
    }
    echo '{value:"' , $doctor['name'] , '",id:"' , $doctor['userid'] , '"}'; //Avoid concatenations in echo statement
    $i++;
}
?>],
                minLength: 1,//search after one characters
                select: function(event,ui){
                    //do something
                    $("#doctor_id").val(ui.item ? ui.item.id : '');                    
                }
            });   
        });
</script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
    oTable = $('#app_report_table').dataTable({        
        "aaSorting": [[ 0, "asc" ]],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
} );
</script>
<?php
foreach ($doctors as $doctor) {
    $doctor_name = $doctor['name'];
    $doctor_id = $doctor['userid'];
}

$level = $this->session->userdata('category');
?>
<div class="form_style">
    <h2>Appointment Report</h2>
    <span class="err"><?php echo validation_errors(); ?></span>
    <!--    <form action="appointment/appointment_report" method="POST">-->
    <?php echo form_open('appointment/appointment_report'); ?>
    <table>
        <tbody>
            <tr>
                <td>Date</td>
                <td <?php if($level == 'Doctor'){ echo 'style = display:none;';} ?>>Doctor</td>
            </tr>
            <tr>
                <td><input type="text" name="app_date" id="app_date" value="" /></td>
                <td><select name="doctor" <?php if($level == 'Doctor'){ echo 'style = display:none;';} ?>>
                        <option></option>
                        <?php 
                        foreach ($doctors as $doctor) {?>
                        <option value="<?php echo $doctor['userid'] ?>"><?= $doctor['name'];?></option>
                        <?php }
                        ?>
                    </select></td>        
                <td><button type="submit" name="submit" class="button">Go</button></td>
            </tr>
        </tbody>
    </table>        
    <input type="hidden" name="doctor_id" id="doctor_id" value="" />
</form>
</div>
<?php if ($app_reports) {?>
    <div id="example_wrapper" class="dataTables_wrapper" role="grid">
    <table id="app_report_table" class="display">
        <thead>
            <tr>
                <th width="100px;">Patient Name</th>
                <th width="100px;">Appointment Time</th>
                <th>Waiting Time</th>
                <th>Waiting Duration</th>
                <th>Consultation</th>
                <th>Consultation Duration</th>
                <th>Bill Amount</th></tr>
        </thead>
        <?php $i=1; ?>
        <?php foreach ($app_reports as $report):  ?>
        <tbody>
            <tr <?php 
			    define("VAR1",  0); // avoid literals in methods calls
				if ($i%2 == VAR1) { echo "class='alt'"; } ?> >
                <td><?= $report['patient_name'];?></td>                
                <td><?=$report['appointment_time']; ?></td>
                <td><?=$report['waiting_in']; ?></td>
                <td><?=$report['waiting_duration'];?></td>
                <td><?=$report['consultation_in'];?></td>
                <td><?=$report['consultation_duration'];?></td>
                <td class="right"><?php echo currency_format($report['collection_amount']);if($currency_postfix) echo $currency_postfix['currency_postfix']; ?></td>
            </tr>
        </tbody>
        <?php $i++; ?>
        <?php endforeach ?>
    </table>
    </div>
<?php } else { ?>
    <div id="example_wrapper" class="dataTables_wrapper" role="grid">
    <table id="app_report_table" class="display">
        <thead>
            <tr>
                <th width="100px;">Patient Name</th>
                <th width="100px;">Appointment Time</th>
                <th>Waiting Time</th>
                <th>Waiting Duration</th>
                <th>Consultation</th>
                <th>Consultation Duration</th>
                <th>Bill Amount</th></tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>No Record Found</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    </div>
<?php } ?>