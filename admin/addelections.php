<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Election</title>
    <link rel="stylesheet" href="../public/stylesheets/style.css">
    <script src='../public/javascripts/script.js'></script>

</head>

<body>

    <div class="add-election-container">
        <div class="add-election-form">
            <h2>Add New Election</h2>
            <form method="POST">

                <input type="text" name="election_topic" placeholder="Elction Topic" class="" required />


                <input type="number" name="number_of_candidates" placeholder="No of Candidates" class="" required />


                <input type="text" onfocus="this.type='Date'" name="starting_date" placeholder="Starting Date" class="" required />


                <input type="text" onfocus="this.type='Date'" name="ending_date" placeholder="Ending Date" class="" required /><br>

                <center><input type="submit" value="Add Election" name="addElectionBtn" id="submit" /></center>
            </form>
        </div>
        <div class="election-table-container">
            <h3>Upcoming Elections</h3><br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Election Name</th>
                        <th scope="col">Candidates</th>
                        <th scope="col">Starting Date</th>
                        <th scope="col">Ending Date</th>
                        <th scope="col">Status </th>
                        <th scope="col">Action </th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    require("../auth/db.php");

                    $sql =  "SELECT * FROM elections";
                    $fetchingData = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    $isAnyElectionAdded = mysqli_num_rows($fetchingData);

                    if ($isAnyElectionAdded > 0) {
                        $sno = 1;
                        while ($row = mysqli_fetch_assoc($fetchingData)) {
                            $election_id = $row['id'];
                    ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $row['election_topic']; ?></td>
                                <td><?php echo $row['no_of_candidates']; ?></td>
                                <td><?php echo $row['starting_date']; ?></td>
                                <td><?php echo $row['ending_date']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td>

                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                        <button name="delete_elec" value="<?php echo $row['id']; ?>" class="deletecandidate"> Delete </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7"> No any election is added yet. </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php

    if (isset($_POST['addElectionBtn'])) {
        $election_topic = mysqli_real_escape_string($conn, $_POST['election_topic']);
        $number_of_candidates = mysqli_real_escape_string($conn, $_POST['number_of_candidates']);
        $starting_date = mysqli_real_escape_string($conn, $_POST['starting_date']);
        $ending_date = mysqli_real_escape_string($conn, $_POST['ending_date']);
        $inserted_by = $_SESSION['name'];
        $inserted_on = date("Y-m-d");


        $date1 = date_create($inserted_on);
        $date2 = date_create($starting_date);
        $diff = date_diff($date1, $date2);


        if ((int)$diff->format("%R%a") > 0) {
            $status = "InActive";
        } else {
            $status = "Active";
        }

        // inserting into db
        if (mysqli_query($conn, "INSERT INTO elections(election_topic, no_of_candidates, starting_date, ending_date, status, inserted_by, inserted_on) VALUES('" . $election_topic . "', '" . $number_of_candidates . "', '" . $starting_date . "', '" . $ending_date . "', '" . $status . "', '" . $inserted_by . "', '" . $inserted_on . "')") or die(mysqli_error($db))) {

            $n = 1;
            echo "<script>
                  showElecMsg($n);</script>";
        }
    }

    if (isset($_POST['delete_elec'])) {
        $e_id = $_POST['delete_elec'];
        $query = "DELETE FROM elections WHERE id = $e_id";
        $sql = mysqli_query($conn, $query);
        if ($sql) {
            $n = 0;
            echo "<script>
                  showElecMsg($n);</script>";
        }
    }

    ?>
    <?php
    include("../public/footer.php");
    ?>
</body>

</html>