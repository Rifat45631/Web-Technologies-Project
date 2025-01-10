<?php
class customer
{
    private $connectionObject;

    public function __construct()
    {
        // Connect to the database
        $DBHostname = "localhost";
        $DBusername = "root";
        $DBPassword = "";
        $DBname = "customer_db";

        $this->connectionObject = new mysqli($DBHostname, $DBusername, $DBPassword, $DBname);

        if ($this->connectionObject->connect_error) {
            die("ERROR CONNECTING TO DB: " . $this->connectionObject->connect_error);
        }
    }

    public function insertData($table, $c_name, $c_mail, $c_pass, $c_c_pass, $c_ph_num, $c_contact_method, $c_gender, $c_date, $c_Delivery_address, $c_Parmanent_address)
    {
        // SQL query to insert data into the database
        $sql = "INSERT INTO $table (username, email, password, confirm_password, phone_number, contact_method, gender, dob, delivery_address, permanent_address) 
                VALUES ('$c_name', '$c_mail', '$c_pass', '$c_c_pass', '$c_ph_num', '$c_contact_method', '$c_gender', '$c_date', '$c_Delivery_address', '$c_Parmanent_address')";

        // Execute the query and handle success or error
        if ($this->connectionObject->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connectionObject->error;
        }
    }

    //for login

    public function login($username, $password)
    {
        $username = $this->connectionObject->real_escape_string($username);
        $password = $this->connectionObject->real_escape_string($password);

        // Query to check user credentials
        $sql = "SELECT * FROM customer_tb WHERE username='$username' AND password='$password'";
        $result = $this->connectionObject->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location:../welcome.html");
            exit();
        } else {
            echo "Invalid username or password!";
        }
    }
    

    // Close the connection when done
    public function __destruct()
    {
        $this->connectionObject->close();
    }
}
?>



