<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function http($page = 1)
    {

        $client = new Client();
        $response = $client->get('https://api.github.com/search/repositories?q=created:%3E2019-01-10&sort=stars&order=desc&page=1&per_page=10');
        // dd($response->getBody()->getContents());
        $result =$response->getBody()->getContents();
        $result  = json_decode($result,true);
        dd(count($result['items']));
    }


}
