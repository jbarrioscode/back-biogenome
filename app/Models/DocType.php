<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocType extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'description',
      'status',
      'user_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
