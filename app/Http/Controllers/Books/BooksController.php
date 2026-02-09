<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BooksController extends Controller
{
    public function viewBooksDashboard()
    {
        $categories = Category::get(['id', 'category_name']);
        return view('books.main-list', compact('categories'));
    }
    public function BooksDashboardDataHandler_AJAX(Request $request)
    {
        $query = Book::with('categories');

        // Apply custom filters BEFORE DataTables takes over
        if ($request->filled('include_categories')) {
            $query->whereHas(
                'categories',
                fn($cat) =>
                $cat->whereIn('id', $request->input('include_categories'))
            );
        }

        if ($request->filled('exclude_categories')) {
            $query->whereDoesntHave(
                'categories',
                fn($cat) =>
                $cat->whereIn('id', $request->input('exclude_categories'))
            );
        }

        return DataTables::of($query)
            ->addColumn(
                'categories',
                fn($book) =>
                $book->categories->pluck('category_name')->join(', ')
            )
            ->make(true);
    }

    public function viewEditBook(string $book_id)
    {
        // $categories = Category::get(['id', 'category_name']);
        $book = Book::where('book_id', $book_id)->firstOrFail();
        return view('books.edit-book', compact('book'));
    }


    /**
     * create a new book record
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function createNewBook(Request $request)
    {
        // validate data
        $validate = $this->ValidateData($request);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'validateFail',
                'message' => 'Data Validate Failed!',
                'errorBag' => $validate->errors()
            ], 422);
        }
        // store in db except the filepath
        try {
            $book = Book::create($request->only([
                'book_title',
                'book_author',
                'book_added',
                'book_remarks'
            ]));
            // sync book categories
            if ($request->has('book_categories')) {
                $book->categories()->sync($request->input('book_categories'));
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }

        // handle file upload
        if ($request->hasFile('book_cover_img')) {
            try {
                $file = $request->file('book_cover_img');
                $extension = $file->getClientOriginalExtension();

                // build path using book_id
                $filepath = (string) 'books/' . $book->book_id . '.' . $extension;

                // store file in storage/app/public/books
                $file->storeAs('books', $book->book_id . '.' . $extension, 'public');

                // update book record with filepath
                $book->update([
                    'book_cover_img' => $filepath
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File upload failed.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Store Success!',
            'book' => $book->toArray(),
            'redirect' => route('books-view-book', (string) $book->book_id)
        ], 200);
    }

    public function saveEditBook(Request $request, string $book_id)
    {
        $book = Book::where('book_id', $book_id)->firstOrFail();

        // Validate input including categories
        $validate = $this->ValidateData($request, $book->id);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'validateFail',
                'message' => 'Data Validate Failed!',
                'errorBag' => $validate->errors()
            ], 422);
        }

        // Update basic fields
        $book->book_title = $request->get('book_title');
        $book->book_author = $request->get('book_author');
        $book->book_added = $request->get('book_added');
        $book->book_remarks = $request->get('book_remarks', null);

        // Handle cover image replacement
        if ($request->hasFile('book_cover_img')) {
            try {
                if ($book->book_cover_img && Storage::disk('public')->exists($book->book_cover_img)) {
                    Storage::disk('public')->delete($book->book_cover_img);
                }

                $extension = $request->file('book_cover_img')->getClientOriginalExtension();
                $path = $request->file('book_cover_img')
                    ->storeAs('books', $book->book_id . '.' . $extension, 'public');

                $book->book_cover_img = $path;
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File upload failed.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        $book->save();

        // Sync categories (pivot table)
        $book->categories()->sync($request->get('book_categories', []));
        if ($request->filled('categories')) {
        } else {
            // If no categories selected, detach all
            // $book->categories()->detach();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Book updated successfully!',
            // 'redirect' => route('books.index')
        ], 200);

    }


    public function deleteBook(Request $request)
    {
        try {
            $book = Book::where('book_id', $request->get('book_id'))->firstOrFail();

            // Delete file if exists
            if ($book->book_cover_img) {
                try {
                    if (Storage::disk('public')->exists($book->book_cover_img)) {
                        Storage::disk('public')->delete($book->book_cover_img);
                    }
                } catch (\Exception $e) {
                    // Log::error("Failed to delete cover image for book {$book->book_id}: " . $e->getMessage());
                    return response()->json([
                        'status' => 'error',
                        'message' => 'File delete failed.',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }

            $book->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Book deleted successfully.'
            ]);
        } catch (\Exception $e) {
            // Log::error("Unexpected error deleting book: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * view book information, detailed
     * @param string $book_id
     * @return \Illuminate\Contracts\View\View
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function viewBook(string $book_id)
    {
        // todo: create book borrow-return history part
        $book = Book::where('book_id', $book_id)->firstOrFail();
        return view('books.view-book', compact('book'));
    }

    /**
     * handle data validation for this class
     * @param Request $request
     * @param int|bool $id
     * @param array $rules
     * @param array $attributes
     * @return \Illuminate\Validation\Validator
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    private function ValidateData(Request $request, int|bool $id = false, array $rules = [], array $attributes = [])
    {
        $rules = [
            'book_cover_img' => [
                'nullable',
                File::image()->max('2mb'),
            ],
            'book_title' => [
                'string',
                'required',
                'min:4',
                'max:200',
                $id !== false
                ? Rule::unique('books', 'book_title')->ignore($id, 'id') // update mode
                : Rule::unique('books', 'book_title'), // create mode
            ],
            'book_author' => [
                'string',
                'required',
                'min:4',
                'max:200',
            ],
            'book_categories' => ['required', 'array', 'min:1'],
            'book_categories.*' => Rule::exists('categories', 'id'),
            'book_added' => [
                'date',
                'required',
            ],
            'book_remarks' => [
                'string',
                'nullable',
                'max:200',
            ],
            ...$rules,
        ];

        $attributes = [
            'book_cover_img' => 'Book Cover Image',
            'book_title' => 'Book Title',
            'book_author' => 'Book Author',
            'book_categories' => 'Book Categories',
            'book_added' => 'Book Added',
            'book_remarks' => 'Book Remarks',
            ...$attributes,
        ];

        return validator::make($request->all(), $rules, [], $attributes);
    }

}
