<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrganizationMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var Organization $org */
        $org = $request->route('org');

        abort_if(
            !$user->organizations()->where('id', $org->id)->exists(),
            403,
            'You are not a member of this organization.'
        );

        return $next($request);
    }
}
