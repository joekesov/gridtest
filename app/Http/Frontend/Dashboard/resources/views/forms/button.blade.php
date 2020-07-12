
<form action="{{ $actionUrl }}" method="POST">
    @method('POST')
    @csrf


    <div class="columnContainer">
        <div class="item">
            <label for="title">Button Title: </label>

            <input id="title" name="title" type="text" class="@error('title') is-invalid @enderror" value="@if ($model) {{ $model->title }} @endif">

            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="columnContainer">
        <div class="item">
            <label for="link"> URL:</label>

            <input id="link" name="link" type="text" class="@error('link') is-invalid @enderror" value="@if ($model) {{ $model->link }} @endif">

            @error('link')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="columnContainer">
        <div class="item">
            <label for="color_id"> Color:</label>
            <select name="color_id" id="color_id" class="@error('link') is-invalid @enderror">
                <option value="">--- Please select ---</option>
                @foreach ($colorsCollection as $color)
                    <option value="{{ $color->id }}" @if ($model && $model->color && $model->color->id === $color->id) selected @endif> {{ $color->name }} </option>
                @endforeach
            </select>

            @error('color_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>


    <div class="columnContainer">
        <div class="item">
            <input type="submit" value="Submit">
        </div>
    </div>

</form>
