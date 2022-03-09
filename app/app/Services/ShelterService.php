<?php

namespace App\Services;

use App\Models\Shelter;
use App\Models\ShelterImage;
use Illuminate\Support\Facades\Storage;

class ShelterService
{
    /**
     * 避難所一覧
     */
    public function find()
    {
        $query = Shelter::select('*');
        return $query->get();
    }

    /**
     * 避難所詳細
     */
    public function show($id)
    {
        return Shelter::find($id);
    }

    /**
     * 避難所登録
     */
    public function add($request)
    {
        $shelter = new Shelter($request);
        $shelter->save();
        return $shelter;
    }

    /**
     * 避難所更新
     */
    public function update($request, $id)
    {
        $shelter = $this->show($id);
        if (empty($shelter)) {
            return;
        }
        $shelter->fill($request);
        $shelter->save();
        return $shelter;
    }

    /**
     * 避難所削除
     */
    public function delete($id)
    {
        $shelter = $this->show($id);
        if (empty($shelter)) {
            return;
        }
        $shelter->deleted_by = auth()->user()->id;
        $result = $shelter->delete();
        if (!$result) {
            return;
        }
        $shelter->shelterImages()->delete();
        Storage::disk('s3')->deleteDirectory("shelters/$id");
        return $result;
    }

    /**
     * 避難所画像詳細
     */
    public function showImage($id, $image_id)
    {
        return ShelterImage::find($image_id)->where('shelter_id', $id)->first();
    }

    /**
     * 避難所画像登録
     */
    public function addImage(int $id, string $image)
    {
        $shelter = $this->show($id);
        if (!$shelter) {
            return false;
        }
        preg_match('/data:image\/(\w+);base64,(.*)/u', $image, $matches);
        $path = "shelters/$id/" . uniqid() . ".$matches[1]"; // e.g. shelters/12345/61fb743602fc8.jpeg
        $contents = base64_decode($matches[2]);
        if (!Storage::disk('s3')->put($path, $contents, 'private')) {
            return false;
        }
        $shelter_image = new ShelterImage();
        $shelter_image->image_url = $path;
        $shelter->shelterImages()->save($shelter_image);
        return $shelter;
    }

    /**
     * 避難所画像一括登録
     */
    public function addImages(int $id, array $images)
    {
        $results = collect($images)
            ->map(fn ($image) => $this->addImage($id, $image))
            ->toArray();
        return !in_array(false, $results, true);
    }

    /**
     * 避難所画像削除
     */
    public function deleteImage(int $id, int $image_id)
    {
        $shelter_image = $this->showImage($id, $image_id);
        if (!$shelter_image) {
            return false;
        }
        if (!$shelter_image->delete()) {
            return false;
        }
        Storage::disk('s3')->delete($shelter_image->image_url);
        return true;
    }
}
