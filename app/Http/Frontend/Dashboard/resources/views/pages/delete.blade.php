<form action="{{ route('button_delete', ['id' => $model->id]) }}" method="POST">
@method('DELETE')
@csrf

    <div class="columnContainer">
        <div class="item">
            Are you sure you want to delete this button?
        </div>
    </div>

    <div class="columnContainer">
        <div class="item">
            <input type="submit" value="Submit">
            <a href="{{ route('dashboard') }}">Cancel</a>
        </div>
    </div>
</form>
