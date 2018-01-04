<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>-->
<script type="text/javascript">
 
    $(document).ready(function(){
 
        $(".slidingDiv").hide();
        $(".show_hide").show();
 
        $('.show_hide').click(function(){
            $(".slidingDiv").slideToggle();
        });
 
    });
 
</script>
<style>
    .slidingDiv {
        /*        height:300px;*/
        padding:20px;
        margin-top:10px;
        /*        border-bottom:5px solid #3399FF;*/
    }

    .show_hide {
        display:none;
    }

</style>
<script type="text/javascript" charset="utf-8">
    $(function() {
        $( "#appdate" ).datepicker({
            dateFormat: "dd-mm-yy",
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true
        });
    });
    $(function()
    {
        $('#start_time').timepicker({
            'minTime': '<?php echo $clinic_start_time; ?>',
            'maxTime': '<?php echo $clinic_end_time; ?>',
            'step' : '<?php echo ($time_interval*60); ?>'
        });    
    });
    $(function()
    {
        $('#end_time').timepicker({
            'minTime': '<?php echo $clinic_start_time; ?>',
            'maxTime': '<?php echo $clinic_end_time; ?>',
            'step' : '<?php echo ($time_interval*60); ?>'
        });    
    });	
    $(function()
    {
        $("#patient_name").autocomplete({
            source: [<?php
$i = 0;
foreach ($patients as $patient) {
    if ($i > 0) {
        echo ",";
    }
    echo '{value:"' , $patient['first_name'] , " " , $patient['middle_name'] , " " , $patient['last_name'] , '",id:"' , $patient['patient_id'] , '",display:"' , $patient['display_name'] , '",num:"' , $patient['phone_number'] , '"}';
    $i++;
}
?>],
                minLength: 1,//search after one characters
                select: function(event,ui){
                    //do something
                    $("#patient_id").val(ui.item ? ui.item.id : '');
                    $("#phone_number").val(ui.item ? ui.item.num : '');
                    $("#display_name").val(ui.item ? ui.item.display : '');
                }
            });   
        });

        $(function()
        {
            $("#phone_number").autocomplete({
                source: [<?php
$i = 0;
foreach ($patients as $patient) {
    if ($i > 0) {
        echo ",";
    }
    echo '{value:"' , $patient['phone_number'] , '",id:"' , $patient['patient_id'] , '",display:"' , $patient['display_name'] , '",patient:"' , $patient['first_name'] , " " , $patient['middle_name'] , " " , $patient['last_name'] , '"}';
    $i++;
}
?>],
                    minLength: 1,//search after one characters
                    select: function(event,ui){
                        //do something
                        $("#patient_id").val(ui.item ? ui.item.id : '');
                        $("#patient_name").val(ui.item ? ui.item.patient : '');
                        $("#display_name").val(ui.item ? ui.item.display : '');
                    }
                });   
            });
            $(function()
            {
                $("#display_name").autocomplete({
                    source: [<?php
$i = 0;
foreach ($patients as $patient) {
    if ($i > 0) {
        echo ",";
    }
    echo '{value:"' , $patient['display_name'] , '",id:"' , $patient['patient_id'] , '",num:"' , $patient['phone_number'] , '",patient:"' , $patient['first_name'] , " " , $patient['middle_name'] , " " , $patient['last_name'] , '"}';
    $i++;
}
?>],
                        minLength: 1,//search after one characters
                        select: function(event,ui){
                            //do something
                            $("#patient_id").val(ui.item ? ui.item.id : '');
                            $("#patient_name").val(ui.item ? ui.item.patient : '');
                            $("#phone_number").val(ui.item ? ui.item.num : '');
                        }
                    });   
                });
//                $(function()
//                {
//                    $("#doctor").autocomplete({
//                        source: [<?php
//$i = 0;
//foreach ($doctors as $doctor) {
//    if ($i > 0) {
//        echo ",";
//    }
//    echo '{value:"' . $doctor['name'] . '",id:"' . $doctor['userid'] . '"}';
//    $i++;
//}
//?>],
//                            minLength: 1,//search after one characters
//                            select: function(event,ui){
//                                //do something
//                                $("#doctor_id").val(ui.item ? ui.item.id : '');                    
//                            }
//                        });   
//                    });
</script>
<?php
if ($appointment == null) {
    $header = "New Appointment";
    $title = "";
    $id = "";
    $start_time = $appointment_time;
    $appointment_endtime = date("H:i", strtotime($appointment_time) + (($time_interval*60) * 60));
    $end_time = $appointment_endtime;
    //print_r($curr_patient);
    if (isset($curr_patient)) {
        $patient_id = $curr_patient['patient_id'];
        $patient_name = $curr_patient['first_name'] . " " . $curr_patient['middle_name'] . " " . $curr_patient['last_name'];
        $phone_number = $curr_patient['phone_number'];
        $display_name = $curr_patient['display_name'];
    } else {
        $patient_id = 0;
        $patient_name = '';
        $phone_number = '';
        $display_name = '';
    }

    $doctor_name = $doctor['name'];
    $doctor_id = $doctor['userid'];
    $status = 'Appointment';
} else {
    $header = "Edit Appointment";
    $id = $appointment['appointment_id'];
    $title = $appointment['title'];
    $start_time = $appointment['start_time'];
    $end_time = $appointment['end_time'];
    $patient_id = $appointment['patient_id'];
    foreach ($patients as $patient) {
        if ($patient_id == $patient['patient_id']) {
            $patient_name = $patient['first_name'] . " " . $patient['middle_name'] . " " . $patient['last_name'];
            $phone_number = $patient['phone_number'];
            $display_name = $patient['display_name'];
        }
    }
    //foreach ($doctors as $doctor) {
    //$doctor_name = $doctor['name'];
    //$doctor_id = $doctor['userid'];
    //}
    $status = $app_status;
    $doctor_id = $appointment['userid'];
    //foreach ($doctors as $doctor) {
    //   if ($doctor['userid'] == $doc_id) {
            $doctor_name = $doctor['name'];
    //    }
    //}
}
?>

<div class="form_style">
    <h2><?= $header ?></h2><br/>
    <center><strong style="color:red;"><?php if ($error) {
    echo $error;
} ?></strong></center>
    <span class="err"><?php echo validation_errors(); ?></span>
    <div style="margin-left:15px; margin-top:10px;">
        <a href="#" class="show_hide button" style="mar">Add New Patient</a>
    </div>
    <div class="slidingDiv">

<?php echo form_open('patient/insert_new_patient' , "/" , $start_time , "/" , $appointment_date) ?>    
        <table>
            <tr>
                <td><label for="first_name">First Name</label></td>
                <td><label for="middle_name">Middle Name</label></td>
                <td><label for="last_name">Last Name</label></td>
                <td><label for="last_name">Reference By</label></td>
            </tr>
            <tr>
                <td><input type="text" name="first_name" value=""/></td>
                <td><input type="text" name="middle_name" value=""/></td>
                <td><input type="text" name="last_name" value=""/></td>
                <td><input type="text" name="reference_by" value="" /></td>

            </tr>
        </table>
        <div class="button_link" >
            <button class="button" type="submit" name="submit" />Add Patient</button>
        </div>
        </form>
    </div>
<!--    <span class="err"><?php echo validation_errors(); ?></span>-->

<?php echo form_open('appointment/edit') ?>
    <input type="hidden" name="id" value="<?= $id ?>"/><br/>
    <input type="hidden" name="patient_id" id="patient_id" value="<?= $patient_id; ?>"/><br/>
    <div style="padding-left: 10px;">
        <table>
            <tr>
                <td>Search Patient</td>
            </tr>                
            <tr>
                <td><label for="patient">Patient</label></td>
                <td><label for="display_name">Display Name</label></td>
                <td><label for="phone">Mobile</label></td>
            </tr>
            <tr>
                <td><input type="text" name="patient_name" id="patient_name" value="<?= $patient_name; ?>"/><br/></td>
                <td><input type="text" name="display_name" id="display_name" value="<?= $display_name; ?>"/><br/></td>
                <td><input type="text" name="phone_number" id="phone_number" value="<?= $phone_number; ?>"/><br/></td>
            </tr>
        </table>
    </div>   
    <input type="hidden" name="id" value="<?= $id ?>"/>
    <input type="hidden" name="doctor_id" id="doctor_id" value="<?= $doctor_id; ?>"/>
    <label for="doctor">Doctor Name</label>
    <input type="text" name="doctor" id="doctor" value="<?= $doctor_name ?>" readonly="readonly"/><br/>
    <label for="title">Title</label>
    <input type="text" name="title" value="<?= $title ?>"/><br/>
    <label for="start_time">Start Time</label>
    <input type="text" name="start_time" id="start_time" value="<?= $start_time; ?>"/><br/>
    <label for="end_time">End Time</label>
    <input type="text" name="end_time" id="end_time" value="<?= $end_time; ?>"/><br/>
    <label for="appointment_date">Date</label>
    <input name="appointment_date" id="appdate" class="date-pick dp-applied" value="<?= $appointment_date; ?>"/>
    <br/>
    <div class="button_link" >
        <button class="button" type="submit" name="submit" />Save</button>
<?php
if ($id != null) {
    ?>
            <a class="button" <?php if ($status == 'Cancel') {
            echo 'style= display:none;';
        } else {
            echo 'href = ' , base_url() , "index.php/appointment/change_status/" , $id , "/" , $appointment_date , "/" , $status , "/" , $start_time , "/Cancel";
        } ?>>Cancel Appointment</a>
            <a class="button" <?php if ($status == 'Waiting') {
            echo 'style= display:none;';
        } else {
            echo 'href = ' , base_url() , "index.php/appointment/change_status/" , $id , "/" , $appointment_date , "/" , $status , "/" , $start_time , "/Waiting";
        }; ?>>Waiting</a>
            <a class="button" <?php if ($status == 'Consultation') {
            echo 'style= display:none;';
        } else {
            echo 'href = ' , base_url() , "index.php/appointment/change_status/" , $id , "/" , $appointment_date , "/" , $status , "/" , $start_time , "/Consultation";
        }; ?>>Consultation</a>
<!--            <a class="button" <?php // if ($status == 'Waiting') {
           // echo 'href = ' . base_url() . "index.php/payment/index/" . $patient_id;
        //} else {
          //  echo 'style = display:none;';
        //} ?>>Advance Payment</a>-->
<?php }// else {  ?>
<!--            <a class="button" href="<?php // echo base_url() . "index.php/appointment//" . $id . "/" . $appointment_date;  ?>">Appointment</a>-->
<?php
//}
?>
    </div>
</form>
</div>