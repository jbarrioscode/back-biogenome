<?php

namespace App\Models\GeneralSettings;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'document_types';
    protected $fillable = [
        'initials',
        'name',
        'description',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
