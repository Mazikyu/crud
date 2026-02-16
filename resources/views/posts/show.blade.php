<x-layout>
    <x-slot:heading>{{ $post->name }}</x-slot:heading>

    <p class="my-5">{{ $post->description }}</p>
    <div class="mt-5 mb-16 flex justify-center">
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" width="400">
        @endif

    </div>

    <a href="/posts"
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
    {{-- <a href="/posts/{{ $post->slug }}/edit" class="text-indigo-600 font-semibold">Edit</a> --}}

</x-layout>
