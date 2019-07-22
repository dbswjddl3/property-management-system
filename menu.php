<div class="w3-top admin-top">
    <div class="w3-bar w3-white w3-wide w3-padding w3-card-2">

    <div>
        <a href="/<?=$_SERVER['ACCESS_SERVER_NAME']?>/main.php" class="w3-bar-item w3-button">Home</a>

        <?php 
        foreach ($_COMMON['buildings'] as $key => $building) { ?>
        <div class="w3-dropdown-hover">
            <a class="w3-button"><?=$building?></a>
            <div class="w3-dropdown-content w3-bar-block w3-border">
                <a href="/<?=$_SERVER['ACCESS_SERVER_NAME']?>/report/list.php?building=<?=$key?>" class="w3-bar-item w3-button">Report Case</a>
                <a href="/<?=$_SERVER['ACCESS_SERVER_NAME']?>/report/calendar.php?building=<?=$key?>" class="w3-bar-item w3-button">Report Calendar</a>
                <a href="/<?=$_SERVER['ACCESS_SERVER_NAME']?>/booking/list.php?building=<?=$key?>" class="w3-bar-item w3-button">Booking Request</a>
                <a href="/<?=$_SERVER['ACCESS_SERVER_NAME']?>/booking/calendar.php?building=<?=$key?>" class="w3-bar-item w3-button">Booking Calendar</a>
                <a href="/<?=$_SERVER['ACCESS_SERVER_NAME']?>/moving_in_out/list.php?building=<?=$key?>" class="w3-bar-item w3-button">Moving Request</a>
                <a href="/<?=$_SERVER['ACCESS_SERVER_NAME']?>/moving_in_out/calendar.php?building=<?=$key?>" class="w3-bar-item w3-button">Moving Calendar</a>
            </div>
        </div>

        <? } ?>
    </div>
    
    <div class="w3-right">
        <?php
        if (!isset($_SESSION['seq'])) {
            include_once "./login_modal.php"; ?>
            <button onclick="document.getElementById('login-modal').style.display='block'" class="w3-button w3-green w3-large">Login</button>
        <? } else { ?>
            <span href="#" class="w3-bar-item">Welcome, <b><?=$_SESSION['name']?></b>!</span>
            <button onclick="location.href='/<?=$_SERVER['ACCESS_SERVER_NAME']?>/logout.php'" class="w3-button w3-medium w3-green">Logout</button>  
        <? } ?>
    </div>
</div>