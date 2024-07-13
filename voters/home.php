<?php
require("../auth/db.php");
include("voter-header.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter-Home</title>
    <link rel="stylesheet" href="../public/stylesheets/style.css">
    <script src="../public/javascripts/script.js"></script>
</head>

<body>

    <div class="add-election-container">


        <div id="contact"> Email <br><br>atharvsm23@gmail.com <br>anuraj@gmail.com <i class="fa fa-close" id="i" onclick="closeContact()"></i></div>

        <h3> Voters Panel </h3><br>

        <?php
        $fetchingActiveElections = mysqli_query($conn, "SELECT * FROM elections WHERE status = 'Active'") or die(mysqli_error($conn));
        $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

        if ($totalActiveElections > 0) {
            while ($data = mysqli_fetch_assoc($fetchingActiveElections)) {
                $election_id = $data['id'];
                $election_topic = $data['election_topic'];
        ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="4" class="">
                                <h4> ELECTION TOPIC : <?php echo strtoupper($election_topic); ?></h4>
                            </th>
                        </tr>
                        <tr>
                            <th> Candidate Images </th>
                            <th> Candidate Details </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fetchingCandidates = mysqli_query($conn, "SELECT * FROM candidate_details WHERE election_id = '" . $election_id . "'") or die(mysqli_error($conn));

                        while ($candidateData = mysqli_fetch_assoc($fetchingCandidates)) {
                            $candidate_id = $candidateData['id'];
                            $candidate_photo = $candidateData['candidate_photo'];


                            // Fetching Candidate Votes 
                            // $fetchingVotes = mysqli_query($conn, "SELECT * FROM votings WHERE candidate_id = '" . $candidate_id . "'") or die(mysqli_error($conn));
                            // $totalVotes = mysqli_num_rows($fetchingVotes);

                        ?>
                            <tr>
                                <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo"> </td>

                                <td><?php echo "<b>" . $candidateData['candidate_name'] . "</b><br>" . $candidateData['candidate_details']; ?></td>
                                <!-- <td><?php echo $totalVotes; ?></td> -->
                                <td>
                                    <?php
                                    $checkIfVoteCasted = mysqli_query($conn, "SELECT * FROM votings WHERE voters_id = '" . $_SESSION['rollno'] . "' AND election_id = '" . $election_id . "'") or die(mysqli_error($conn));
                                    $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);

                                    if ($isVoteCasted > 0) {
                                        $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                                        $voteCastedToCandidate = $voteCastedData['candidate_id'];

                                        if ($voteCastedToCandidate == $candidate_id) {
                                    ?>
                                            <!-- <h3>Voted</h3> -->
                                            <img style="width:80px" src="../public/images/vote.png" alt="Vote Image">

                                        <?php
                                        }
                                    } else {

                                        ?>
                                        <button class="votebutton" onclick="CastVote(<?php echo $election_id; ?>, <?php echo $candidate_id; ?>, <?php echo $_SESSION['rollno']; ?>)"> Vote </button>
                                    <?php
                                    }


                                    ?>


                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>

                </table>
        <?php

            }
        } else {
            echo "No any active election.";
        }
        ?>
    </div>


    <?php
    require_once("../public/footer.php");
    ?>
</body>

</html>