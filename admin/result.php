<?php 
require("../auth/db.php");
    $election_id = $_GET['viewResult'];
    include("header.php")
?>

<head>
    <title>Election Result</title>
    <link rel="stylesheet" href="../public/stylesheets/style.css">
</head>
<body>
    
<div class="add-election-container">
        
            <h3> Election Results </h3>
            <br>
            <?php 
                $fetchingActiveElections = mysqli_query($conn, "SELECT * FROM elections WHERE id = '". $election_id ."'") or die(mysqli_error($conn));
                $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

                if($totalActiveElections > 0) 
                {
                    while($data = mysqli_fetch_assoc($fetchingActiveElections))
                    {
                        $election_id = $data['id'];
                        $election_topic = $data['election_topic'];    
                ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4" class=""><h5> ELECTION TOPIC: <?php echo strtoupper($election_topic); ?></h5></th>
                                </tr>
                                <tr>
                                    <th> Candidate Name </th>
                                    <th> Candidate Details </th>
                                    <th> Number of Votes </th>
                                    <!-- <th> Action </th> -->
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $fetchingCandidates = mysqli_query($conn, "SELECT * FROM candidate_details WHERE election_id = '". $election_id ."'") or die(mysqli_error($conn));

                                while($candidateData = mysqli_fetch_assoc($fetchingCandidates))
                                {
                                    $candidate_id = $candidateData['id'];
                                    $candidate_name = $candidateData['candidate_name'];

                                    // Fetching Candidate Votes 
                                    $fetchingVotes = mysqli_query($conn, "SELECT * FROM votings WHERE candidate_id = '". $candidate_id . "'") or die(mysqli_error($conn));
                                    $totalVotes = mysqli_num_rows($fetchingVotes);

                            ?>
                                    <tr>
                                        <td> <?php echo "<b>" . $candidateData['candidate_name'] . "</b>"; ?></td>
                                        <td><?php echo "<b>".$candidateData['candidate_details']."<b>"; ?></td>
                                        <td><?php echo $totalVotes; ?></td>
                                    </tr>
                            <?php
                                }
                            ?>
                            </tbody>

                        </table>
                <?php
                    
                    }
                }else {
                    echo "No any active election.";
                }
            ?>

            </table>
        
    </div>

</body>


