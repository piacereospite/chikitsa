<style type="text/css">
    li.add {margin: 0 0 10 5;}
    ul li {list-style-type: none;}    
    :checked + span { color: #999; }
</style>
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
</script>
<?php

define('VAR1',  13); // avoid literals in methods calls
define('VAR2',  12); // avoid literals in methods calls
define('VAR3',  60); // avoid literals in methods calls
define('VAR4',  31); // avoid literals in methods calls

function inttotime($tm) {
    if ($tm >= VAR1) {
        $tm = $tm - VAR2;
    }
    $hr = intval($tm);
    $min = (($tm - intval($tm)) * VAR3);
    $format = '%02d:%02d';
    return sprintf($format, $hr, $min);
}

function timetoint($time) {
    $hrcorrection = 0;
    if (strpos($time, 'p') > 0)
        $hrcorrection = VAR2;
    list($hours, $mins) = explode(':', $time);
    $mins = str_replace('a', '', $mins);
    $mins = str_replace('p', '', $mins);

    return $hours + $hrcorrection + ($mins / VAR3);
}
?>
<div class="app_sidebar">
    <div class="calendar">                                                            <!--  Display Calendar -->
        <?php
        for ($i = 1; $i <= VAR4; $i++) {
            $data[$i] = base_url() . 'index.php/appointment/index/' . $year . '/' . $month . '/' . $i;
        }
        echo $this->calendar->generate($year, $month, $data);
        ?>
    </div>                                                                            <!-- Div end of Calender -->

    <?php if ($followups) { ?>
        <div class="followup">                                                            <!-- Div start Display Follow-Up Date and Patient -->
            <table style="border:1px solid #98bf21;">
                <thead>
                <th>Follow-Up Date</th>
                <th>Patient</th>
                </thead>
                <?php
                $i = 0;
                foreach ($followups as $followup) {
                    foreach ($patients as $patient) {
                        if ($followup['patient_id'] == $patient['patient_id']) {
                            ?> <tr> <?php
                            $followup_data['followup_date'] = $followup['followup_date'];
                            $followup_data['patient_name'] = $patient['first_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['last_name'];
                            ?> <td class='follow-date'> <?php echo date('d-m-Y', strtotime($followup_data['followup_date']));?> </td>
                               <td class='follow-name'><a href = ' <?php echo base_url();?> index.php/patient/followup/ <?php echo $patient['patient_id'];?> '> <?php echo $followup_data['patient_name'];?> </td>
                               </tr> <?php
                            break;
                        }
                    }
                }
                ?>
            </table>
        </div>
        <!-- Div end of Follow-Up Date and Patient -->
    <?php } ?>
    <div class="todo">
        <h2>Tasks</h2><br />
        <form id="task" method="post" action="<?php echo base_url();?>index.php/appointment/todos">
            <label>Task: </label><input type="text" name="task" />
            <label>&nbsp;</label><input type="submit" value="Submit" />
        </form> 
        <!-- here is the script that will do the ajax. It is triggered when the form is submitted -->
        <script>
//            $(function(){
//                $("#task").submit(function(){
//                    dataString = $("#task").serialize();
//
//                    $.ajax({
//                        type: "POST",
//                        url: "<?php// echo base_url(); ?>index.php/appointment/todos",
//                        data: dataString,
//
//                        success: function(){
//                            //Do Nothing
//                        }
//
//                    });
//                });
//            });            
        </script>        
        <div class="todo_list">
            <?php
            foreach ($todos as $todo) {
//                echo "<li";
//                if ($todo['done'] == 1) {
//                    echo " class='done'";
//                } 
//                echo ">";
                echo "<input type='checkbox' id='todo' name='todo' value='" , $todo['id_num'] , "'";
                if ($todo['done'] == 1) {
                    echo ' checked';
                }
                echo '/>';
                ?> <span> <?php echo $todo['todo']; ?> </span><a class='todo_img' href=' <?php echo base_url(); ?> index.php/appointment/delete_todo/ <?php echo $todo['id_num']; ?> '><img src=' <?php echo base_url(); ?> images/wrong.png' width='15' height='15'/><a/><br/> <?php
//                echo "</li>";
            }
            ?>
        </div>

        <script>
            $("input[name='todo']:checkbox").change(function() {
                if($(this).is(':checked')){
                    var id = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/appointment/todos_done/1/" + id,
                        success: function(){
                            //Do Nothing
                        }

                    });
                }               
            });
            $("input[name='todo']:checkbox").change(function() {
                if(!$(this).is(':checked')){
                    var id = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/appointment/todos_done/0/" + id,
                        success: function(){
                            //Do Nothing
                        }

                    });
                }               
            });
            
        </script>        
    </div>
</div>

<div class="day_appointment">
    <span class="current_date"><?php echo $day , '/' , $month , '/' , $year; ?></span>
    <?php
    $level = $this->session->userdata('category');
    if ($level == 'Doctor') {
        ?>
    <!--        <table>
        <?php
//            $start_time = timetoint($start_time);
//            $end_time = timetoint($end_time);
//            for ($i = $start_time; $i < $end_time; $i = $i + $time_interval) {
//                $title = "";
//                $id = 0;
//                echo "<tr>";
//                echo "<td class='appointment_time'><a href='" . base_url() . "index.php/appointment/edit/" . $year . "/" . $month . "/" . $day . "/" . inttotime($i) . "'>" . inttotime($i) . "</a></td>";
//                $found = FALSE;
//                foreach ($appointments as $appointment) {
//                    if (strtotime(inttotime($i)) == strtotime($appointment['start_time'])) {
//                        $title = $appointment['title'];
//                        $id = $appointment['appointment_id'];
//                        $p_id = $appointment['patient_id'];
//                        $status = $appointment['status'];
//                        $date = $appointment['appointment_date'];
//                       $time = $appointment['start_time'];
//                        $found = TRUE;
//                   }
//
//                    if ($found) {
//                        //Edit Current Appointment
//                        //echo "<td id='" . $status . "'><a href='" . base_url() . "index.php/appointment/edit/" . $year . "/" . $month . "/" . $day . "/" . inttotime($i) . "/" . $id . "/" . $status . "/" . $appointment['userid'] . "'>" . $title . "</a></td>";
//                        if ($status == 'Consultation') {
//                            //echo "if Status";
//                            echo "<td id='" . $status . "'><a href='" . base_url() . "index.php/patient/visit/" . $p_id . "/" . $id . "/" . $date . "/" . inttotime($i) . "'>" . $title . "</a></td>";
//                       } else {
//                            //echo "else Status";
//                            echo "<td id='" . $status . "'><a href='" . base_url() . "index.php/appointment/edit/" . $year . "/" . $month . "/" . $day . "/" . inttotime($i) . "/" . $id . "/" . $status . "/" . $appointment['userid'] . "'>" . $title . "</a></td>";
//                        }
//                    } else {
//                        //Add New Appointment
//                        echo "<td id='blank'><a href='" . base_url() . "index.php/appointment/edit/" . $year . "/" . $month . "/" . $day . "/" . inttotime($i) . "/0/0/" . $appointment['userid'] . "'>" . ' ' . "</a></td>";
//                    }
//                }
//                echo "</tr>";
//            }
        ?>

            </table>-->
        <table border="1">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Appointments</th>
                    <th>Waiting</th>
                    <th>Consultation</th>
                    <th>Complete/Cancel</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $userid = $this->session->userdata('id');
                $start_time = timetoint($start_time);
                $end_time = timetoint($end_time);
                for ($i = $start_time; $i < $end_time; $i = $i + $time_interval) {
                    $title = '';
                    $id = 0; 
                    ?> <tr>
                       <td class='appointment_time'> <?php echo inttotime($i); ?> </td> <?php
                    $found = false;
                    foreach ($appointments as $appointment) {
                        if (strtotime(inttotime($i)) == strtotime($appointment['start_time'])) {
                            $title = $appointment['title'];
                            $id = $appointment['appointment_id'];
                            $p_id = $appointment['patient_id'];
                            $status = $appointment['status'];
                            $date = $appointment['appointment_date'];
                            $time = $appointment['start_time'];                                                        
                            $found = true;
                        }
                    }
                    if ($found) {
                        if ($status == 'Appointments') { ?>
                            <td id=' <?php echo $status; ?> '> <?php echo $title; ?> <a title = 'Waiting' href=' <?php echo base_url(); ?> index.php/appointment/change_status/ <?php echo $id; ?> / <?php echo $date; ?> / <?php echo $status; ?> / <?php echo $time; ?> /Waiting'><img src=' <?php echo base_url(); ?> images/status.png' width='20' height='20' /></a><a class='confirmClick' title='Cancel Appointment of : <?php echo $title; ?> ' href=' <?php echo base_url(); ?> index.php/appointment/change_status/ <?php echo $id; ?> / <?php echo $date; ?> / <?php echo $status; ?> / <?php echo $time; ?> /Cancel'><img src='<?php echo base_url(); ?> images/wrong.png' width='20' height='20' /></a></td>
                            <td id='blank'><a href='<?php echo base_url(); ?> index.php/appointment/edit/ <?php echo $year; ?> / <?php echo $month; ?> / <?php echo $day; ?> / <?php echo inttotime($i); ?> /0/0/ <?php echo $userid; ?> '> </a></td>
                            <td id='blank'><a href='<?php echo base_url(); ?> index.php/appointment/edit/ <?php echo $year; ?> / <?php echo $month; ?> / <?php echo $day; ?> / <?php echo inttotime($i); ?> /0/0/ <?php echo $userid; ?> '> </a></td>
                            <td id='blank'><a href='<?php echo base_url(); ?> index.php/appointment/edit/ <?php echo $year; ?> / <?php echo $month; ?> / <?php echo $day; ?> / <?php echo inttotime($i); ?> /0/0/ <?php echo $userid; ?> '> </a></td> <?php
                        }
                        if ($status == 'Waiting') { ?>
                            <td id='blank'><a href='<?php echo base_url(); ?> index.php/appointment/edit/<?php echo $year; ?> /<?php echo $month; ?> / <?php echo $day; ?>  / <?php echo inttotime($i); ?> /0/0/ <?php echo $userid; ?> '> </a></td>
                            <td id='<?php echo $status; ?> '> <?php echo $title; ?> <a title = 'Consultation' href=' <?php echo base_url(); ?>index.php/appointment/change_status/ <?php echo $id; ?>  / <?php echo $date; ?> / <?php echo $status; ?> / <?php echo $time; ?>/Consultation'><img src='<?php echo base_url(); ?>"images/status.png' width='20' height='20' /></a><a class='confirmClick' title='Cancel Appointment of :<?php echo $title; ?>' href='<?php echo base_url(); ?>index.php/appointment/change_status/<?php echo $id; ?>/<?php echo $date; ?>/<?php echo $status; ?>/<?php echo $time; ?>/Cancel'><img src='<?php echo base_url(); ?>images/wrong.png' width='20' height='20' /></a></td>
                            <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td>
                            <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td> <?php
                        }
                        if ($status == 'Consultation') { ?>
                            <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td>
                            <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td>
                            <td id='<?php echo $status; ?>'><a href='<?php echo base_url(); ?>index.php/patient/visit/<?php echo $p_id; ?>/<?php echo $id; ?>/<?php echo $date; ?>/<?php echo inttotime($i); ?>'><?php echo $title; ?></a></td>                                                          
                            <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td> <?php
                        }
                        if ($status == 'Cancel' || $status == 'Complete') { ?>
                            <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td>
                            <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td>
                            <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td>
                            <td id='<?php echo $status; ?>'><?php echo $title; ?></td> <?php
                        }
                    } else { ?>
                        <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td>
                        <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td>
                        <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td>
                        <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $userid; ?>'> </a></td> <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
    } else {
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Time</th>
                    <?php
                    foreach ($doctors as $doctor) { ?>
                        <th><?php echo $doctor['name']; ?></th> <?php
                    }
                    ?>          
                </tr>
            </thead>
            <tbody>
                <?php
                $start_time = timetoint($start_time);
                $end_time = timetoint($end_time);
                // Loop through Start time and End Time
                for ($i = $start_time; $i < $end_time; $i = $i + $time_interval) {


                    ?> <tr> <?php
                    //display time
                    ?> <td class='appointment_time'><?php echo inttotime($i); ?></td> <?php
                    foreach ($doctors as $doctor) {
                        $found = false;
                        foreach ($appointments as $appointment) {
                            if (strtotime(inttotime($i)) == strtotime($appointment['start_time'])
                                    && $doctor['userid'] == $appointment['userid']
                                    && $appointment['status'] != 'Cancel') {
                                $title = $appointment['title'];
                                $id = $appointment['appointment_id'];
                                $p_id = $appointment['patient_id'];
                                $status = $appointment['status'];
                                $doc_id = $appointment['userid'];
                                $date = $appointment['appointment_date'];
                                $found = true;
                            }
                        }
                        if ($found) {
                            if ($status == 'Consultation') {
                                //echo "if Status";
                                ?> <td id='<?php echo $status; ?>'><a href='<?php echo base_url(); ?>index.php/patient/visit/<?php echo $p_id; ?>/<?php echo $id; ?>/<?php echo $date; ?>/<?php echo inttotime($i); ?>'><?php echo $title; ?></a></td> <?php
                            } else {
                                //echo "else Status";
                                ?> <td id='<?php echo $status; ?>'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/<?php echo $id; ?>/<?php echo $status; ?>/<?php echo $doc_id; ?>'><?php echo $title; ?></a></td> <?php
                            }
                            //Edit Current Appointment
                            //echo "<td id='" . $status . "'><a href='" . base_url() . "index.php/appointment/edit/" . $year . "/" . $month . "/" . $day . "/" . inttotime($i) . "/" . $id . "/" . $status . "/" . $doctor['userid'] . "'>" . $title . "</a></td>";
                        } else {
                            //Add New Appointment
                            ?> <td id='blank'><a href='<?php echo base_url(); ?>index.php/appointment/edit/<?php echo $year; ?>/<?php echo $month; ?>/<?php echo $day; ?>/<?php echo inttotime($i); ?>/0/0/<?php echo $doctor['userid']; ?>'> </a></td> <?php
                        }
                    }
                    ?> </tr> <?php
                }
            }
            ?>  
        </tbody>
    </table>
    <br /><br /><br />
    <table style="width: 300px;">
        <tr>
            <td id = "Appointments" style="height: 30px;width: 18%;"></td>
            <td id = "action">Appointment</td>
        </tr>
        <tr>
            <td id ="Complete" style="height: 30px;"></td>
            <td id = "action">Complete Appointment</td>
        </tr>
        <tr>
            <td id = "Waiting" style="height: 30px;"></td>
            <td id = "action">Patient in Waiting</td>
        </tr>
        <tr>
            <td id = "Consultation" style="height: 30px;"></td>
            <td id = "action">Consultation</td>
        </tr>
        <tr>
            <td id = "Cancel" style="height: 30px;"></td>
            <td>Cancelled Appointment</td>
        </tr>
    </table>   
</div>
