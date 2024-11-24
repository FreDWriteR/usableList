<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class USubList extends Model
{
    use HasFactory;

    protected $fillable = [
        'u_list_id',
        'good_name',
        'quantity',
        'source_id',
        'laser'
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function good_name()
    {
        return $this->belongsTo(GoodName::class);
    }
}
