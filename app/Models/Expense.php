<?php
// app/Models/Expense.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'user_id',
        'category',
        'amount',
    ];

    // Relation avec le modèle Profile
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    // Relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
