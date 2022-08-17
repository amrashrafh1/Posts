<?php

use App\Models\User;
use Illuminate\Support\Facades\Storage;

if(! function_exists('upload_files')) {
    function upload_file($file, $path, $model)
    {
        if (request()->isMethod('PATCH')) {
            if ($model->files) {
                foreach($model->files as $file) {
                    Storage::disk('public')->delete($file->path);
                }
            }
        }
        if(is_array($file)) {
            foreach($file as $index => $f) {
            $file_name =  time()  .'-'. $index;
            $model->files()->create([
                'name' => $file_name,
                'path' => $path . '/' . $file_name,
            ]);
            Storage::disk('public')->putFileAs($path, $f, $file_name);
        }
        } else {
            $file_name =  time();
            $model->files()->create([
                'name' => $file_name,
                'path' => $path . '/' . $file_name,
            ]);
            Storage::disk('public')->putFileAs($path, $file, $file_name);
        }
    }
}


if(! function_exists('upload_cover')) {
    function upload_cover($file, $path)
    {
        $file_name =  time();
        Storage::disk('public')->putFileAs($path, $file, $file_name);
        return $path . '/' . $file_name;
    }
}