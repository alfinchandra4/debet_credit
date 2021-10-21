<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    use HasFactory;

    protected $table = 'debits';

    protected $guarded = [];

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
