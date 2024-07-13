
function showNav() {

    var i = document.getElementById('i');
    var nav = document.getElementById('navbar');

    if (nav.style.display === "none") {
        nav.style.display = "block";
        i.className = "fa fa-close";

    }
    else {
        nav.style.display = "none";
        i.className = "fa fa-bars";
    }
}

function showPassword() {
    var pass = document.getElementById('password');
    if (pass.type === "password") {
        pass.type = "text";
    } else {
        pass.type = "password";
    }
}

function showCandMsg(n) {

    if (n) {
        alert("Candidate added successfully");
    }
    else {
        alert("Candidate removed.");
    }
    window.location = 'addcandidate.php';

}

function showElecMsg(n) {

    if (n) {
        alert("Election added successfully");
    }
    else {
        alert("Election removed.");
    }
    window.location = 'addelections.php';

}

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

const CastVote = (election_id, candidate_id, voters_id) => {

    $.ajax({
        type: "POST",
        url: "../voters/ajaxCall.php",
        data: "election_id=" + election_id + "&candidate_id=" + candidate_id + "&voter_id=" + voters_id,
        success: function (response) {

            if (response == "Success") {
                location.assign("home.php?voteCasted=1");
                location.reload();
            } else {
                location.assign("home.php?voteNotCasted=1");
            }
            console.log(response);
        }
    });
}

function closeContact() {

    var cont = document.getElementById('contact');

    if (cont.style.display === "none") {
        cont.style.display = "flex";

    }
    else {
        cont.style.display = "none";
    }
}
