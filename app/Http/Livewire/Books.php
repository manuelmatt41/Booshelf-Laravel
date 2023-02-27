<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;

class Books extends Component
{
    use WithPagination;

    public $q;

    public $sortBy = 'isbn';
    public $sortAsc = true;

    public $book;

    public $confirmingBookDeletion = false;
    public $confirmingBookAdd = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];

    protected $rules = [
        'book.isbn' => 'required|int|min:1000000000000|max:9999999999999',
        'book.genre_id' => 'required|int|min:1',
        'book.title' => 'required|string|min:1',
        'book.author_id' => 'required|int|min:1',
        'book.synopsis' => 'required|string|min:50',
        'book.pages' => 'required|int|min:1',
        'book.finished' => 'boolean'
        ];

    public function render()
    {
        $books = Book::where('user_id', auth()->user()->id)
            ->when($this->q, function ($query) {
                return $query->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        // $query = $genres->toSql();
        $books = $books->paginate(10);
        $genres = Genre::all();
        $authors = Author::all();

        return view('livewire.books', [
            'books' => $books,
            'genres' => $genres,
            'authors' => $authors
        ]);
    }

    public function updatingQ()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function confirmBookDeletion($id)
    {
        $this->confirmingBookDeletion = $id;
    }

    public function deleteBook(Book $book)
    {
        $book->delete();
        $this->confirmingBookDeletion = false;
    }

    public function confirmBookAdd()
    {
        $this->reset(['book']);
        $this->confirmingBookAdd = true;
    }


    public function addBook()
    {
        $this->validate();
        if (isset($this->book->id)) {
            $this->book->save();
        } else {
            try {
                auth()->user()->books()->create([
                    'isbn' => $this->book['isbn'],
                    'title' => $this->book['title'],
                    'author_id' => $this->book['author_id'],
                    'synopsis' => $this->book['synopsis'],
                    'genre_id' => $this->book['genre_id'],
                    'pages' => $this->book['pages'],
                    'finished' => $this->book['finished']
                ]);
            } catch (\Throwable $th) {
                return back()->withError($th->getMessage())->withInput();
            }
        }
        $this->confirmingBookAdd = false;
    }

    public function confirmBookEdit(Book $book)
    {
        $this->book = $book;
        $this->confirmingBookAdd = true;
    }
}
