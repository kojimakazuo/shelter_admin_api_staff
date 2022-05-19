<?php

namespace App\Services;

use App\Models\Facility;
use Illuminate\Support\Facades\Storage;

class FacilityService
{
    /**
     * 設備一覧
     */
    public function find()
    {
        return Facility::all();
    }

    /**
     * 設備詳細
     */
    public function show($id)
    {
        return Facility::find($id);
    }

    /**
     * 設備登録
     */
    public function add($request)
    {
        $path = $this->putImage($request['image']);
        $facility = new Facility();
        $facility->name = $request['name'];
        $facility->image_url = $path;
        $facility->save();
        return $facility;
    }

    /**
     * 設備更新
     */
    public function update($id, $request)
    {
        $facility = $this->show($id);
        if (empty($facility)) {
            return;
        }
        $facility->name = $request['name'];
        $facility->save();
        return $facility;
    }

    /**
     * 設備削除
     */
    public function delete($id)
    {
        $facility = $this->show($id);
        if (empty($facility)) {
            return;
        }
        $facility->deleted_by = auth()->user()->id;
        $result = $facility->delete();
        if (!$result) {
            return;
        }
        Storage::disk('s3')->delete($facility->image_url);
        return $result;
    }

    /**
     * 設備画像登録
     */
    public function putImage(string $image)
    {
        preg_match('/data:image\/(.*);base64,(.*)/u', $image, $matches);
        $ext = $matches[1];
        $path = "facilities/" . uniqid() . ".$ext"; // e.g. facilities/61fb743602fc8.png
        $contents = base64_decode($matches[2]);
        if (!Storage::disk('s3')->put($path, $contents, [
            'visibility' => 'public',
            'mimetype' => $ext === 'svg+xml' ? 'image/svg+xml' : null
        ]));
        return $path;
    }

    /**
     * 設備画像更新
     */
    public function updateImage(int $id, string $image)
    {
        $facility = $this->show($id);
        if (empty($facility)) {
            return;
        }
        Storage::disk('s3')->delete($facility->image_url);
        $facility->image_url = $this->putImage($image);
        $facility->save();
        return $facility;
    }
}
