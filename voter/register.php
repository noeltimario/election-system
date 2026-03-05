<?php
include("../config/db.php");

if(isset($_POST['register'])){

$fname=$_POST['fname'];
$lname=$_POST['lname'];
$email=$_POST['email'];
$pass=$_POST['pass'];

$conn->query("INSERT INTO voters(voterFName,voterLName,email,voterPass)
VALUES('$fname','$lname','$email','$pass')");

echo "<script>alert('Registered Successfully');</script>";
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
<div class="card p-4">

<h3>Register</h3>

<form method="POST">

<input class="form-control mb-3" name="fname" placeholder="First Name" required>

<input class="form-control mb-3" name="lname" placeholder="Last Name" required>

<input class="form-control mb-3" name="email" placeholder="Email" required>

<input class="form-control mb-3" type="password" name="pass" placeholder="Password" required>

<button class="btn btn-primary" name="register">Register</button>

</form>

<a href="login.php">Already have account? Login</a>

</div>
</div>