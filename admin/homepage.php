<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Home</title>
    <link rel="stylesheet" href="../public/stylesheets/style.css">
    <script src="../public/javascripts/script.js"></script>
</head>

<body>
    <?php
    include("../admin/header.php");
    require('../auth/db.php');
    ?>
    <div class="election-table-container">
        <h2>Elections</h2><br>
        <table class="table" border=1>
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
                $sql = "SELECT * FROM elections";
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $isAnyElectionAdded = mysqli_num_rows($result);

                if ($isAnyElectionAdded > 0) {
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $election_id = $row['id'];
                ?>
                        <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $row['election_topic'] ?></td>
                            <td><?php echo $row['no_of_candidates'] ?></td>
                            <td><?php echo $row['starting_date'] ?></td>
                            <td><?php echo $row['ending_date'] ?></td>
                            <td><?php echo $row['status'] ?></td>
                            <td>
                                <a href="result.php?viewResult=<?php echo $election_id; ?>" class=""> View Results </a>
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
    
    <?php
    include("../public/footer.php");
    ?>