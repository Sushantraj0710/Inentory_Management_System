<?php
    session_start();
    $DATABASE_HOST ='localhost';
    $DATABASE_USER ='root';
    $DATABASE_PASS ='';
    $DATABASE_NAME ='new_inventory';
    $connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if(mysqli_connect_error()){
        exit('Failed to connect to MySQL:' .mysqli_connect_error());
    }

    if(!isset($_POST['username'], $_POST['password'])){
        exit('Please fill the username and password fiels!');
       
    }
    
    // prepare your SQL, preaparing the SQL statement will prevent sql injection
    if($stmt = $connection->prepare('SELECT id, password FROM login_mstr where username = ?')){
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s',$_POST['username']);
    $stmt->execute();
    // store the result so we can check if the account exits in the database.
    $stmt->store_result();
    // $stmt->close();
    }
    // else{
    //     $stmt->close();
    // }

    if($stmt->num_rows>0){
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed password
        // if(password_verify($_POST['password'],$password)){ ---> this is used when we use password_hash
            
        //if ($_POST['password'] === $password) { ---> this is used if we dont use the password_hash. It simply match the password from user input and form the database
        
        // if(password_verify($_POST['password'],$password)){
        if ($_POST['password'] === $password) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            // echo 'Welcome ' .$_SESSION['name'].'!';
            header('Location: customer_display.php');
        }
        else{
            // Incorrect Password
            echo 'Incorrect username / Password !';
        }
    }
    else{
        // incorrect username
        echo 'Incorrect username and/or password !';
    }

?>