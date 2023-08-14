<?php

namespace  App\Http\trait;

use Carbon\Carbon;

trait Fileable
{
    public function uploadFile($name, $file, $dir)
    {
        $newFile  = $name . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($dir), $newFile);
        return $newFile;
    }
}
