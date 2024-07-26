<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AccessCodeRequest;
use App\Http\Requests\Auth\AccessCodeValidateRequest;
use App\Models\User;
use App\Notifications\SendLoginAccessCode;
use App\Services\HumanReadableToken;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AccessCodeController extends Controller
{
    public function __construct(
        private readonly HumanReadableToken $humanReadableToken
    ) {}

    public function send(AccessCodeRequest $request): \Illuminate\Http\JsonResponse
    {
        $code = $this->humanReadableToken->generate(6);

        $user = User::query()
            ->where("email", $request->input("email"))
            ->first();

        if (!$user) {
            return response()->json([
                "message" => "Access code sent to your email address.",
            ]);
        }

        $user->authLinks()->create([
            "code" => $code,
            "expires_at" => now()->addMinutes(15),
        ]);

        $user->notify(new SendLoginAccessCode($code));

        return response()->json([
            "message" => "Access code sent to your email address.",
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function verify(AccessCodeValidateRequest $request): \Illuminate\Http\JsonResponse
    {
        /** @var User $user */
        $user = User::query()
            ->where('email', $request->input('email'))
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Invalid access code.',
            ]);
        }

        $code = Str::upper($request->input('code'));

        $authLink = $user->authLinks()
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$authLink || $authLink->expired) {
            throw ValidationException::withMessages([
                'code' => 'Invalid access code.',
            ]);
        }

        $user->authLinks()->delete();

        $token = $user->createToken('access')->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }
}
