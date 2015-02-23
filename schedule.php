<?php
    error_reporting(-1);
    include 'jq.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<html>
    <head>
        <meta charset="UTF-8">
        <title>Mifos | Loan Schedule</title>
        
        <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        
    </head>
    <body>
        <?php 
        $schedule = jq::createSchedule();
        $details = jq::getDetails();
        
        if (!$schedule || !$details) { ?>
        
        <h1>Something Failed... <a href="index.php" class="btn btn-danger">try again</a>?</h1> 
        
        <?php }        ?>
        <div class="container-fluid" style="width: 900px;">
            <div class="panel">
                <div class="img-responsive">
                    <img src="logo.png">
                </div>
                <div class="panel-heading">
                    <h3 class="text-center panel-heading">Loan Schedule for <?php echo $details['clientName']; ?></h3>
                    <br>
                    <div class="text-info">
                        <p>Client ID: <?php echo $details['clientId']; ?></p>
                        <p>Loan ID: <?php echo $_POST['loan_id']; ?></p>
                        <p>Interest Rate: <?php echo $details['interestRate']; ?>&#37 per Pay Cycle</p>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Payment Cycle</th>
                                <th>Date</th>
                                <th>Installment</th>
                                <th>Interest</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($schedule as $record) { ?>
                            <tr>
                                <td><?php echo $record['cycle']; ?></td>
                                <td><?php echo $record['date']; ?></td>
                                <td><?php echo '$ '.round($record['installment'], 2); ?></td>
                                <td><?php echo '$ '.round($record['interest'], 2); ?></td>
                                <td><?php echo '$ '.round($record['total'], 2); ?></td>
                            </tr>


                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <a class="btn btn-primary pull-right hidden-print" href="index.php">Back</a> 
        </div>
    </body>
</html>