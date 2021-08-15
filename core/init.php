<?php

if(function_exists('date_default_timezone_set')) {
    date_default_timezone_set("Asia/Kolkata");
}


$GLOBALS['config'] = array(
    'mysql' => array(                                                //mysql config
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'password',
        'db' => 'quiz'
    ),
    'remember' => array(                                            //remember me config
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800,

    ),
    'session' => array(                                                //session config
        'session_name' => 'user',
        'token_name' => 'token',
        'login_token_name' => 'login_token',
        'signup_token_name' => 'signup_token',
        'update_token_name' => 'update_token',
        'csrf_token_name' => 'csrf',
        'user_type' => 'user_type',
        'user_email' => 'email',
        'user_name' => "name"
    ),
    'TokenKey'=>"codegreenback",
    'serverIP' => '127.0.0.1',


);