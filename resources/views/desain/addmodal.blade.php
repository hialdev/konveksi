<!-- Add New Customer modal -->
<div class="modal fade" id="{{$id}}" tabindex="-1" aria-labelledby="vertical-center-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Tambah Desain
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('desain.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Lampirkan Konsep / Desain Anda</label>
                        <div class="input-group">
                            <span class="input-group-text px-6" id="basic-addon1"><i
                                    class="ti ti-file fs-6"></i></span>
                            <input type="file" name="lampiran" class="form-control bg-white ps-2">
                        </div>
                    </div>
                    <label for="nama" class="form-label">Nama Desain</label>
                    <input type="text" name="nama" class="form-control mb-2" value="{{ old('nama') }}"
                      placeholder="Nama Customer">
                    <label for="keterangan" class="form-label">Keterangan Konsep / Desain</label>
                    <textarea type="text" name="keterangan" class="form-control mb-2"
                      placeholder="Keterangan / Penjelasan konsep desain">{{ old('keterangan') }}</textarea>
                    @role(['admin', 'developer', 'employee'])
                    <div class="my-2">
                        <label class="form-label fw-semibold">Kaitkan Pesanan ke Pelanggan</label>
                        <select name="customer_id" id="customer_id" class="select2 form-select" style="">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach (\App\Models\User::role('pelanggan')->get() as $customer)
                                <option value="{{$customer->id}}" {{$customer->id == old('customer_id') ? 'selected' : ''}}>{{$customer->name .' | '.$customer->email}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endrole
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