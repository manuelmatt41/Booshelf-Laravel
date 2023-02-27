<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Author;

class Authors extends Component
{
    use WithPagination;
    
    public $q;

    public $sortBy = 'id';
    public $sortAsc = true;

    public $author;

    public $confirmingAuthorDeletion = false;
    public $confirmingAuthorAdd = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];

    protected $rules = [
        'author.name' => 'required|string|min:1'
    ];

    public function render()
    {
        $authors = Author::where('user_id', auth()->user()->id)
            ->when($this->q, function ($query) {
                return $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        // $query = $genres->toSql();
        $authors = $authors->paginate(10);
        return view('livewire.authors', [
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

    public function confirmAuthorDeletion($id)
    {
        $this->confirmingAuthorDeletion = $id;
    }

    public function deleteAuthor(Author $author)
    {
        $author->delete();
        $this->confirmingAuthorDeletion = false;
    }

    public function confirmAuthorAdd()
    {
        $this->reset(['author']);
        $this->confirmingAuthorAdd = true;
    }


    public function addAuthor()
    {
        $this->validate();
        if (isset($this->author->id)) {
            $this->author->save();            
        } else {
            auth()->user()->authors()->create([
                'name' => $this->author['name']
            ]);
        }
        $this->confirmingAuthorAdd = false;
    }

    public function confirmAuthorEdit(Author $author)
    {
        $this->author = $author;
        $this->confirmingAuthorAdd = true;
    }
}

