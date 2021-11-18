<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

trait defaultSaveFiles{

    public function storeFile(Request $request, $path, $name = 'image')
    {

        $imagePath = $request->file($name)->store($path,'public');

        $name = collect(explode('/', $imagePath))->last();

        $image = Image::make(Storage::get($imagePath))->resize(300,300)->encode('jpg');

        Storage::put($imagePath, $image);

        return [
            'name' => $name,
            'imagePath' => $imagePath,
        ];
    }

    public function storeImagesProduct($image)
    {

        $imagePath = $image->store('products','public');

        $name = collect(explode('/', $imagePath))->last();

        $image = Image::make(Storage::get($imagePath))->resize(300,300)->encode('jpg');

        Storage::put($imagePath, $image);

        return [
            'name' => $name,
            'imagePath' => $imagePath,
        ];
    }
}
