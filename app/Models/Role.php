<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    protected $fillable = [
        'name', // Ajoutez d'autres colonnes si nécessaire
    ];

    // Si vous n'avez pas besoin de timestamps (created_at et updated_at)
    public $timestamps = false;

    // Relation avec les utilisateurs
    public function users()
    {
        return $this->hasMany(User::class);
    }
}