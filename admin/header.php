<?php include("../auth/auth.php");
error_reporting(0);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Yeseva One">

<div class="header">

    <div class="header-logo-container">

        <div class="header-logo">
            <a style="text-decoration: none" href="homepage.php"><span style="color:#005904">e</span><span style="color:#002061">VOTER</span></a>
        </div>

        <h3 style="color:#fff;margin-left:3px;"> Hello <?php echo $_SESSION['name']; ?>!</h3>

    </div>

    <div class="navbar" id="navbar">
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="addcandidate.php">Add Candidates</a></li>
            <li><a href="addelections.php">Add Election</a></li>
            <li><a href="../auth/logout.php">Logout</a></li>
        </ul>
    </div>
    <i class="fa fa-close" id="i" onclick="showNav()"></i>

</div>

<?php echo "<script>if(document.documentElement.clientWidth<=1000){
                    var i = document.getElementById('i');
                    var nav = document.getElementById('navbar');
                    nav.style.display = 'none';
                    i.className = 'fa fa-bars';
}</script>";
?>