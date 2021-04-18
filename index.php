<?php
    // cl  API du Bot   modifier
    define('TOKEN', 'YOUR BOT TOKEN HERE');

    // r cup ration des donn es envoy es par Telegram
    $content = file_get_contents('php://input');
    $update = json_decode($content, true);
    $image=getBingImage("today");

    sendPhoto($update['message']['chat']['id'], $image[0],$image[1]);
    // l'utilisateur contacte le bot
     /*
     if(preg_match('/^\/start/', $update['message']['text'])) {
        sendMessage($update['message']['chat']['id'], 'Bonjour '.$update['message']['from']['username'].' ????!');
        sendMessage($update['message']['chat']['id'], $content);
    }

    // l'utilisateur envoie la commande : /covid Paris
    else if(preg_match('/^\/covid/', $update['message']['text'])) {
        $ville = preg_replace('/^\/covid /', '', $update['message']['text']);
        $data = file_get_contents('https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=fr-FR');
        $data = json_decode($data, true);
        $image=
        $message="Pays:".$data['country']."(".$data['countryCode'].")\n
                Region:".$data["regionName"]."(".$data["region"].")\n
                Ville:".$data["city"]."\n";

        $iso3 = file_get_contents('https://restcountries.eu/rest/v2/alpha/'.urlencode($data['countryCode']));
        $iso3 = json_decode($iso3, true);

        $covid = file_get_contents('https://covid-api.com/api/reports?iso='.urlencode($iso3["alpha3Code"]));
        $covid = json_decode($covid, true);

        sendMessage($update['message']['chat']['id'], $message);
    }

    // l'utilisateur envoie n'importe nawak
    else {
        sendMessage($update['message']['chat']['id'], 'Je n\'ai pas compris ????.');
    } */

    function getBingImage($period){
        $data = file_get_contents('https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=fr-FR');
        $image = json_decode($data, true);
        $caption="**".$image['images'][0]["copyright"]."(".$image['images'][0]['title']."**\n\n";
        $caption .="\n\n".$image['images'][0]["copyright"]."\n";
        $photo=["https://bing.com/".$image['images'][0]["url"], $caption];
        
        return $photo;

    }

    // fonction qui envoie une photo  l'utilisateur
    function sendPhoto($chat_id, $photo, $caption) {
        $keyboard = [
            ["Get today's image"],
            ["Get yesterday's image"]
        ];
        $markup=['keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true];

        $q = http_build_query([
            'chat_id' => $chat_id,
            'photo' => $photo,
            "caption"=>$caption,
            "reply_markup"=>$markup
            ]);
        file_get_contents('https://api.telegram.org/bot'.TOKEN.'/sendPhoto?'.$q);
    }
?>