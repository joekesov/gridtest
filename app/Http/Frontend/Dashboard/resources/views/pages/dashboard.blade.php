<?php
$pageTitle = 'Dashboard';
?>

@extends('layouts.main')

@section('content')
    <div class="container">
        @foreach ($buttons as $button)
            <div class="item">
                <div class="element">
                    <div class="container">
                        <a href="{{ route('button_edit', ['id' => $button->id]) }}" class="btn"><i class="fa fa-edit"></i> Edit</a>
                        <button class="btn"><i class="fa fa-trash"></i> Delete</button>
                    </div>

                    <div class="element">
                        <button class="btn"><i class="fa fa-home"></i> {{ $button->title }}</button>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="item">
            <div class="element">

                <div class="element">
                    <button class="btn"><i class="fa fa-plus"></i> Add button</button>
                </div>
            </div>
        </div>

    </div>
@endsection
