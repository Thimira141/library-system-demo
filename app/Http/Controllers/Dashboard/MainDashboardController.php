<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class MainDashboardController extends Controller
{
    public function getInfoCardsData(Request $request)
    {
        // code
    }

    protected function getTotalBooks()
    {
        return (string) Book::count('id');
    }

    protected function get_books_outside(Date|null $start_date = null, Date|null $end_date = null)
    {
        // code
        // note: start_date = null; means minimum date from the system
        // note: end_date = null; means maximum date from the system
    }

    protected function get_books_total_returns(Date|null $start_date = null, Date|null $end_date = null)
    {
        // code
    }

    protected function get_books_total_returns_expected(Date|null $start_date = null, Date|null $end_date = null)
    {
        // code
    }

}
