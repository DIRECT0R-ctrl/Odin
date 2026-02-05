<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Links
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a class="underline" href="{{ route('links.create') }}">+ Add Link</a>
                    </div>

                    @forelse ($links as $link)
                        <div class="border-b py-3">
                            <div class="font-semibold">{{ $link->title }}</div>
                            <div class="text-sm">
                                <a class="underline" href="{{ $link->url }}" target="_blank">{{ $link->url }}</a>
                            </div>
                            <div class="text-sm text-gray-600">
                                Category: {{ $link->category?->name ?? '—' }}
                            </div>

                            <div class="text-sm mt-2">
                                <a class="underline mr-3" href="{{ route('links.edit', $link) }}">Edit</a>

                                <form class="inline" method="POST" action="{{ route('links.destroy', $link) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="underline text-red-600" type="submit"
                                        onclick="return confirm('Delete this link?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>No links yet.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

