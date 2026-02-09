<x-app-layout>

@if (session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if (session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<h2class="text-xl mb-4">mes categories</h2>

@if(session('success'))
    <div class="text-green-600 mb-3">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('categories.create') }}">

<hr class="my-3">

@foreach ($categories as $category)
    <div class="flex justify-between mb-2">
        {{ $category->name }}

        <div>
            <a href="{{ route('categories.edit', $category) }}">Edit</a>

            <form method="POST"
                    action="{{ route('categories.destroy', $category) }}"
                    style="display:inline">
                @csrf
                @method('DELETE')

                <button type="">DELETE</button>
            </form>
        </div>
    </div>
@endforeach

</x-app-layout>
