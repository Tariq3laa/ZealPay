<?php

namespace Modules\Common\Http\Controllers;

use Carbon\Carbon;
use F9Web\ApiResponseHelpers;
use App\Http\Controllers\Controller;

class InitController extends Controller
{
    use ApiResponseHelpers;
    public function __construct()
    {
        app()->setLocale('en');
        Carbon::setLocale('en');
        $this->setDefaultSuccessResponse([]);
    }
}
