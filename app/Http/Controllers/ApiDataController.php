<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiDataController extends Controller
{
    public function requestOne(Request $request)
    {
        $this->validator($request->all())->validate();

        $link = 'https://api.publisher.tonic.com/privileged/v2/sessions/daily?';
        $params = [
            'date' => $request->date,
            'outputs' => 'json'
        ];

        foreach ($params as $key => $val) {
            $link .= $key . '=' . $val .'&';
        }

        $link = substr($link, 0, -1);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Tonic-API-client/2.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        //curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
        //curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $code = (int) $code;

        if ($code === 200) {
            return redirect('/')->with(['status'=>'OK!']);
        }

        return redirect('/')->with(['error'=>'Error']);
    }

    public function requestTwo(Request $request)
    {
        //
    }

    public function requestThree(Request $request)
    {
        $this->validator($request->all())->validate();

        $link = 'https://crossroads.avenueimedia.com/api/v1/stats/campaign_detail?';
        $params=[
            'key'=> 'a1a008b1-41cf-41ad-8bbd-33cde8e1df3d',
            'secret' => '9296d7ae-0289-4f9e-a12a-0b6e8f151c1b',
            //'date' => date('Y-m-d'),
            'date' => $request->date,
            'ts' => time(),
            'fields' => 'tg1,tg2,tg3,tg4,device_type,platform,country_code,keyword,publisher,search_term',
        ];

        $checksum = md5($params['key'] . $params['secret'] . $params['ts'] . $params['date'] );
        $params['checksum'] = $checksum;

        //прицепили GET параметры
        foreach ($params as $key => $val) {
            $link .= $key . '=' . $val .'&';
        }
        // убрали последний &
        $link = substr($link, 0, -1);

        //dd($params, $link);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'CrossRoads-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HEADER, false);
        //curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
        //curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $code = (int) $code;

        //dd(json_decode($out), $code);

        if ( ($code === 200) || ($code === 204)) {
            return redirect('/')->with(['status'=>'OK!']);
        }

        return redirect('/')->with(['error'=>'Error...']);

    }

    public function apiAuth()
    {
        $link = env('CROSSROADS_API_LINK');
        $user = [
            'USER_LOGIN' => env('CROSSROADS_API_USER_NAME'),
            'USER_HASH' => env('CROSSROADS_API_PASSWORD'),
        ];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'CrossRoads-API-client/2.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($user));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $code = (int) $code;

        curl_close($curl);

        //dd(json_decode($out), $code);

        if ($code === 200) {
            return redirect('/')->with(['status' => 'Вы успешно авторизованы']);
        }

        return redirect('/')->with(['error' => 'Ошибка авторизации']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'date' => 'required',
        ]);
    }
}
