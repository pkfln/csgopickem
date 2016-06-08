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

if(file_exists(realpath(__DIR__ . '/engine/global.php')))
    require_once realpath(__DIR__ . '/engine/global.php');
else
    die('<font style="color: #FF0000;">ERROR:</font> Globalfile not found.');


if(isset($_GET['page']))
{
    switch($_GET['page'])
    {
        case '':
            header('LOCATION: index.php?page=login');
            break;

        default:
            if($PEA->site->tpl_exists($_GET['page']))
                $PEA->site->tpl($_GET['page']);
            else
                header('LOCATION: index.php?page=404');
            break;
    }
}
else
{
    header('LOCATION: index.php?page');
}

?>