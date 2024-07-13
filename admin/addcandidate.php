<?php
require("../auth/db.php");
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Candidate</title>
    <link rel="stylesheet" href="../public/stylesheets/style.css">
    <script src="../public/javascripts/script.js"></script>
</head>

<body>

    <div class="add-election-container">

        <div class="add-election-form">

            <h3>Add New Candidates</h3>
            <form method="POST" enctype="multipart/form-data">

                <select class="select-topic" name="election_id" required>
                    <option value=""> Select Election </option>

                    <?php
                    $sql = "SELECT * FROM elections";
                    $fetchingElections = mysqli_query($conn, $sql) or die(mysqli_error($db));
                    $isAnyElectionAdded = mysqli_num_rows($fetchingElections);

                    if ($isAnyElectionAdded > 0) {
                        while ($row = mysqli_fetch_assoc($fetchingElections)) {
                            $election_id = $row['id'];
                            $election_name = $row['election_topic'];
                            $allowed_candidates = $row['no_of_candidates'];

                            // Now checking how many candidates are added in this election 
                            $sql =  "SELECT * FROM candidate_details WHERE election_id = '" . $election_id . "'";
                            $fetchingCandidate = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                            $added_candidates = mysqli_num_rows($fetchingCandidate);

                            if ($added_candidates < $allowed_candidates) {
                    ?>
                                <option value="<?php echo $election_id; ?>"><?php echo $election_name; ?></option>
                        <?php
                            }
                        }
                    } else {
                        ?>
                        <option value=""> Please add election first </option>
                    <?php
                    }
                    ?>
                </select>


                <input type="text" name="candidate_name" placeholder="Candidate Full Name" required />

                <input type="text" name="candidate_details" placeholder="Candidate Details" required /><br>

                <center>Candidate image <input type="file" name="candidate_photo" style="width:230px" required /></center><br>

                <center> <input type="submit" value="Add Candidate" name="addCandidateBtn" id="submit" /></center>
            </form>
        </div>

        <div class="election-table-container">
            <div id="message"></div>
            <h3>Candidate Details</h3><br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Details</th>
                        <th scope="col">Election</th>
                        <th scope="col">Action </th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM candidate_details";
                    $fetchingData = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    $isAnyCandidateAdded = mysqli_num_rows($fetchingData);

                    if ($isAnyCandidateAdded > 0) {
                        $sno = 1;
                        while ($row = mysqli_fetch_assoc($fetchingData)) {
                            $election_id = $row['election_id'];
                            $sql =  "SELECT * FROM elections WHERE id = '" . $election_id . "'";
                            $fetchingElectionName = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                            $execFetchingElectionNameQuery = mysqli_fetch_assoc($fetchingElectionName);
                            $election_name = $execFetchingElectionNameQuery['election_topic'];
                            $candidate_photo = $row['candidate_photo'];

                    ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo" /></td>
                                <td><?php echo $row['candidate_name']; ?></td>
                                <td><?php echo $row['candidate_details']; ?></td>
                                <td><?php echo $election_name; ?></td>
                                <td>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                        <button name="delete_candidate" value="<?php echo $row['id']; ?>" class="deletecandidate"> Delete </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7"> No any candidate is added yet. </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php

        if (isset($_POST['addCandidateBtn'])) {
            $election_id = mysqli_real_escape_string($conn, $_POST['election_id']);
            $candidate_name = mysqli_real_escape_string($conn, $_POST['candidate_name']);
            $candidate_details = mysqli_real_escape_string($conn, $_POST['candidate_details']);
            $inserted_by = $_SESSION['name'];
            $inserted_on = date("Y-m-d");

            $targetted_folder = "../public/images/candidate_photos/";
            $candidate_photo = $targetted_folder . rand(111111111, 99999999999) . "_" . rand(111111111, 99999999999) . $_FILES['candidate_photo']['name'];
            $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
            $candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
            $allowed_types = array("jpg", "png", "jpeg");
            $image_size = $_FILES['candidate_photo']['size'];

            if ($image_size < 2000000) // 2 MB
            {
                if (in_array($candidate_photo_type, $allowed_types)) {
                    if (move_uploaded_file($candidate_photo_tmp_name, $candidate_photo)) {
                        // inserting into db
                        if (mysqli_query($conn, "INSERT INTO candidate_details(election_id,candidate_photo, candidate_name, candidate_details, inserted_by, inserted_on) VALUES('" . $election_id . "', '" . $candidate_photo . "', '" . $candidate_name . "', '" . $candidate_details . "', '" . $inserted_by . "', '" . $inserted_on . "')") or die(mysqli_error($conn))) {

                            $n = 1;
                            echo "<script>
                                    showCandMsg($n);</script>";
                        }

                        echo "<script> location.assign('addcandidate.php?addCandidatePage=1&added=1'); </script>";
                    } else {
                        echo "<script> location.assign('addcandidate.php?addCandidatePage=1&failed=1'); </script>";
                    }
                } else {
                    echo "<script> location.assign('addcandidate.php?addCandidatePage=1&invalidFile=1'); </script>";
                }
            } else {
                echo "<script> location.assign('addcandidate.php?addCandidatePage=1&largeFile=1'); </script>";
            }
        }

        if (isset($_POST['delete_candidate'])) {
            $c_id = $_POST['delete_candidate'];
            $query = "DELETE FROM candidate_details WHERE id = $c_id";
            $sql = mysqli_query($conn, $query);
            if ($sql) {
                $n = 0;
                echo "<script>
                      showCandMsg($n);</script>";
            }
        }

        include("../public/footer.php");

        ?>

</body>

</html>