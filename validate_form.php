<?php

//Collect form inputs

$userName = $_POST['username'];

$firstName = $_POST['firstname'];

$lastName = $_POST['lastname'];

$password = $_POST['password'];

$confirmPassword = $_POST['confirmPassword'];

$email = $_POST['email'];

$gender = $_POST['gender'];

$errors = [];


//VALIDATE FORM INPUTS

//validate username

if(empty($userName))
{
    $errors[] = "Username is Required";

}

elseif(!preg_match("/^[a-zA-Z]+[a-zA-Z0-9]*$/", $userName)){
    $errors[] = "Invalid Username";
}


//validate firstname

if(empty($firstName)){
    $errors[] = "First Name is Required";
}
elseif(!preg_match("/^[a-zA-Z]+$/", $firstName)){
    $errors[] = "Only Letters are allowed for first name";
}


//validate lastname

if(empty($lastName)){
    $errors[] = "Last Name is Required";
}
elseif(!preg_match("/^[a-zA-Z]+$/", $lastName)){
    $errors[] = "Only Letters are allowed for last name";
}


//validate password

if(empty($password)){
    $errors[] = "Please input a password";
}
elseif(strlen($password) < 6){
    $errors[] = "Password is too short";
}
elseif(empty($confirmPassword)){
    $errors[] = "Please input a confirmation password";
}
elseif($password !== $confirmPassword){
    $errors[] = "Passwords do not match";
}


//validate email

if(empty($email)){
    $errors[] = "Please enter an email address";
}
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors[] = "Invalid Email Address";
}


//validate gender

if(!isset($gender)){
    $errors[] = "Please select a gender";
}


//check for errors and echo, otherwise, redirect to a given page

if(!$errors){

    $servername = "localhost";
    $username = "username";
    $password = "root";
    $dbname = "root";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // set the PDO error mode to exception

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO myDatabase (username, firstname, lastname, password1, password2, email, gender)

        VALUES ($userName, $firstName, $lastName, $password, $confirmPassword, $email, $gender)";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "New record created successfully";
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;
}else{
    foreach($errors as $error){
        echo $error . '<br>';
    }
}
