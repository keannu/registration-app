<?php

namespace App\Http\Middleware;

use \Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class AuthChecker
 * 
 * @author Keannu Rim Kristoffer C. Regala <keannu>
 * @since 2022.05.01
 */
class AuthChecker
{
    /**
     * handle
     * @param Request $oRequest
     * @param Closure $oClosure
     * @return mixed
     */
    public function handle(Request $oRequest, Closure $oClosure)
    {
        if (empty(Cache::get('username')) === true) {
            return redirect()->route('login');
        }

        return $oClosure($oRequest);
    }
}
