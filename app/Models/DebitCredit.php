<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitCredit extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'debit_credit';

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
