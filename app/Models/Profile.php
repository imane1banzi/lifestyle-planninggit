<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // Laravel par défaut utilise 'id' comme clé primaire, donc pas besoin de l'ajouter
    protected $fillable = ['user_id', 'profile_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
