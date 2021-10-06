<?php

namespace App\Services;

use App\Models\AndroidApp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class NativeAppService
{
    /**
     * Android一覧
     */
    public function android()
    {
        $files = Storage::disk('s3-android')->files('');
        return new AndroidApp(array_reverse($files));
    }

    /**
     * AndroidダウンロードURL取得
     */
    public function downloadUrlForAndroid($path)
    {
        $expire = Carbon::now()->addSecond(60);
        return Storage::disk('s3-android')->temporaryUrl($path, $expire);
    }
}
