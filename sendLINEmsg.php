<?php
$line_config['line_reply_url'] = "https://api.line.me/v2/bot/message/reply";
$line_config['line_push_url'] = "https://api.line.me/v2/bot/message/push";
$line_config['line_multicast_url'] = "https://api.line.me/v2/bot/message/multicast";
$line_config['line_channel_access_token'] = "line_channel_access_token";

function redirect1($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}

function send_notify($token,$msg)
{   
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, "message=" . $msg);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    $headers = array( "Content-type: application/x-www-form-urlencoded", "Authorization: Bearer ".$token );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec( $ch );
    curl_close( $ch );
    
    return $result;
    
    //$result = send_notify($token, $msg );
}

function create_line_msg($msg)
{
    $ptn = '{"type":"text", "text":" %s "}';
    $r = sprintf($ptn, $msg);
    return $r;
}

function create_flex_msg($msg)
{
    $pattern_msg = '
    {
      "type": "bubble",
      "header": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "แจ้งเตือน %s",
            "size": "xl"
          }
        ]
      },
      "body": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "  %s "
          },
          {
            "type": "text",
            "text": "  %s "
          }
        ]
      },
      "footer": {
        "type": "box",
        "layout": "vertical",
        "spacing": "sm",
        "contents": [
          {
            "type": "button",
            "style": "primary",
            "height": "sm",
            "action": {
              "type": "uri",
              "label": "เปิด",
              "uri": "https://linecorp.com"
            }
          },
          {
            "type": "spacer",
            "size": "sm"
          }
        ],
        "flex": 0
      }
    }
    ';
    
    $return_msg = sprintf($pattern_msg, $msg['h1'], $msg['p1'], $msg['p2']);
    
    return $return_msg;
}

function sent_push_msg($to, $json)
{
    global $line_config;
    //$line_config = config_item('line');

    $msq = '{"to": "'.$to.'", "messages": ['.$json.']}';

    $datasReturn = [];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $line_config['line_push_url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $msq,
        CURLOPT_HTTPHEADER => array(
        "authorization: Bearer ".$line_config['line_channel_access_token'],
        "cache-control: no-cache",
        "content-type: application/json; charset=UTF-8",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $datasReturn['result'] = 'E';
        $datasReturn['message'] = $err;
    } else {
        if($response == "{}"){
        $datasReturn['result'] = 'S';
        $datasReturn['message'] = 'Success';
        }else{
        $datasReturn['result'] = 'E';
        $datasReturn['message'] = $response;
        }
    }
    //echo $msq.'<hr>';    print_r($datasReturn); 

    return $datasReturn;
}

function sent_multicast_msg($to, $json)
{
    global $line_config;
    //$line_config = config_item('line');
    // "to": ["U4af4980629...","U0c229f96c4..."],

    $msq = '{"to": ['.$to.'], "messages": ['.$json.']}';

    $datasReturn = [];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $line_config['line_multicast_url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $msq,
        CURLOPT_HTTPHEADER => array(
        "authorization: Bearer ".$line_config['line_channel_access_token'],
        "cache-control: no-cache",
        "content-type: application/json; charset=UTF-8",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $datasReturn['result'] = 'E';
        $datasReturn['message'] = $err;
    } else {
        if($response == "{}"){
        $datasReturn['result'] = 'S';
        $datasReturn['message'] = 'Success';
        }else{
        $datasReturn['result'] = 'E';
        $datasReturn['message'] = $response;
        }
    }

    return $datasReturn;
}
