<?php
require("../auth/db.php");


if (isset($_POST['election_id']) and isset($_POST['candidate_id']) and isset($_POST['voter_id'])) {
    $vote_date = date("Y-m-d");
    $vote_time = date("h:i:s a");

    mysqli_query($conn, "INSERT INTO votings(election_id, voters_id, candidate_id, vote_date, vote_time) VALUES('" . $_POST['election_id'] . "', '" . $_POST['voter_id'] . "','" . $_POST['candidate_id'] . "','" . $vote_date . "','" . $vote_time . "')") or die(mysqli_error($conn));

    echo "Success";
}
