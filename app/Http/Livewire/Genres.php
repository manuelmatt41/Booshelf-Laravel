<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Genre;

class Genres extends Component
{
    use WithPagination;

    public function render()
    {
        $genres = Genre::where('user_id', auth()->user()->id);
        $query = $genres->toSql();
        $genres = $genres->paginate(10);

        return view('livewire.genres', [
            'genres' => $genres,
            'query' => $query   
        ]);
    }
}
