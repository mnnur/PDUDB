<?php

namespace App\Controllers;

class Logout extends BaseController {

    public function logout()
    {
        session();
        $ses_data = [
            'user_id'       => '',
            'user_name'     => '',
            'user_email'    => '',
            'logged_in'     => False
        ];
        session()->set($ses_data);
        session()->remove($ses_data);
        session_destroy();
        return redirect()->route('/');
    }

}