@extends('layouts.dashboard')

@section('content')
    <div>
        <h1>Test Livewire</h1>
        @livewire('dokumen-upload', [
            'pendaftaran' => auth()->user()->pendaftaran,
            'persyaratan' => \App\Models\Persyaratan::first(),
        ])
    </div>
@endsection
