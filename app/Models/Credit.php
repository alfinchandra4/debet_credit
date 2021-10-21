<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $table = 'credits';

    protected $guarded = [];

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
