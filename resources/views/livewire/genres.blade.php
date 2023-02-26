<div class="p-2 lg:p-8 bg-white border-b border-gray-200">

    <h1 class="mt-4 text-2xl font-medium text-gray-900">
        <div class="mt-4 text-2xl flex justify-between shadow-inner">
            <div>{{ __('Genres') }}</div>
            <div class="mr-2">
                <x-button wire:click="confirmGenreAdd" class="bg-green-500 hover:bg-green-800">
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
                                <button wire:click="sortBy('id')">Id</button>
                                <x-sort-icon sortField="id" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('name')">{{ __('Name') }}</button>
                                <x-sort-icon sortField="name" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">{{ __('Action') }}</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($genres as $genre)
                        <tr>
                            <td class="rounded border px-4 py-2"> {{ $genre->id }}</td>
                            <td class="rounded border px-4 py-2"> {{ $genre->name }}</td>
                            <td class="rounded border px-4 py-2">
                                <x-button wire:click="confirmGenreEdit ({{ $genre->id }})"
                                    class="bg-blue-500 hover:bg-blue-800">
                                    Edit
                                </x-button>
                                <x-danger-button wire:click="confirmGenreDeletion ( {{ $genre->id }})"
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
            {{ $genres }}
        </div>
        <x-dialog-modal wire:model="confirmingGenreDeletion">
            <x-slot name="title">
                {{ __('Remove') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this genre?.') }}
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingGenreDeletion', false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="deleteGenre ({{ $confirmingGenreDeletion }})"
                    wire:loading.attr="disabled">
                    {{ __('Remove') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
        <x-dialog-modal wire:model="confirmingGenreAdd">
            <x-slot name="title">
                {{ isset($this->genre->id) ? 'Edit genre' : 'Add genre' }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mt-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="genre.name" type="text" class="mt-1 block w-full" wire:model.defer="genre.name" />
                    <x-input-error for="genre.name" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingGenreAdd', false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="addGenre" wire:loading.attr="disabled">
                    {{ __('Add') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </h1>
</div>
