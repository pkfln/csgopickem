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

class PEA
{
    public $site;
    public $config;
    public $steam;

    public function __construct()
    {
        $this->site = new site();
        $this->config = new config();
        $this->steam = new steam();
    }

    public function basedir()
    {
        return realpath(dirname(__DIR__)); // Get parent dir of current dir, to get the basedir.
    }
}

$PEA = new PEA();

?>