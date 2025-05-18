@extends('layouts.app')

@section('main')
    <main>
        <x-app.header-home />
        {{ $slot }}
        <x-app.footer />
    </main>
@endsection
