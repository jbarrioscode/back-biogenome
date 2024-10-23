<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\GeneralSettings\DocumentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;


    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'surName',
        'username',
        'document_type_id',
        'document',
        'phone',
        'address',
        'email',
        'password',
        'status',
        'passwordExpirationDate',
        'user_id',
        'email_verified_at'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function doctype()
    {
        return $this->belongsTo(DocumentType::class);
    }

    protected $with = [
        //'doctypes:id,name,created_at',
        'roles:id,name',
        'roles.permissions:id,name'
    ];

}
