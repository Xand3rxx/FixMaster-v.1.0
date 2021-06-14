<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait PageContent
{
    /**
     * include absolute path
     *
     * @param  string  $path
     * 
     * @return Illuminate\Support\Collection
     */
    public static function path(string $path)
    {
        return self::reader($path);
    }

    /**
     * Read
     *
     * @param  string  $path
     * 
     * @return Illuminate\Support\Collection
     */
    protected static function reader(string $path)
    {
        return collect(json_decode(File::get($path), true));
    }
}
