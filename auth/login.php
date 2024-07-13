<?php
// error_reporting(0);
require('../auth/db.php');

session_start();

if (isset($_POST["login"])) {

    $rollno =  (int)$_POST['rollno'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM users WHERE rollno = $rollno and password = '$pass'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $sql1 = "SELECT * FROM users WHERE rollno = $rollno and password = '$pass' and user_role = 'Admin'";
        $result1 = mysqli_query($conn, $sql1);

        $sql2 = "SELECT name FROM users WHERE rollno = $rollno";
        $result2 = mysqli_query($conn, $sql2);
        $resname = mysqli_fetch_assoc($result2);
        $_SESSION['name'] = $resname['name'];
        $_SESSION['rollno'] = $rollno;

        if ($result1->num_rows > 0) {
            header('location: ../admin/homepage.php');
        } else {
            header('location: ../voters/home.php');
        }
    } else {
        echo "<script>alert('Roll number & password didn\'t match.'); window.location.href='login.php#form';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Yeseva One">
    <link rel="stylesheet" href="../public/stylesheets/signin.css">


    <script src="../public/javascripts/script.js"></script>

</head>

<body>

    <div class="container">

        <div class="form-container" id="login">

            <div class="logo">
                <span style="color:#005904">e</span><span style="color:#002061">VOTER</span>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <h2>Login</h2><br>

                Roll Number <br>
                <input type="number" name="rollno" id="rollno" value=<?php if (isset($_POST['login'])) echo $rollno; ?> required><br><br>

                Password <br>
                <input type="password" name="pass" id="password" minlength="6" maxlength="20" required>

                <i class="fa fa-eye" onclick="showPassword()"></i>
                <br><br>

                <input type="submit" value="Vote now" name="login" id="submit">
            </form>
        </div>

    </div>

    <?php
    include("../public/footer.php");
    ?>