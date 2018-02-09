<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mydir = $this->myDirectory();
        $homeArray = [
                        'curbox' => 'B2',
                        'bodwidth' => '830px',
                        'LNfilename' => 'webconnect/navs/' . $mydir . '.php',
                        'thisbox' => $this->getThisBox('B2'),
                    ];
        return view('home')->with($homeArray);
    }


    private function myDirectory()
    {
        $result = explode('/', dirname($_SERVER['PHP_SELF']));
        return end($result);
    }


    private function getThisBox($curbox)
    {
        return ".topleft".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "TL.jpg);
            background-position:bottom right;
            background-repeat:no-repeat;}
        .top".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "T.jpg);
            background-position:bottom left;
            background-repeat:repeat-x;}
        .topright".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "TR.jpg);
            background-position:bottom left;
            background-repeat:no-repeat;}
        .left".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "L.jpg);
            background-position:top right;
            background-repeat:repeat-y;}
        .right".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "R.jpg);
            background-position:top left;
            background-repeat:repeat-y;}
        .botleft".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "BL.jpg);
            background-position:top right;
            background-repeat:no-repeat;}
        .bot".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "B.jpg);
            background-position:top left;
            background-repeat:repeat-x;}
        .botright".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "BR.jpg);
            background-position:top left;
            background-repeat:no-repeat;};";
    }
}
