<?php

namespace App\Http\Controllers;

class IThemeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function syncUser()
    {
        $jsonResposnse = '{
            "status": "success",
            "message": "Sync account created.",
            "data": {
                "apikey": "6d602e935b57bdcfb27986e47eaaf628",
                "external_id": "1000000056",
                "user_id": "119437"
            }
        }';

        echo $jsonResposnse;

    }

    //
}
