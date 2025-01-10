<?php
require("../control/data/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = [];

    $username = isset($_POST['c_name']) ? $_POST['c_name'] : '';
    $email = isset($_POST['c_mail']) ? $_POST['c_mail'] : '';
    $password = isset($_POST['c_pass']) ? $_POST['c_pass'] : '';
    $confirm_password = isset($_POST['c_c_pass']) ? $_POST['c_c_pass'] : '';
    $phone_number = isset($_POST['c_ph_num']) ? $_POST['c_ph_num'] : '';
    $contact_method = isset($_POST['c_contact_method']) ? $_POST['c_contact_method'] : '';
    $gender = isset($_POST['c_gender']) ? $_POST['c_gender'] : '';
    $dob = isset($_POST['c_date']) ? $_POST['c_date'] : '';
    $delivery_address = isset($_POST['c_Delivery_address']) ? $_POST['c_Delivery_address'] : '';
    $permanent_address = isset($_POST['c_Parmanent_address']) ? $_POST['c_Parmanent_address'] : '';

    if (empty($username)) {
        $errors[] = "Username is required.";
    } else {
        $has_uppercase = false;
        for ($i = 0; $i < strlen($username); $i++) {
            if (ctype_upper($username[$i])) {
                $has_uppercase = true;
                break;
            }
        }
        if (!$has_uppercase) {
            $errors[] = "Username must contain at least one uppercase letter.";
        }

        if (!ctype_alpha($username)) {
            $errors[] = "Username must contain only alphabets.";
        }
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } else {
        $has_digit = false;
        for ($i = 0; $i < strlen($password); $i++) {
            if (is_numeric($password[$i])) {
                $has_digit = true;
                break;
            }
        }
        if (!$has_digit) {
            $errors[] = "Password must contain at least one numeric character.";
        }
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } else {
        if (strpos($email, '@') === false ) {
            $errors[] = "Email must have '@' .";
        }
        
        if (substr($email, -4) !== '.com') {
            $errors[] = "Email must end with .com domain.";
        }
    }

    if (empty($phone_number)) {
        $errors[] = "Phone number is required.";
    } else {
        if (strlen($phone_number) !== 11) {
            $errors[] = "Phone number must be exactly 11 digits.";
        }
        
        for ($i = 0; $i < strlen($phone_number); $i++) {
            if (!is_numeric($phone_number[$i])) {
                $errors[] = "Phone number must contain only numbers.";
                break;
            }
        }
    }

    if (empty($contact_method) || $contact_method === 'none') {
        $errors[] = "Please select a preferred contact method.";
    }

    if (empty($gender) || $gender === 'none') {
        $errors[] = "Please select your gender.";
    }

    if (empty($dob)) {
        $errors[] = "Date of birth is required.";
    }

    if (empty($delivery_address)) {
        $errors[] = "Delivery address is required.";
    }

    if (empty($permanent_address)) {
        $errors[] = "Permanent address is required.";
    }


        if (empty($errors)) {
            $customer = new customer(); 
            $customer->insertData("customer_tb",$username, $email, $password, $confirm_password, $phone_number, $contact_method, $gender, $dob, $delivery_address, $permanent_address);
            $success = "Registration successful!";
        }
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
    } else {
        echo "Form successfully validated!<br>";
       
            
        $data=
        [

"Username" => $_POST['c_name'],
"E-mail" => $_POST['c_mail'],
"Password" => $_POST['c_pass'],
"Confirm Password" => $_POST['c_c_pass'],
"Phone Number" => $_POST['c_ph_num'],
"Contact Method" => $_POST['c_contact_method'],
"Gender" => $_POST['c_gender'],
"Date of Birth" => $_POST['c_date'],
"Delivery Address" => $_POST['c_Delivery_address'],
"Permanent Address" => $_POST['c_Parmanent_address'],

        ];

$json = json_encode( $data,JSON_PRETTY_PRINT);

file_put_contents("../control/data/userdata.json", $json);
 
    }
}
?>
