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

if(!$PEA->steam->isLoggedIn())
    header('LOCATION: index.php?page=login');

if(!$PEA->steam->isValidEvent($_SESSION['event']))
    header('LOCATION: index.php?page=logout');

$cachedTournamentLayout = $PEA->steam->getTournamentLayout($_SESSION['event']);
$cachedPlayerSummaries = $PEA->steam->getPlayerSummaries($_SESSION['steamID64']);

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $PEA->config->site_pagetitle; ?> - <?php echo $cachedTournamentLayout->name; ?></title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.indigo-pink.min.css">
    <link rel="stylesheet" href="assets/style/styles.css">
    <style>
        #view-source {
            position: fixed;
            display: block;
            right: 0;
            bottom: 0;
            margin-right: 40px;
            margin-bottom: 40px;
            z-index: 900;
        }
    </style>

    <script src='assets/script/nprogress.js'></script>
    <link rel='stylesheet' href='assets/style/nprogress.css'/>
</head>
<body onload="NProgress.done();">
<script>
    NProgress.start();
</script>
<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title"><?php echo $cachedTournamentLayout->name; ?> - Team Pick'Em</span>
            <div class="mdl-layout-spacer"></div>
            <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
                <i class="material-icons">more_vert</i>
            </button>
            <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
                <li class="mdl-menu__item" id="show-dialog">About</li>
            </ul>
        </div>
    </header>
    <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
            <img src="<?php echo htmlspecialchars($cachedPlayerSummaries->avatarfull); ?>" class="demo-avatar">
            <div class="demo-avatar-dropdown">
                <span><?php echo htmlspecialchars($cachedPlayerSummaries->personaname); ?></span><br /><br />
            </div>
        </header>
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
            <a class="mdl-navigation__link" href="index.php?page=main">Team Pick'Em</a>
            <a class="mdl-navigation__link" href="index.php?page=fantasy">Fantasy Team</a>
            <div class="mdl-layout-spacer"></div>
            <a class="mdl-navigation__link" href="index.php?page=logout"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">&#xE879;</i>Logout</a>
        </nav>
    </div>
    <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid demo-content">
            <div class="demo-cards mdl-cell mdl-cell mdl-cell--12-col mdl-grid">
                <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
                    <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                        <h2 class="mdl-card__title-text"><?php echo $cachedTournamentLayout->name; ?></h2>
                    </div>
                    <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                        <ul style="margin-left: 20px;">
                            <li>Watch the matches at <?php echo $cachedTournamentLayout->name; ?> and use your team stickers to pick the winners of each matchup.</li>
                            <li>Whenever you make a correct pick, you'll learn points toward a Pick'Em Trophy that can be displayed on your CS:GO avatar and in your Steam profile.</li>
                            <li>Be sure to make your picks before the start of each match.</li>
                            <li>Get one additional point each day you play.</li>
                            <li>Making a pick will lock the sticker. It will be unusable and untradeable until the end of the match day. Removing the pick at a later time will not undo the lock.</li>
                        </ul>
                    </div>
                </div>
                <?php

                foreach($cachedTournamentLayout->sections as $section) {
                    if(count($section->groups) > 0) {
                ?>
                <div class="demo-separator mdl-cell--1-col"></div>
                <div class="mdl-color-text--grey-600 mdl-cell--12-col" style="margin-left: -65px; margin-top: 25px;">
                    <h2><?php echo $section->name; ?></h2>
                </div>
                    <?php

                    foreach($section->groups as $group) {

                    ?>
                    <div class="demo-options mdl-card mdl-color--blue-500 mdl-shadow--2dp mdl-cell mdl-cell--<?php echo $PEA->site->getColWidthByGroupCount(count($section->groups)) ?>-col">
                        <div class="mdl-card__supporting-text mdl-color-text--blue-grey-50">
                            <h3><?php echo $group->name; ?> | Points: <?php echo $group->points_per_pick; ?></h3>
                            <ul>
                                <?php

                                foreach($group->teams as $team) {

                                ?>
                                <li>
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                                        <input type="radio" id="option-1" class="mdl-radio__button" name="options" value="<?php echo $team->pickid ?>1">
                                        <span class="mdl-radio__label"><?php echo $PEA->steam->getTeamNameById($_SESSION['event'], $team->pickid); ?></span>
                                    </label>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                            <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-grey-50">Change Pick</a>
                            <div class="mdl-layout-spacer"></div>
                            <i class="material-icons">&#xE8DF;</i>
                        </div>
                    </div>
                    <?php } ?>
                <?php } } ?>
            </div>
        </div>
    </main>
</div>
<a href="https://github.com/pkfln/" target="_blank" id="view-source" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color-text--white" data-upgraded=",MaterialButton,MaterialRipple">View Source on GitHub<span class="mdl-button__ripple-container"><span class="mdl-ripple is-animating" style="width: 255.952px; height: 255.952px; transform: translate(-50%, -50%) translate(34px, 22px);"></span></span></a>
<script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>
<script src="assets/script/jquery-1.12.4.min.js"></script>
<dialog class="mdl-dialog">
    <h3 class="mdl-dialog__title">About</h3>
    <div class="mdl-dialog__content">
        <p>
            Open Source project by pkfln (<a href="https://github.com/pkfln">https://github.com/pkfln</a>).
        </p>
    </div>
    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button close">OK</button>
    </div>
</dialog>
<script>
    var dialog = document.querySelector('dialog');
    var showDialogButton = document.querySelector('#show-dialog');
    if (! dialog.showModal) {
        dialogPolyfill.registerDialog(dialog);
    }
    showDialogButton.addEventListener('click', function() {
        dialog.showModal();
    });
    dialog.querySelector('.close').addEventListener('click', function() {
        dialog.close();
    });
</script>
</body>
</html>
