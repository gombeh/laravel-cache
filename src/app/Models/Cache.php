<?php

namespace App\Models;

use App\Casts\Serialize;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cache extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'expire_at'];

    public $timestamps = false;

    protected array $dates = ['expire_at'];

    protected $primaryKey = 'key';


    protected $casts = [
        'value' => Serialize::class,
    ];
}
