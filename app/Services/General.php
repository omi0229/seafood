<?php

namespace App\Services;


class General
{
    static function randomPassword()
    {
        $string = '0123456789abcdefghijklmnopqrstuvwxyz';
        $new_password = '';
        for ($n = 1; $n <= 8; $n++) {
            $new_password .= $string[rand(0, 35)];
        }

        return $new_password;
    }
}
