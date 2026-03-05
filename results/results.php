<?php
include("../config/db.php");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">

<h2 class="mb-4">Election Results</h2>

<?php

$positions = $conn->query("SELECT * FROM positions");

while($pos = $positions->fetch_assoc()){

$posID = $pos['posID'];

echo "<h4>".$pos['posName']."</h4>";

echo "<table class='table table-bordered'>
<tr>
<th>Candidate</th>
<th>Total Votes</th>
<th>Voting %</th>
</tr>";

$candidates = $conn->query("
SELECT 
c.candID,
c.candFName,
c.candMName,
c.candLName,
COUNT(v.voteID) as totalVotes
FROM candidates c
LEFT JOIN votes v ON c.candID = v.candID
WHERE c.posID='$posID'
GROUP BY c.candID
");

$totalVotes = 0;

while($row = $candidates->fetch_assoc()){
$totalVotes += $row['totalVotes'];
}

$candidates = $conn->query("
SELECT 
c.candID,
c.candFName,
c.candMName,
c.candLName,
COUNT(v.voteID) as totalVotes
FROM candidates c
LEFT JOIN votes v ON c.candID = v.candID
WHERE c.posID='$posID'
GROUP BY c.candID
");

while($cand = $candidates->fetch_assoc()){

$votes = $cand['totalVotes'];

$percent = $totalVotes > 0 ? ($votes/$totalVotes)*100 : 0;

$fullname = $cand['candFName']." ".$cand['candMName']." ".$cand['candLName'];

echo "<tr>
<td>$fullname</td>
<td>$votes</td>
<td>".number_format($percent,2)."%</td>
</tr>";

}

echo "</table>";

}

?>

<a href="winners.php" class="btn btn-primary mt-3">View Winners</a>

</div>