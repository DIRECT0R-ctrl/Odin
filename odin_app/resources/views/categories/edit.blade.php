<x-app-layout>

<h2>Edit Category</h2>

<form method="POST" action="{{ route('categories.update',$category) }}">
@csrf
@method('PUT')

<input name="name" value="{{ $category->name }}">

@error('name')
<p style="color:red">{{ $message }}</p>
@enderror

<button>Save</button>

</form>

</x-app-layout>

