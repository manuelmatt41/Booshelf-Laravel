<div class="p-2 lg:p-8 bg-white border-b border-gray-200">

    <h1 class="mt-4 text-2xl font-medium text-gray-900">
        <div class="mt-4 text-2xl flex justify-between shadow-inner">
            <div>Books</div>
            <div class="mr-2">
                <x-button wire:click="confirmBookAdd" class="bg-green-500 hover:bg-green-800">
                    {{ __('Add') }}
                </x-button>
            </div>
        </div>
        <div class="mt-3">
            <div class="flex justify-between">
                <div>
                    <input wire:model.debounce.500ms="q" type="search" placeholder="Search"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
            </div>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('id')">Isbn</button>
                                <x-sort-icon sortField="id" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('genre_id')">{{ __('Genres') }}</button>
                                <x-sort-icon sortField="genre_id" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('title')">{{ __('Title') }}</button>
                                <x-sort-icon sortField="title" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('author')">{{ __('Author') }}</button>
                                <x-sort-icon sortField="author" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('synopsis')">{{ __('Synopsis') }}</button>
                                <x-sort-icon sortField="synopsis" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('pages')">{{ __('Pages') }}</button>
                                <x-sort-icon sortField="pages" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button>{{ __('Finished') }}</button>
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">{{ __('Action') }}</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td class="rounded border px-4 py-2"> {{ $book->isbn }}</td>
                            <td class="rounded border px-4 py-2"> {{ $genres->find($book->genre_id)->name }}</td>
                            <td class="rounded border px-4 py-2"> {{ $book->title }}</td>
                            <td class="rounded border px-4 py-2"> {{ $book->author }}</td>
                            <td class="rounded border px-4 py-2">
                                {{ \Illuminate\Support\Str::limit($book->synopsis, 10) }}</td>
                            <td class="rounded border px-4 py-2"> {{ $book->pages }}</td>
                            <td class="rounded border px-4 py-2"> {{ $book->finished ? 'Finished' : 'Unfinished' }}
                            </td>
                            <td class="rounded border px-4 py-2">
                                <x-button wire:click="confirmBookEdit ({{ $book->id }})"
                                    class="bg-blue-500 hover:bg-blue-800">
                                    Edit
                                </x-button>
                                <x-danger-button wire:click="confirmBookDeletion ( {{ $book->id }})"
                                    wire:loading.attr="disabled">
                                    {{ __('Remove') }}
                                </x-danger-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $books }}
        </div>
        <x-dialog-modal wire:model="confirmingBookDeletion">
            <x-slot name="title">
                {{ __('Remove') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this book?.') }}
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingBookDeletion', false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="deleteBook ({{ $confirmingBookDeletion }})"
                    wire:loading.attr="disabled">
                    {{ __('Remove') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
        <x-dialog-modal wire:model="confirmingBookAdd">
            <x-slot name="title">
                {{ isset($this->book->isbn) ? 'Edit book' : 'Add book' }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mt-4">
                    <x-label for="name" value="{{ __('Isbn') }}" />
                    <x-input id="book.isbn" type="text" class="mt-1 block w-full" wire:model.defer="book.isbn" />
                    <x-input-error for="book.isbn" class="mt-2" />
                    @if (session('error'))
                        <div class="alert alert-danger text-red-500">{{ __('ISBN already exist') }}</div>
                    @endif
                </div>
                <div class="col-span-6 sm:col-span-4 mt-4">
                    <x-label for="name" value="{{ __('Genre id') }}" />
                    <select name="Genre id" wire:model.defer="book.genre_id">
                        <option value="">--SELECT GENRE--</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="book.genre_id" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4 mt-4">
                    <x-label for="name" value="{{ __('Title') }}" />
                    <x-input id="book.title" type="text" class="mt-1 block w-full" wire:model.defer="book.title" />
                    <x-input-error for="book.title" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4 mt-4">
                    <x-label for="name" value="{{ __('Author') }}" />
                    <x-input id="book.author" type="text" class="mt-1 block w-full"
                        wire:model.defer="book.author" />
                    <x-input-error for="book.author" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4 mt-4">
                    <x-label for="name" value="{{ __('Synopsis') }}" />
                    <x-input id="book.synopsis" type="text" class="mt-1 block w-full"
                        wire:model.defer="book.synopsis" />
                    <x-input-error for="book.synopsis" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4 mt-4">
                    <x-label for="name" value="{{ __('Pages') }}" />
                    <x-input id="book.pages" type="text" class="mt-1 block w-full"
                        wire:model.defer="book.pages" />
                    <x-input-error for="book.pages" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4 mt-4">
                    <input type="checkbox" wire:model.defer="book.finished" name="" />
                    <span class="ml-2 text-sm text-gray-600">Finished</span>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingBookAdd', false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="addBook" wire:loading.attr="disabled">
                    {{ __('Add') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </h1>
</div>
