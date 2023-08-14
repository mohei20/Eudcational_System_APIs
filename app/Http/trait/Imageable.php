<?php

namespace  App\Http\trait;

use Carbon\Carbon;

trait Imageable
{
    public function insertImage($title, $image, $dir)
    {
        if ($image === null) {
            return null;
        }
        $newImage  = $title . '_' . date('Y-m-d') . '.' . $image->getClientOriginalExtension();
        $image->move(public_path($dir), $newImage);
        return $newImage;
    }
}
