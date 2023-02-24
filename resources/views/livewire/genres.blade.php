<div class="p-2 lg:p-8 bg-white border-b border-gray-200">

    <h1 class="mt-4 text-2xl font-medium text-gray-900">
        <div>Genres</div>
        {{ $query }}
        <div class="mt-3">
            <div class="flex justify-between">
                <div>
                    <input wire:model="q" type="search" placeholder="Search" class="shadow" />
                </div>
            </div>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">
                            <div class="flex items-center">Id</div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">Name</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($genres as $genre)
                        <tr>
                            <td class="rounded border px-4 py-2"> {{ $genre->id }}</td>
                            <td class="rounded border px-4 py-2"> {{ $genre->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $genres }}
        </div>
    </h1>
</div>