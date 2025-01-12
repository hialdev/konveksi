<!-- Add New Customer modal -->
<div class="modal fade" id="{{$id}}" tabindex="-1" aria-labelledby="vertical-center-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Tambah Pelanggan
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('customer.store') }}" method="POST">
                    @csrf

                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control mb-2" value="{{ old('name') }}"
                      placeholder="Nama Customer">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control mb-2" value="{{ old('email') }}"
                      placeholder="customer@mail.com" required>
                    
                    <div class="d-flex gap-1 align-items-center justify-content-end">
                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start"
                            data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary btn-al-primary">Tambah Pelanggan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>