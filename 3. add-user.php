<?php
$database = new mysqli('localhost', 'root', '', 'lab2');

$firstName =  $_POST['FirstName'];
$lastName = $_POST['LastName'];
$personalNumber = $_POST['PersonalNumber'];
$email = $_POST['Email'];
$password = $_POST['Password'];


$field_empty = 0;
if (empty($firstName)) {
  $firstName_error = "Enter your first name";
  $field_empty = 1;
}
if (empty($lastName)) {
  $lastName_error = "Enter your last name";
  $field_empty = 1;
}
if (empty($personalNumber)) {
  $personalNumber_error = "Enter your perosnal number";
  $field_empty = 1;
}
if (empty($email)) {
  $email_error = "Enter your email";
  $field_empty = 1;
}
if (empty($password)) {
  $password_error = "Enter a password";
  $field_empty = 1;
}


if (!($field_empty)) {
  $existing_emails = mysqli_query($database, "SELECT * FROM users WHERE Email='$email'");
  $existing_perosnalNumbers = mysqli_query($database, "SELECT * FROM users WHERE PersonalNumber=$personalNumber");
  $email_taken = 0;
  $personalNumber_taken = 0;

  if (mysqli_num_rows($existing_emails) > 0) {
    $existing_emails_error = "Email already in use";
    $email_taken = 1;
  }
  if (mysqli_num_rows($existing_perosnalNumbers) > 0) {
    $existing_personalNumbers_error = "Personal number already registered";
    $personalNumber_taken = 1;
  }
}


if (!($field_empty) && !($personalNumber_taken) && !($email_taken)) {
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO users (FirstName, LastName, PersonalNumber, Email, Password) VALUES ('$firstName', '$lastName', '$personalNumber', '$email', '$hashed_password');";
  mysqli_query($database, $query);
  $success = 1;
  include('2. registration.php');
} else {
  include('2. registration.php');
}