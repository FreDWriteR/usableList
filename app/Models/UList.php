<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UList extends Model
{
    use HasFactory;
    protected $fillable = [
        'good_name',
        'quantity',
        'source_id',
        'laser',
        'welding',
        'assembly',
        'electric'
    ];

    public function uSubLists()
    {
        return $this->hasMany(USubList::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function good_name()
    {
        return $this->belongsTo(GoodName::class);
    }
}
