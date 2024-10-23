@extends('layouts.admin', ['title' => 'Products'])

@section('mainContent')
    <div class="container">
        <div class="products mb-3">

            {{--  --}}
            @foreach ($products as $product)
                <div class="__single">
                    <div class="image">
                        <img class="w-100" src="{{ $product->image }}" alt="">
                    </div>
                    <div>
                        <h2>{{ $product->title }}</h2>
                        <div>
                            <p class="fw-bold m-0">Categories:</p>
                            <div>
                                <span class="badge bg-info text-capitalize">{{ $product->category }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="fw-bold m-0">Features:</p>
                            <ul>
                                @foreach ($product->features as $feature)
                                    <li class="text-capitalize">{{ $feature->title }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <a onclick="openEditModal({{ $product->id }}, '{{ $product->title }}', '{{ $product->category }}', '{{ $product->image }}')" class="btn btn-success">Edit</a>
                        </div>
                    </div>

                </div>
            @endforeach
            {{--  --}}
        </div>

        <nav aria-label="Page navigation example mt-2">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editProductForm">
                    <div class="modal-body">
                        <input type="hidden" id="editProductId">
                        <div class="mb-3">
                            <label for="editProductTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editProductTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductCategory" class="form-label">Category</label>
                            <input type="text" class="form-control" id="editProductCategory" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductImage" class="form-label">Image</label>
                            <input type="file" class="form-control" id="editProductImage">
                        </div>
                        <img id="previewImage" class="w-100 mb-3" src="" alt="Product Image">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // $("#imgSrc").attr('src', "https://ui-avatars.com/api/?background=random&color=fff&name={{ auth()->user()->name }}")

        // Function to open edit modal and set existing data
        function openEditModal(id, title, category, image) {
            $('#editProductId').val(id);
            $('#editProductTitle').val(title);
            $('#editProductCategory').val(category);
            $('#previewImage').attr('src', image);
            $('#editModal').modal('show');
        }

        // Handle form submission with jQuery AJAX
        $('#editProductForm').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData();
            formData.append('id', $('#editProductId').val());
            formData.append('title', $('#editProductTitle').val());
            formData.append('category', $('#editProductCategory').val());
            if ($('#editProductImage')[0].files[0]) {
                formData.append('image', $('#editProductImage')[0].files[0]);
            }

            $.ajax({
                url: '{{ route("products.update", ":id") }}'.replace(':id', $('#editProductId').val()),
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function (response) {
                    location.reload();
                },
                error: function (xhr) {
                    alert('An error occurred while updating the product.');
                }
            });
        });

    </script>
@endsection
