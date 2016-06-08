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

class site
{
    public function tpl($filename)
    {
        require_once realpath(PEA::basedir() . '/templates/__'.$filename.'.php');
    }

    public function tpl_exists($filename)
    {
        return (file_exists(realpath(PEA::basedir() . '/templates/__'.$filename.'.php'))) ? true : false;
    }

    public function tpl_include($filename)
    {
        require_once realpath(PEA::basedir() . '/templates/tpl_includes/__'.$filename.'.php');
    }

    public function tpl_include_exists($filename)
    {
        return (file_exists(realpath(PEA::basedir() . '/templates/tpl_includes/__'.$filename.'.php'))) ? true : false;
    }

    public function getColWidthByGroupCount($count)
    {
        $colWidth = 3;

        switch($count)
        {
            case 1:
                $colWidth = 12;
                break;

            case 2:
                $colWidth = 6;
                break;

            case 3:
                $colWidth = 4;
                break;

            default:
                $colWidth = 3;
                break;
        }

        return $colWidth;
    }
}

?>