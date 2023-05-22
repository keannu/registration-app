<?php

namespace App\Http\Middleware;

use \Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class AuthLoggedInChecker
 * 
 * @author Keannu Rim Kristoffer C. Regala <keannu>
 * @since 2022.05.01
 */
class AuthLoggedInChecker
{
    /**
     * handle
     * @param Request $oRequest
     * @param Closure $oClosure
     * @return mixed
     */
    public function handle(Request $oRequest, Closure $oClosure)
    {
        if (empty(Cache::get('username')) === false) {
            return redirect('dashboard');
        }

        return $oClosure($oRequest);
    }
}
