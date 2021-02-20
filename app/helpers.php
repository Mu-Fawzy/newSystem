<?php

if (!function_exists('removeLettersFromStart')) {
    function removeLettersFromStart($str, $letterNum ,$where = null) {
        if (app()->getLocale() == 'ar') {
            return mb_substr($str, $letterNum, $where, "utf-8");
        }else{
            return $str;
        }
    }
}


