<?php

namespace App\Http\Utils;


class UploadHelper
{
    /**
     * @param \Illuminate\Http\UploadedFile $file            File object
     * @param string                        $storagePath     Path to save file
     * @param bool                          $hashName        Use hash of file as file name instead of real name
     *
     * @return array contains information of uploaded file
     */
    public static function uploadFile($file, $storagePath, $hashName = false)
    {
        $fileName = $file->getClientOriginalName();

        if ($hashName) {
            $storeName = $file->hashName();
        } else {
            $storeName = $fileName;
        }

        $realPath = $file->move(public_path($storagePath), $storeName);

        return [
            'pathName' => public_path($storeName) . $storeName,
            'realPath' => $realPath,
            'fileName' => $storeName,
        ];
    }
}