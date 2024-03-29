<div id="login-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

        <div class="w3-center"><br>
        <span onclick="document.getElementById('login-modal').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
        <img src="/astar/img_avatar4.png" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
        </div>

        <form class="w3-container" method="post" action="./login.php">
        <div class="w3-section">
            <label><b>Username</b></label>
            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="id" required>
            <label><b>Password</b></label>
            <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="password" required>
            <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Login</button>
            <input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me
        </div>
        </form>

        <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
            <button onclick="document.getElementById('login-modal').style.display='none'" type="button" class="w3-button w3-red">Cancel</button>
            <span class="w3-right w3-padding"><a href="./signup.php">sign up</a></span>
        </div>

    </div>
</div>
