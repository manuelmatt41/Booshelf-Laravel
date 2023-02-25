<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Book;
use App\Models\Genre;

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
        'book.isbn' => 'required|int|min:13',
        'book.genre_id' => 'required|int|min:1',
        'book.title' => 'required|string|min:1',
        'book.author' => 'required|string|min:1',
        'book.synopsis' => 'required|string|min:50',
        'book.pages' => 'required|int|min:1',
        'book.finished' => 'boolean'
        ];

    public function render()
    {
        $books = Book::where('user_id', auth()->user()->id)
            ->when($this->q, function ($query) {
                return $query->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->q . '%')
                        ->orWhere('author', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        // $query = $genres->toSql();
        $books = $books->paginate(10);
        $genres = Genre::all();

        return view('livewire.books', [
            'books' => $books,
            'genres' => $genres
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
        if (isset($this->book->isbn)) {
            $this->book->save();
        } else {
            auth()->user()->books()->create([
                'isbn' => $this->book['isbn'],
                'title' => $this->book['title'],
                'author' => $this->book['author'],
                'synopsis' => $this->book['synopsis'],
                'genre_id' => $this->book['genre_id'],
                'pages' => $this->book['pages'],
                'finished' => $this->book['finished']
            ]);
        }
        $this->confirmingBookAdd = false;
    }

    public function confirmBookEdit(Book $book)
    {
        $this->book = $book;
        $this->confirmingBookAdd = true;
    }
}
