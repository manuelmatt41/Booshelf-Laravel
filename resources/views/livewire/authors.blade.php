<div class="p-2 lg:p-8 bg-white border-b border-gray-200">

    <h1 class="mt-4 text-2xl font-medium text-gray-900">
        <div class="mt-4 text-2xl flex justify-between shadow-inner">
            <div>{{ __('Authors') }}</div>
            <div class="mr-2">
                <x-button wire:click="confirmAuthorAdd" class="bg-green-500 hover:bg-green-800">
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
                    @foreach ($authors as $author)
                        <tr>
                            <td class="rounded border px-4 py-2"> {{ $author->id }}</td>
                            <td class="rounded border px-4 py-2"> {{ $author->name }}</td>
                            <td class="rounded border px-4 py-2">
                                <x-button wire:click="confirmAuthorEdit ({{ $author->id }})"
                                    class="bg-blue-500 hover:bg-blue-800">
                                    {{ __('Edit') }}
                                </x-button>
                                <x-danger-button wire:click="confirmAuthorDeletion ( {{ $author->id }})"
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
            {{ $authors }}
        </div>
        <x-dialog-modal wire:model="confirmingAuthorDeletion">
            <x-slot name="title">
                {{ __('Remove') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this author?.') }}
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingAuthorDeletion', false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="deleteAuthor ({{ $confirmingAuthorDeletion }})"
                    wire:loading.attr="disabled">
                    {{ __('Remove') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
        <x-dialog-modal wire:model="confirmingAuthorAdd">
            <x-slot name="title">
                {{ isset($this->author->id) ? __('Edit author') : __('Add author') }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mt-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="author.name" type="text" class="mt-1 block w-full" wire:model.defer="author.name" />
                    <x-input-error for="author.name" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingAuthorAdd', false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="addAuthor" wire:loading.attr="disabled">
                    {{ __('Add') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </h1>
</div>
