<x-app-layout>

<h2>Create Category</h2>

<form method="POST" action="{{ route('categories.store') }}">
@csrf

<input name="name" placeholder="Name">

@error('name')
<p style="color:red">{{ $message }}</p>
@enderror

<button>Add</button>

</form>

</x-app-layout>

