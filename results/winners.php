<?php
include("../config/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Winners</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .winner-card { border-left: 5px solid #ffc107; transition: 0.3s; }
        .winner-card:hover { transform: scale(1.02); }
        .rank-badge { width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; background: #007bff; color: white; font-weight: bold; margin-right: 10px; }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-dark">🏆 Official Proclaimed Winners</h1>
        <p class="lead">Final counting based on total validated votes</p>
    </div>

    <div class="row">
    <?php
    // 1. Get all positions
    $positions = $conn->query("SELECT * FROM positions ORDER BY posID ASC");

    while($pos = $positions->fetch_assoc()){
        $posID = $pos['posID'];
        $limit = $pos['numOfPositions']; // Dynamically sets how many can win

        echo "<div class='col-md-6 mb-4'>
                <div class='card shadow-sm winner-card'>
                    <div class='card-header bg-white py-3'>
                        <h4 class='mb-0 text-primary fw-bold'>".$pos['posName']." <small class='text-muted'>(Top $limit)</small></h4>
                    </div>
                    <div class='card-body p-0'>
                        <ul class='list-group list-group-flush'>";

        // 2. Fetch winners using the correct Name columns and JOIN with Votes
        $winnerQuery = "SELECT 
                            c.candFName, 
                            c.candMName, 
                            c.candLName, 
                            COUNT(v.voteID) as totalVotes 
                        FROM candidates c 
                        LEFT JOIN votes v ON c.candID = v.candID 
                        WHERE c.posID = '$posID' 
                        GROUP BY c.candID 
                        ORDER BY totalVotes DESC 
                        LIMIT $limit";

        $winners = $conn->query($winnerQuery);

        if($winners->num_rows > 0){
            $rank = 1;
            while($w = $winners->fetch_assoc()){
                // Combine the names correctly to avoid the "Unknown column" error
                $fullName = $w['candFName'] . " " . (!empty($w['candMName']) ? $w['candMName'] . " " : "") . $w['candLName'];
                $votes = $w['totalVotes'];

                echo "<li class='list-group-item d-flex justify-content-between align-items-center py-3'>
                        <div>
                            <span class='rank-badge'>$rank</span>
                            <span class='fw-bold text-uppercase'>$fullName</span>
                        </div>
                        <span class='badge bg-success rounded-pill p-2'>$votes Votes</span>
                      </li>";
                $rank++;
            }
        } else {
            echo "<li class='list-group-item text-center text-muted py-4'>No votes cast for this position yet.</li>";
        }

        echo "      </ul>
                    </div>
                </div>
            </div>";
    }
    ?>
    </div>

    <div class="text-center my-5">
        <a href="results.php" class="btn btn-outline-secondary px-4">View Full Stats</a>
        <a href="../index.php" class="btn btn-primary px-4">Back to Main Page</a>
    </div>
</div>

</body>
</html>