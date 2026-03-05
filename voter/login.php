<?php
session_start();
include("../config/db.php");

if(isset($_POST['login'])){

$email=$_POST['email'];
$pass=$_POST['pass'];

$sql="SELECT * FROM voters WHERE email='$email' AND voterPass='$pass'";
$res=$conn->query($sql);

if($res->num_rows>0){

$row=$res->fetch_assoc();

if($row['voted']==1){

echo "<script>alert('You already voted');</script>";

}else{

$_SESSION['voter']=$row['voterID'];

header("Location: vote.php");

}

}else{

echo "<script>alert('Invalid login');</script>";

}

}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
<div class="card p-4">

<h3>Login</h3>

<form method="POST">

<input class="form-control mb-3" name="email" placeholder="Email" required>

<input class="form-control mb-3" type="password" name="pass" placeholder="Password" required>

<button class="btn btn-primary" name="login">Login</button>

</form>

</div>
</div>