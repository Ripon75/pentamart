<?php

namespace App\Http\Controllers\Api;

use App\Classes\Utility;
use App\Models\AppVersion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AppVersionController extends Controller
{
    protected $util;

    public function __construct(Utility $util)
    {
        $this->util = $util;
    }

    public function currnetVersion(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'version_code' => 'required',
            'current_os'   => 'required',
        ]);

        $versionCode = $request->input('version_code', null);
        $currentOS   = $request->input('current_os', null);

        if ($validator->stopOnFirstFailure()->fails()) {
            return $this->util->appError($validator->errors(), "Validation error");
        }

        $checkAppVersion = AppVersion::where('version_code', $versionCode)
        ->where('platform', $currentOS)->first();

        if ($checkAppVersion) {
            return $this->util->appResponse($checkAppVersion, 'App version found');
        } else{
            return $this->util->appError(null, 'App version not found');
        }
    }

    public function nextVersion(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'current_os'   => 'required',
        ]);

        $versionCode = $request->input('version_code', null);
        $currentOS   = $request->input('current_os', null);

        if ($validator->stopOnFirstFailure()->fails()) {
            return $this->util->appError($validator->errors(), "Validaton error");
        }

        $checkAppVersion = AppVersion::where('platform', $currentOS)->where('status', 1)->first();

        if ($checkAppVersion) {
            return $this->util->appResponse($checkAppVersion, 'App version found');
        } else{
            return $this->util->appError(null, 'App version not found');
        }
    }
}
