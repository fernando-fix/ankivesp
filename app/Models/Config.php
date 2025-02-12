<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'configs';

    protected $fillable = [
        'name',
        'key',
        'value',
    ];

    public static function getByKey($key)
    {
        $config = self::where('key', $key)->first();
        return $config ? $config->value : null;
    }
}
