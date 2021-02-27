<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['loggedin'])) {
    //Store the page that I'm currently on in the session
    $_SESSION['page'] = $_SERVER['SCRIPT_URI'];

    //Redirect to login
    header("location: login.html");
}
?>

<include href="views/header.php"></include>

<h1 class="center-text">Status</h1>

<div class="container-fluid row">
    <div class="col-3">
        <h3 class="center-text">Notifications</h3>
    </div>

    <div class="col-6">
        <h3 class="center-text">Today</h3>

        <table class="thick-border width-80 center-table">
            <tr class="thick-border">
                <th style="width: 45%;" class="thick-border center-text">Time</th>
                <th class="skinny-border center-text">SHD-1</th>
                <th class="skinny-border center-text">SHD-2</th>
            </tr>

            <tr>
                <td class="skinny-border center-text">8:00 am - 9:00 am</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
            <tr>
                <td class="skinny-border center-text">9:00 am - 10:00 am</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
            <tr>
                <td class="skinny-border center-text">10:00 am - 11:00 am</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
            <tr>
                <td class="skinny-border center-text">11:00 am - 12:00 pm</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
            <tr>
                <td class="skinny-border center-text">12:00 pm - 1:00 pm</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
            <tr>
                <td class="skinny-border center-text">1:00 pm - 2:00 pm</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
            <tr>
                <td class="skinny-border center-text">2:00 pm - 3:00 pm</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
            <tr>
                <td class="skinny-border center-text">3:00 pm - 4:00 pm</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
            <tr>
                <td class="skinny-border center-text">4:00 pm - 5:00 pm</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
            <tr>
                <td class="skinny-border center-text">5:00 pm - 6:00 pm</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
            <tr>
                <td class="skinny-border center-text">6:00 pm - 7:00 pm</td>
                <td class="skinny-border"></td>
                <td class="skinny-border"></td>
            </tr>
        </table>
    </div>

    <div class="col-3">
        <h3 class="center-text">Daily Stats</h3>
        <br>

        <ul class="list-unstyled center-text">
            <li>Total Patrons Today</li>
            <li class="large-font"><strong>16</strong></li>
            <br>
            <li>Average Patrons Per Hour</li>
            <li class="large-font"><strong>2</strong></li>
            <br>
            <li>Average Patrons Per Day</li>
            <li class="large-font"><strong>15</strong></li>
            <br>
            <li>Total Patrons This Week</li>
            <li class="large-font"><strong>31</strong></li>
        </ul>
    </div>
</div>
<br>
<br>

<form class="center-text" method="post" action="form">
    <input type="submit" class="submit-login rounded" value="New Patron Form">
</form>
<br>

<include href="views/footer.html"></include>
