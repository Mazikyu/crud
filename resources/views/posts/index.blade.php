<x-layout>
    @section('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css">

        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css"> --}}
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css"> --}}
    @endsection

    <x-slot:heading>Posts</x-slot:heading>

    <div class="table-responsive mt-9 relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base">
        <table id="data-table" class="display cell-border w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Image
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Control
                    </th>
                </tr>
                {{-- <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr> --}}
            </thead>
            <tbody>
                {{-- @foreach ($posts as $post)
                    <tr class="bg-neutral-primary border-b border-default">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $post->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ !empty($post->name) ? $post->name : '' }}
                        </td>
                        <td class="px-6 py-4">

                            {{ Str::limit($post->description, 20, '...') }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" width="50">
                            @endif
                        </td>
                        <td class="px-6 py-4">

                            {{ $post->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold {{ $post->status ? 'text-green-600' : 'text-red-600' }}">
                                {{ $post->status ? 'active' : 'inactive' }}
                            </div>

                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">

                                <a href="/posts/{{ $post->slug }}"
                                    class="mr-3 rounded-md bg-indigo-600 px-2 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">view</a>


                                <a href="/posts/{{ $post->slug }}/edit"
                                    class="mr-3 rounded-md border-2 border-indigo-600 bg-white-600 px-2 py-1.5 text-sm font-semibold text-indigo-600 shadow-xs hover:border-indigo-500 hover:text-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">edit</a>



                                <form method="POST" action="/posts/{{ $post->slug }}">
                                    @csrf
                                    @method('DELETE')

                                    <x-delete-confirmation></x-delete-confirmation>

                                </form>

                            </div>


                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
    <x-delete-confirmation />
    <x-modal-confirmation />

    @section('javascripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>

        <!-- Required for Excel -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

        {{-- responsive design --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script> --}}
        {{-- <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script> --}}
        {{-- <script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script> --}}


        <script>
            $(document).ready(function() {

                // need this otherwise get 419 error
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // --
                // DELETE LOGIC
                // --
                let deleteUrl = null;

                // Open delete-confirmation html, when clicking button with class btn-delete
                $('#data-table').on('click', '.btn-delete', function() {
                    deleteUrl = $(this).data('url');
                    $('#delete-confirmation').removeClass('hidden').addClass('flex');
                });

                // Cancel
                $('#delete_cancel').on('click', function() {
                    closeDeleteModal();
                });

                // Confirm delete
                $('#delete_confirm').on('click', function() {
                    if (!deleteUrl) return;

                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        success: function(res) {
                            // if (res.status === 'success') {
                            $('#data-table').DataTable().ajax.reload(null, false);
                            closeDeleteModal();
                            showSuccessMessage(res.message);
                            deleteUrl = null;
                            // }
                        },
                        error: function() {
                            alert('Something went wrong.');
                        }
                    });
                });

                // Close Modal view
                function closeDeleteModal() {
                    // deleteUrl = null;
                    $('#delete-confirmation').addClass('hidden').removeClass('flex');
                }


                // --
                // STATUS UPDATE LOGIC
                // --
                let updateUrl = null;

                // Open status-confirmation html
                $('#data-table').on('click', '.btn-status', function() {
                    updateUrl = $(this).data('url');
                    $('#modal-confirmation').removeClass('hidden').addClass('flex');
                });

                // Cancel
                $('#status_cancel').on('click', function() {
                    closeStatusModal();
                });

                // Confirm Status
                $('#status_confirm').on('click', function() {
                    if (!updateUrl) return;

                    $.ajax({
                        url: updateUrl,
                        type: 'PATCH',

                        success: function(res) {
                            $('#data-table').DataTable().ajax.reload(null, false)
                            closeStatusModal()
                            showSuccessMessage(res.message)
                            updateUrl = null

                        },
                        error: function() {
                            alert('Something went wrong.');
                        }
                    });
                });


                // Close Modal view
                function closeStatusModal() {
                    updateUrl = null;
                    $('#modal-confirmation').addClass('hidden').removeClass('flex');
                }


            });
        </script>
    @endsection

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

</x-layout>
