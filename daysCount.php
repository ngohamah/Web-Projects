<!-- function to compute number of days remaining or exceeded. -->
<?php 
    function daysCount(string $paymentdate){   
            
        $paymentdate = date_create(str_replace('/', '-', $paymentdate));  

        $expirydate = date_add($paymentdate,date_interval_create_from_date_string("32 days")); //using 32days to denote one month of signal payment
        
        // 1 day additional for including last day in payment.

        $today = getdate();
        $day = $today['mday'];
        $month = $today['mon'];
        $year = $today['year'];

        $currentdate = date_create_from_format('Y-m-d',$year."-".$month."-".$day);
    
        
        $diff =date_diff($currentdate,$expirydate)->format('%R%a');

        return $diff;
    }
?>