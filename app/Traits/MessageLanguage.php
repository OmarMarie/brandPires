<?php

namespace App\Traits;

trait MessageLanguage
{
    function msg($request, $ar, $en)
    {
        $lang = $en;
        if ($request->header('lang')){
            switch ($request->header('lang'))
            {
                case 'en':
                    $lang = $en;
                    break;
                case 'ar':
                    $lang = $ar;
                    break;
            }
        }
        return $lang;
    }

    function checkLang($request)
    {
        switch ($request->header('lang'))
        {
            case 'en':
                app()->setLocale('en');
                break;
            case 'ar':
                app()->setLocale('ar');
                break;

        }
    }
}