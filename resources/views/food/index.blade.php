<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Food') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <x-jet-button class="mb-6 bg-yellow-400">Tambah</x-jet-button>
            <div class="mb-4 flex justify-between">
                <div>
                    <!-- <x-jet-label for="limit" value="{{ __('Per page') }}" /> -->
                    <select class="border-gray-300 focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="all">all</option>
                    </select>
                </div>
                <div class="w-1/4">
                    <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="search by name" required />
                </div>
            </div>

                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-yellow-200">
                            <th class="border border-yellow-400 px-4 py-2">Food</th>
                            <th class="border border-yellow-400 px-4 py-2">Ingredients</th>
                            <th class="border border-yellow-400 px-4 py-2">Price</th>
                            <th class="border border-yellow-400 px-4 py-2">Rate</th>
                            <th class="border border-yellow-400 px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($foods as $food)
                        <tr>
                            <td class="border border-yellow-400 px-4 py-2">{{ $food->name }}</td>
                            <td class="border border-yellow-400 px-4 py-2">{{ $food->ingredients }}</td>
                            <td class="border border-yellow-400 px-4 py-2 text-center">{{ $food->price }}</td>
                            <td class="border border-yellow-400 px-4 py-2 text-center">{{ $food->rate }}</td>
                            <td class="border border-yellow-400 px-4 py-2 text-center">
                                <x-jet-secondary-button>Edit</x-jet-secondary-button>
                                <x-jet-secondary-button class="border-red-500 text-red-500">Delete</x-jet-secondary-button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pt-3">
                    {{ $foods->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-jet-dialog-modal>
        <x-slot name="title">
            Form Food
        </x-slot>
        <x-slot name="content">
            Content Form Food
        </x-slot>
        <x-slot name="footer">
            Footer Form Food
        </x-slot>
    </x-jet-dialog-modal>
</x-app-layout>