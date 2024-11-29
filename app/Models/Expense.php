<?php
// app/Models/Expense.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'amount', 'user_id', 'profile_id'];

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
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
