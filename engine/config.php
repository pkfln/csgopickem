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

class config
{
    // Steam API Configuration
    public static $steam_key = ''; // Get your Steam-API Key here: https://steamcommunity.com/dev/apikey
    public static $valid_events = array(
        9 // 2016 MLG Columbus Major CS:GO Championship (default event)
    );

    // Site Configuration
    public $site_pagetitle;
    public $site_description;

    public function __construct()
    {
        // Site Configuration
        $this->site_pagetitle = 'Pick\'Em API Test';
        $this->site_description = '';
    }

    public function getValue($var)
    {
        return self::${$var};
    }
}

?>