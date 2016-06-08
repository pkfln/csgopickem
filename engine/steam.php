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

class steam
{
    public function isLoggedIn()
    {
        return isset($_SESSION['steamID64'], $_SESSION['steamGameAuthcode']) ? true : false;
    }

    public function getPlayerSummaries($steamID64)
    {
        $response = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . config::getValue('steam_key') . '&steamids=' . $steamID64);
        $json = json_decode($response);
        return @$json->response->players[0];
    }

    public function getTournamentLayout($eventID)
    {
        $response = file_get_contents('https://api.steampowered.com/ICSGOTournaments_730/GetTournamentLayout/v1?key=' . config::getValue('steam_key') . '&event=' . $eventID);
        $json = json_decode($response);
        return @$json->result;
    }

    public function getTournamentPredictions($eventID, $steamID64, $steamGameAuthcode)
    {
        $response = file_get_contents('https://api.steampowered.com/ICSGOTournaments_730/GetTournamentPredictions/v1?key=' . config::getValue('steam_key') . '&event=' . $eventID . '&steamid=' . $steamID64 . '&steamidkey=' . $steamGameAuthcode);
        $json = json_decode($response);
        return @$json->result->picks;
    }

    public function getTeamNameById($eventID, $teamID)
    {
        $teams = $this->getTournamentLayout($eventID)->teams;

        foreach($teams as $team)
        {
            if($team->pickid == $teamID)
                return $team->name;
        }

        return 'Unknown';
    }

    public function errorHandling($httpStatusCode)
    {
        $error = 'Unknown error.';

        switch($httpStatusCode)
        {
            case 410:
                $error = 'It\'s no longer possible to place predictions for this matchup / day.';
                break;

            case 400:
                $error = 'Internal error: Prediction not compatible with the event tournament layout.';
                break;

            case 404:
                $error = 'You don\'t own the needed sticker for the prediction.';
                break;

            case 500:
                $error = 'Steam error: Request failed to complete. Try again later.';
                break;

            case 504:
                $error = 'Timeout: The CS:GO backend server implementation timed out waiting for various asynchronous operations involving multiple backend server machines. Try again later.';
                break;

            case 429:
                $error = 'Too many requests. Try again later.';
                break;

            case 503:
                $error = 'Service currently unavailable. Try again later.';
                break;
        }

        return $error;
    }
}

?>