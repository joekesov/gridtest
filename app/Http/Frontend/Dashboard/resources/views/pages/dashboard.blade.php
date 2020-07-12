<?php
use App\Domain\Button\Enum\ButtonEnum;

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
                        <a href="{{ route('button_delete', ['id' => $button->id]) }}" class="btn"><i class="fa fa-trash"></i> Delete</a>
                    </div>

                    <div class="element">
                        <button class="btn" onclick="location.href='{{ $button->link }}';" style="background-color: {{ sprintf('#%s', $button->color->hex_code) }};"><i class="fa fa-home"></i> {{ $button->title }}</button>
                    </div>
                </div>
            </div>
        @endforeach

    @if (ButtonEnum::MAX_ALLOWED_BUTTONS > count($buttons))
    <div class="item">
        <div class="element">

            <div class="element">
                <a href="{{ route('button_add') }}" class="btn"><i class="fa fa-plus"></i> Add button</a>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
