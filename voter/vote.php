<?php
session_start();
include("../config/db.php");

$voterID = $_SESSION['voter'];

if(isset($_POST['submit_vote'])){

foreach($_POST['vote'] as $posID => $candID){

$conn->query("INSERT INTO votes (voterID,candID,posID)
VALUES ('$voterID','$candID','$posID')");

}

$conn->query("UPDATE voters SET voted=1 WHERE voterID='$voterID'");

echo "<script>alert('Vote Submitted Successfully'); window.location='../results/results.php';</script>";
}

$positions = $conn->query("SELECT * FROM positions WHERE posStat=1");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">

<form method="POST">

<?php
while($pos = $positions->fetch_assoc()){

$posID = $pos['posID'];

echo "<h4>".$pos['posName']."</h4>";

$candidates = $conn->query("SELECT * FROM candidates WHERE posID='$posID' AND candStat=1");

while($cand = $candidates->fetch_assoc()){

$fullName = $cand['candFName']." ".$cand['candMName']." ".$cand['candLName'];

?>

<div class="form-check">

<input class="form-check-input"
type="radio"
name="vote[<?php echo $posID ?>]"
value="<?php echo $cand['candID'] ?>">

<label class="form-check-label">
<?php echo $fullName ?>
</label>

</div>

<?php
}

echo "<hr>";
}
?>

<button class="btn btn-success mt-3" name="submit_vote">
Submit Vote
</button>

</form>

</div>