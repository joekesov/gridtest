<?php
$pageTitle = 'Edit button';
$actionUrl = route('button_add', []);
?>

@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
    </div>

    @include('Frontend/Dashboard::forms.button')
@endsection
