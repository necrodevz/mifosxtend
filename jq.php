<?php


class jq {
    
    private static $username;
    private static $password;
    private static $loan_id;
    private static $tenant = "default";
   
    private function __construct() {
        ;
    }
 
    private function getLoan() {

        $data_string = '
            {
            }
            ';
        $endpoint = "https://54.148.62.225:8443/mifosng-provider/api/v1/";
        self::$username= $_POST['username'];
        self::$password= $_POST['password'];
        self::$loan_id = $_POST['loan_id'];
        
        $username = self::$username;
        $password = self::$password;

        $method = "GET";
        $api_target = "loans/".self::$loan_id;
        $URL= $endpoint.$api_target."?tenantIdentifier=".self::$tenant;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        $result = curl_exec ($ch);
        curl_close ($ch);

        $result = json_decode(json_encode(json_decode($result,true)), true);
        //echo "<pre>".print_r($result2,true)."</pre>";
        return $result;
        
    }

    private function calculateLoanSchedule($principal, $interestRatePerPeriod, $termFrequency, $repaymentEvery, $numberOfRepayments, $expectedFirstRepaymentOnDate) {
        $rate = ($interestRatePerPeriod/52) * $repaymentEvery;
        $output = array();
        $installment = $principal/$numberOfRepayments;
        $interest = $principal * ($rate/100);
        $total = $installment + $interest;
        $int = ((4 / $repaymentEvery) * 7);
        if($repaymentEvery===2){
            $date = date("y-m-d", strtotime("{$expectedFirstRepaymentOnDate} - 14 days"));
        } else {
            $date = date("y-m-d", strtotime("{$expectedFirstRepaymentOnDate} - 30 days"));
        }
        
        for ($i= 0; $i < $numberOfRepayments; $i++) {
            /*if($repaymentEvery===2){
                $date = date("y-m-d", strtotime("{$date} + 14 days"));
            } else {
                $date = date("y-m-d", strtotime("{$date} + 30 days"));
            }*/
            //$fdate = new DateTime($date);
            array_push($output, array(
                'cycle' => $i + 1,
                'date' => $date,
                'installment' => $installment,
                'interest' => $interest,
                'total' => $total
            ));
            
        } 
        
        return $output;
    }
  
    public static function createSchedule() {
        $json = self::getLoan();
        $try = self::calculateLoanSchedule($json['principal'], $json['interestRatePerPeriod'], $json['termFrequency'], $json['repaymentEvery'], $json['numberOfRepayments'], implode("-", $json['expectedFirstRepaymentOnDate']));
    
        return $try;
    }
    
    public static function getDetails() {
        $json = self::getLoan();
        
        $rate = ($json['interestRatePerPeriod']/52) * $json['repaymentEvery'];
        
        $output = array(
            'clientId' => $json['clientId'],
            'clientName' => $json['clientName'],
            'loanId' => $json['loanId'], 
            'interestRate' => $rate
        );
        return $output;
    }

}