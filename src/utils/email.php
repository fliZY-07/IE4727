<?php
function sendMail($to='f32ee@localhost', $orderId) {
    $subject = 'Order Confirmation';
    $message = "Please confirm your order in http://localhost:8000/IE4727/myStyleLoft/src/editOrder.php?orderId=" . $orderId;
    $headers = 'From: f32ee@localhost'."\r\n".'Reply-To: f32ee@localhost'."\r\n".'X-Mailer: PHP/'.phpversion();

    mail($to, $subject, $message, $headers, '-ff32ee@localhost');
            
    echo ("mail sent to :".$to);
}