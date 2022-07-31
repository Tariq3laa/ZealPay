<?php

namespace Modules\Common\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Common\Enums\UserTypeEnum;
use Modules\Website\User\Entities\User;

class VerificationController extends Controller
{
    public function verify(Request $request, $user_id)
    {
        $redirect_url = null;
        try {
            switch ($request->user_type) {
                case UserTypeEnum::USER:
                    $user = User::find($user_id);
                    if (empty($user)) {
                        $redirect_url = env('FRONT_URL').'/pages-404';
                    }
                    if (!$user->hasVerifiedEmail()) {
                        $user->markEmailAsVerified();
                        $redirect_url = env('FRONT_URL').'/dashboard';
                    }
                    return redirect()->to($redirect_url);
                default:
                    return redirect()->to(env('FRONT_URL').'/pages-404');
            }
        } catch (\Exception $e) {
            $code = getCode($e->getCode());
            $message = $e->getMessage();
            return jsonResponse($code, $message);
        }
    }

    public function resend()
    {
        try {
            $auth = null;
            if (auth(UserTypeEnum::USER)->check()) {
                $auth = UserTypeEnum::USER;
            }
            if ($auth) {
                $user = auth($auth)->user();
                if ($user->hasVerifiedEmail()) {
                    return jsonResponse(Response::HTTP_BAD_REQUEST, 'Email already verified');
                }
                $user->sendEmailVerificationNotification();
                return jsonResponse(Response::HTTP_OK, 'Email verification link sent on your email');
            } else {
                return redirect()->to(env('FRONT_URL').'/pages-404');
            }
        } catch (\Exception $e) {
            $code = getCode($e->getCode());
            $message = $e->getMessage();
            return jsonResponse($code, $message);
        }
    }

    public function isVerified()
    {
        try {
            if (User::find(auth('client')->id())->email_verified_at) {
                return jsonResponse(Response::HTTP_OK, 'verified');
            }
            return jsonResponse(Response::HTTP_GONE, 'not verified');
        } catch (\Exception $e) {
            $code = getCode($e->getCode());
            $message = $e->getMessage();
            return jsonResponse($code, $message);
        }
    }
}
