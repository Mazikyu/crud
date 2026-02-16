<x-layout>
    <x-slot:heading>Create a new Post</x-slot:heading>

    <form method="POST" action="/posts" enctype="multipart/form-data">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <div class="col-span-full">
                        <div class="mt-2 text-left">
                            {{-- Create a new post --}}

                            <x-form-label for="name">Name</x-form-label>

                            <x-form-textarea id="name" name="name" rows="1"></x-form-textarea>

                            {{-- show error message --}}
                            <x-form-error name="name" />
                        </div>


                        <div class="mt-2 text-left">
                            {{-- Create a description --}}
                            <x-form-label for="description">Description</x-form-label>

                            <x-form-textarea id="description" name="description" rows="3"></x-form-textarea>

                            {{-- show error message --}}
                            <x-form-error name="description" />
                        </div>


                        <div class="mt-2 text-left">
                            {{-- Image Upload --}}
                            <x-form-label for="image">Upload an image here</x-form-label>

                            <input type="file" id="image" name="image" accept="image/png, image/jpeg"
                                class="mb-3 border border-black block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                required />

                            {{-- show error message --}}
                            <x-form-error name="image" />
                        </div>

                        <div class="mt-2 text-left">

                            <x-form-label for="status">Status</x-form-label>
                            {{-- Edit Status --}}
                            <select name="status" id="status"
                                class ="border border-black block w-full rounded-md bg-white px-2 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="1">active</option>
                                <option value="0">inactive</option>
                            </select>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            {{-- Cancel redirect to all posts --}}
            <a href="/posts" type="button" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
            <button type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
        </div>
    </form>



</x-layout>
