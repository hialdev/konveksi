<!-- Add New Product Category modal -->
<div class="modal fade" id="{{$id}}" tabindex="-1" aria-labelledby="vertical-center-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Tambah Kategori Produk
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('product.category.store') }}" method="POST">
                    @csrf

                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" name="category_name" class="form-control mb-2" value="{{ old('category_name') }}"
                      placeholder="Nama Category" required>
                    
                    <div class="d-flex gap-1 align-items-center justify-content-end">
                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start"
                            data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary btn-al-primary">Tambah Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>