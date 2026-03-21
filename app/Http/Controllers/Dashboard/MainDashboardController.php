<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BooksBorrowReturn;

class MainDashboardController extends Controller
{
    public function getInfoCardsData(Request $request)
    {
        try {
            $data = [
                'total_books' => $this->getTotalBooks(),
                'books_outside' => $this->get_books_outside(date('Y-m-d'), date('Y-m-d')),
                'books_total_returns' => $this->get_books_total_returns(date('Y-m-d'), date('Y-m-d')),
                'books_total_returns_expected' => $this->get_books_total_returns_expected(date('Y-m-d'), date('Y-m-d')),
            ];
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data process failed.',
                'error' => $e->getMessage()
            ], 500);
        }
        return response()->json(['status' => 'success', 'cards' => $data], 200);
    }

    protected function getTotalBooks()
    {
        return (string) Book::where('is_deleted', '0')->count('id');
    }

    /**
     * start_date = null; means minimum date from the table
     * end_date = null; means maximum date from the table
     * @param string|null $start_date Y-m-d
     * @param string|null $end_date Y-m-d
     * @return string
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    protected function get_books_outside(string|null $start_date = null, string|null $end_date = null)
    {
        $query = BooksBorrowReturn::query();

        if ($start_date && $end_date) {
            $query->whereBetween('borrowed_date', [$start_date, $end_date]);
        } elseif ($start_date) {
            $query->whereBetween('borrowed_date', [$start_date, BooksBorrowReturn::max('borrowed_date')]);
        } elseif ($end_date) {
            $query->whereBetween('borrowed_date', [BooksBorrowReturn::min('borrowed_date'), $end_date]);
        }

        return (string) $query->whereNull('returned_date')->count('id');

    }

    /**
     * start_date = null; means minimum date from the table
     * end_date = null; means maximum date from the table
     * @param string|null $start_date Y-m-d
     * @param string|null $end_date Y-m-d
     * @return string
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    protected function get_books_total_returns(string|null $start_date = null, string|null $end_date = null)
    {
        $query = BooksBorrowReturn::query();

        if ($start_date && $end_date) {
            $query->whereBetween('returned_date', [$start_date, $end_date]);
        } elseif ($start_date) {
            $query->whereBetween('returned_date', [$start_date, BooksBorrowReturn::max('returned_date')]);
        } elseif ($end_date) {
            $query->whereBetween('returned_date', [BooksBorrowReturn::min('returned_date'), $end_date]);
        }

        return (string) $query->whereNotNull('returned_date')->count('id');
    }

    /**
     * start_date = null; means minimum date from the table
     * end_date = null; means maximum date from the table
     * @param string|null $start_date Y-m-d
     * @param string|null $end_date Y-m-d
     * @return string
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    protected function get_books_total_returns_expected(string|null $start_date = null, string|null $end_date = null)
    {
        $query = BooksBorrowReturn::query();

        if ($start_date && $end_date) {
            $query->whereBetween('return_promised_date', [$start_date, $end_date]);
        } elseif ($start_date) {
            $query->whereBetween('return_promised_date', [$start_date, BooksBorrowReturn::max('return_promised_date')]);
        } elseif ($end_date) {
            $query->whereBetween('return_promised_date', [BooksBorrowReturn::min('return_promised_date'), $end_date]);
        }

        return (string) $query->count('id');

    }

}
