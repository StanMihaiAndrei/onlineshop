@extends('layouts.app')

@section('title', 'Hello Tailwind')

@section('content')
    <div class="bg-violet-500 text-green-500 p-4">
        Tailwind funcționează!
    </div>

    <div class="mt-4">
        <livewire:counter />
    </div>

    <div x-data="{ open: false }" class="mt-4">
        <button @click="open = !open" class="bg-green-500 text-white px-4 py-2 rounded">
            Toggle Alpine
        </button>
        <div x-show="open" class="mt-2 p-2 bg-green-100 text-green-900 rounded">
            Alpine.js funcționează!
        </div>
    </div>
@endsection