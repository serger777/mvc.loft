<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = ['id'];

    public static function getByUser($login)
    {
        $files = File::where('login', '=', $login)->get()->toArray();
        return $files;
    }
}