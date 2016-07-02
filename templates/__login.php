<?php

/*
 *  _____ _      _    ______                      _____ _____
 * |  __ (_)    | |  |  ____|               /\   |  __ \_   _|
 * | |__) |  ___| | _| |__   _ __ ___      /  \  | |__) || |
 * |  ___/ |/ __| |/ /  __| | '_ ` _ \    / /\ \ |  ___/ | |
 * | |   | | (__|   <| |____| | | | | |  / ____ \| |    _| |_
 * |_|   |_|\___|_|\_\______|_| |_| |_| /_/    \_\_|   |_____|
 *
 * Pick'Em API Test
 *
 * @author pkfln <https://github.com/pkfln>
 *
 */

global $PEA;

if($PEA->steam->isLoggedIn())
    header('LOCATION: index.php?page=main');

if(isset($_POST['submit'], $_POST['steamid64'], $_POST['authcode'], $_POST['event'])) {
    if ($PEA->steam->isValidEvent($PEA->steam->getEventIDByName($_POST['event']))) {
        if (isset($PEA->steam->getPlayerSummaries($_POST['steamid64'])->steamid) && $PEA->steam->isValidAuthcode($PEA->steam->getEventIDByName($_POST['event']), $_POST['steamid64'], $_POST['authcode'])) {
            $_SESSION['steamID64'] = $_POST['steamid64'];
            $_SESSION['steamGameAuthcode'] = $_POST['authcode'];
            $_SESSION['event'] = $PEA->steam->getEventIDByName($_POST['event']);

            header('LOCATION: index.php?page=main');
        } else {
            $error = '<script>$(document).ready(function(e) { $.toast({ heading: \'Error\', text: \'Invalid Steam ID64 and / or CS:GO Game Authentication Code. Make sure that your authentication code is for the selected tournament.\', showHideTransition: \'slide\', icon: \'error\', loader: false }) });</script>';
        }
    } else {
        $error = '<script>$(document).ready(function(e) { $.toast({ heading: \'Error\', text: \'Invalid tournament selected.\', showHideTransition: \'slide\', icon: \'error\', loader: false }) });</script>';

    }
}

?>
<!DOCTYPE html>
<!--
  Material Design Lite
  Copyright 2015 Google Inc. All rights reserved.

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      https://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo $PEA->config->site_description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title><?php echo $PEA->config->site_pagetitle; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.teal-red.min.css">
    <link rel="stylesheet" href="assets/style/login.css">
    <link rel="stylesheet" href="assets/style/jquery.toast.css">
    <link rel="stylesheet" href="assets/style/material-select.css">

    <script src='assets/script/nprogress.js'></script>
    <link rel='stylesheet' href='assets/style/nprogress.css'/>
</head>
<body onload="NProgress.done();">
<script>
    NProgress.start();
</script>
<div class="demo-layout mdl-layout mdl-layout--fixed-header mdl-js-layout mdl-color--grey-100">
    <header class="demo-header mdl-layout__header mdl-layout__header--scroll mdl-color--grey-100 mdl-color-text--grey-800">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title"><?php echo $PEA->config->site_pagetitle; ?> - Login</span>
            <div class="mdl-layout-spacer"></div>
        </div>
    </header>
    <div class="demo-ribbon"></div>
    <main class="demo-main mdl-layout__content">
        <div class="demo-container mdl-grid">
            <div class="mdl-cell mdl-cell--2-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
            <form class="demo-content mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 mdl-cell mdl-cell--8-col" method="POST">
                <h3><?php echo $PEA->config->site_pagetitle; ?> - Login</h3>
                <h5>Login with your Steam Game Authentication Code</h5>
                <br /><br />
                <p>To choose your Pick'Em Challenge picks, just login with your Steam ID64 (you can get it
                from <a href="https://steamid.io/" target="_blank">here</a>) and with your CS:GO Game Authentication Code (which you can get
                from <a href="https://help.steampowered.com/en/wizard/HelpWithGameIssue/?appid=730&issueid=128" target="blank">here</a>).</p>
                <br />
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
                    <input class="mdl-textfield__input" type="number" id="steamid64" name="steamid64">
                    <label class="mdl-textfield__label" for="steamid64">STEAM ID64</label>
                </div>
                <br />
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
                    <input class="mdl-textfield__input" type="text" pattern="[A-Z0-9]{4}-[A-Z0-9]{5}-[A-Z0-9]{4}" id="authcode" name="authcode">
                    <label class="mdl-textfield__label" for="authcode">CS:GO Game Authentication Code</label>
                </div>
                <br />
                <div id="eventChooser" class="mdl-select" style="width: 100%;">
                </div>
                <br /><br />
                <input type="submit" name="submit" value="Login" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" style="width: 100%;" />
            </form>
        </div>
        <br /><br /><br /><br /><br /><br />
        <footer class="demo-footer mdl-mini-footer">
            <div class="mdl-mini-footer--center-section">
                <ul class="mdl-mini-footer--link-list">
                    <li><a href="https://github.com/pkfln">pkfln @ github</a></li>
                </ul>
            </div>
        </footer>
    </main>
</div>
<script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>
<script src="assets/script/jquery-1.12.4.min.js"></script>
<script src="assets/script/jquery.toast.js"></script>
<script src="assets/script/material-select.js"></script>
<script>
    materialSelect('eventChooser', 'event', ['<?php echo implode('\', \'', $PEA->config->getValue('valid_events')) ?>'], 'Choose a tournament');
</script>
<?php if(isset($error)) echo $error; ?>
</body>
</html>
