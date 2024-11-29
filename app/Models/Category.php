<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_required', 'is_active'];

    public function items()
    {
        return $this->hasMany(CategoryItem::class);
    }

    // Calculer le total des montants des items associés
    public function getTotalCostAttribute()
    {
        return $this->items->sum('monthly_cost'); // Somme des coûts mensuels
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}

