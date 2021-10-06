<?php

namespace App\Http\Controllers;

use App\Http\Resources\NativeAppAndroidDownloadUrlResource;
use App\Http\Resources\NativeAppResource;
use App\Services\NativeAppService;

class NativeAppController extends Controller
{
    private $native_app_service;

    public function __construct(NativeAppService $native_app_service)
    {
        $this->middleware('auth');
        $this->native_app_service = $native_app_service;
    }

    /**
     * ネイティブアプリ - 一覧
     */
    public function index()
    {
        $android_app = $this->native_app_service->android();
        return new NativeAppResource([
            'android_app' => $android_app
        ]);
    }

    /**
     * ネイティブアプリ - AndroidダウンロードURL取得
     */
    public function androidDownloadUrl($path)
    {
        return new NativeAppAndroidDownloadUrlResource([
            'download_url' => $this->native_app_service->downloadUrlForAndroid($path)
        ]);
    }
}
