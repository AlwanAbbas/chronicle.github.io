<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan container untuk memusatkan tombol -->
    <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
        <!-- Tombol Kelola Notes -->
        <a href="{{ route('notes.index') }}" class="btn btn-success" style="width: 200px; text-align: center;">
            Masuk Ke Chronicle
        </a>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</x-app-layout>