
<?php
require("../control/data/db.php");

if (isset($_POST['submit'])) {
    $username = $_POST['name'] ?? '';
    $password = $_POST['pass'] ?? '';

    if (!empty($username) && !empty($password)) {
        $auth = new customer();
        $auth->login($username, $password);
        header("../view/welcome.html"); 
            exit();
    } else {
        echo "Please fill in all fields.";
    }

    
}
?>
