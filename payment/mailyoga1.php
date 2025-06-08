
<?php
if(isset($_POST['submit'])){
    // $to = "sarvadnyayoga@gmail.com, acharyapankaj567@gmail.com";
    $to = "rsontakke17@gmail.com, avinashpadmane@gmail.com";

    $name = $_POST['name'];
    $email= $_POST['email'];
    $phone= $_POST['phone'];
    $subject= $_POST['message'];
    $body= $_POST['body'];
    $headers = 'From: '.$email . "\r\n";


    $body = "Name : ".$name. "\r\n" .
        "Email : ".$email. "\r\n" .
        "Phone : ".$phone. "\r\n" .
        "Message : ".$subject. "". $body;
    if(mail($to, $subject, $body , $headers)){
        echo '<script>alert("Email sent successfully ! We will contact you soon.")</script>';
        echo '<script>window.location.href="contact-us.html"</script>';
    }else{
         echo '<script>alert("Failed to send Email !")</script>';
         echo '<script>window.location.href="contact-us.html"</script>';
    }
}

?>