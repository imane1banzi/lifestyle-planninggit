<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class LifestyleController extends Controller
{
    public function calculateHourlyRate(Request $request)
    {
        $totalExpenses = $request->input('total_expenses');
        $workingHoursPerYear = $request->input('working_hours_per_year');
        $hourlyRate = $totalExpenses / $workingHoursPerYear;

        $recommendations = Recommendation::where('hourly_rate', '<=', $hourlyRate)->get();
        return view('dashboard', compact('hourlyRate', 'recommendations'));
    }
}
