<h1>Add Link</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('links.store') }}">
    @csrf

    <div>
        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title') }}">
    </div>

    <div>
        <label>URL</label><br>
        <input type="text" name="url" value="{{ old('url') }}">
    </div>

    <div>
        <label>Category</label><br>
        <select name="category_id">
            <option value="">-- choose --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit">Save</button>
</form>

<p><a href="{{ route('links.index') }}">Back to links</a></p>

