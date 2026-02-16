<div class="flex items-center">
    <a href="/posts/{{ $post->slug }}"
        class="mr-3 rounded-md bg-indigo-600 px-2 py-1.5 text-sm font-semibold text-white hover:bg-indigo-500">
        view
    </a>

    <a href="/posts/{{ $post->slug }}/edit"
        class="mr-3 rounded-md border-2 border-indigo-600 px-2 py-1.5 text-sm font-semibold text-indigo-600 hover:border-indigo-500 hover:text-indigo-500">
        edit
    </a>

    <button type="button"
        class="btn-delete rounded-md bg-red-600 px-2 py-1.5 text-sm font-semibold text-white hover:bg-red-500"
        data-url="{{ route('posts.destroy', $post->slug) }}">
        delete
    </button>
</div>
