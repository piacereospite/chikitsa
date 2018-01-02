<html>
    <head>
        <title>Patient Report</title>
        <link rel="stylesheet" href='<?= base_url() ?>css/style.css' type="text/css"/>
    </head>
    <body>
        <div class="receipt">

            <h3>Patient Report</h3>            
            <hr/>

            <table>                
                    <tr><th>Patient Name</th><th>Phone Nnmber</th><th>Visit</th></tr>
                    
            
                    <?php foreach ($patients_detail as $patient_detail) { ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $patient_detail['patient_name']; ?></td>
                            <td style="text-align: center;"><?php echo $patient_detail['phone_number']; ?></td>
                            <td style="text-align: center;"><?php if(isset($patient_detail['idcount'])) { echo $patient_detail['idcount']; } else { echo '0';} ?></td>
                        </tr>                    
                    <?php
                    }
                    ?>            
            </table>
        </div>
    </body>
</html>