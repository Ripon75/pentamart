<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Image;

class ImageConveter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = Storage::files('images/products/2023/convert');

        foreach ($files as $path) {
            $fileName = pathinfo($path, PATHINFO_FILENAME);
            // $ext = pathinfo($path, PATHINFO_EXTENSION);
            $this->command->info('- File Converting: '.$fileName);
            $saveFilePath = "images/products/2023/convert/new/${fileName}.jpg";

            $res = $this->resizeAndSaveImage($path, $saveFilePath);
            $this->command->info('File Converted Successfully: '.$res);
        }
    }

    public function resizeAndSaveImage($path, $saveFilePath, $size = 1024, $ext = "jpg", $quality = 80)
    {
        $storepath = Storage::path($path);
        $img = Image::make($storepath);
        $img->resize($size, $size);
        $watermarkImgPath = public_path('images/logos/watermark.png');
        // and insert a watermark for example
        $img->insert($watermarkImgPath, 'center');

        $pathParts = pathinfo($path);
        $spath = Storage::path($saveFilePath);

        $img->save($spath, $quality, $ext);

        return $saveFilePath;
    }
}
