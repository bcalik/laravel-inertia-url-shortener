<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WhitelistGate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        throw_if(
            ! $this->isAllow(),
            new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Unauthorized')
        );

        return $next($request);
    }

    public function isAllow(): bool
    {
        $whiteList = explode(';', config('whitelist.allow'));
        $userIp = request()->ip();

        foreach ($whiteList as $ip) {
            if (\Symfony\Component\HttpFoundation\IpUtils::checkIp($userIp, $ip)) {
                return true;
            }
        }

        return false;
    }

}
