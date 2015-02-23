<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mifos | Login</title>
        
        <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/custom.css">
        
        
    </head>
    <body>
        <div class="container center-block focus" style="width: 300px;margin-top: 200px; border-style: groove; border-radius: 20px">
        <?php 
        if(!$_POST) {
            echo
        "<div class=\"container-fluid\">
        <form action=\"schedule.php\" method=\"post\">
            <div class=\"form-group\">
                <legend>Enter Mifos Login and Loan ID</legend>
                <div class=\"input-group\">
                    <label for=\"username\" class=\"control-label\">Username</label><input name=\"username\" class=\"form-control\" required><br>
                </div>
                <div class=\"input-group\">
                    <label for=\"password\" class=\"control-label\">Password</label><input name=\"password\" class=\"form-control password\" required><br>
                </div>
                <div class=\"input-group\">
                    <label for=\"loan_id\" class=\"control-label\">Loan ID</label><input name=\"loan_id\" class=\"form-control\" required><br>
                </div>
                <br>
                <input type=\"submit\" value=\"Submit\" class=\"btn btn-default\"><br>
            </div>
        </form>
        </div>"; 
            
        } 
        ?>
        </div>
        <script>
                    
        </script>
    </body>
</html>
