<?php

namespace App\Http\Controllers;

use App\Cat;
use App\Mpesa;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kopokopo\SDK\K2;
use Session;

class MpesaController extends Controller
{
    public function subscribe(){
        $options = [
            'clientId' => 'J6IUCHendZ4SbNEAF6WWJZIFcKR2LCmy5hmrlkIVHcU',
            'clientSecret' => 'IDbzppyG-fXTgClVemBnh2irjcfUG_s8E4AD3xELMO4',
            'apiKey' => 'a3ee4134cc102a400aef96c3c9d1a635829f54d2',
            'baseUrl' => 'https://api.kopokopo.com'
        ];
        $K2 = new K2($options);
        $tokens = $K2->TokenService();
        $result = $tokens->getToken();
        $access = $result['data'];
        $accessToken = $access['accessToken'];
        $webhooks = $K2->Webhooks();
        $response = $webhooks->subscribe([
            'eventType' => 'buygoods_transaction_received',
            'url' => 'https://rental.iconztech.com/api/storeWebhooks',
            'scope' => 'till',
            'scopeReference' => '000798',
            'accessToken' => $accessToken,
        ]);
        $location = $response['location'];
        $stk = $K2->StkService();
        $options = [
            'location' => $location,
            'accessToken' => $accessToken,
        ];
        $response = $stk->getStatus($options);
        dd($response);
    }
    public function storeWebhooks(Request $request){
        $duplicate = $request->json()->all();
        Log::info($duplicate);
    }
    public function authenticate(){
        global $K2;
        global $response;
        $webhooks = $K2->Webhooks();

        $json_str = file_get_contents('https://rental.iconztech.com/api/storeWebhooks');
        $response = $webhooks->webhookHandler($json_str, $_SERVER['a419432d-284a-4688-9535-bcf7314c3639']);
        dd($response);
    }
}
