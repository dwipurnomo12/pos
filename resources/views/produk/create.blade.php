<div class="modal fade" tabindex="-1" role="dialog" id="modal_tambah_produk">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Produk <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="nm_produk" id="nm_produk">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nm_produk"></div>
                            </div>
                            <div class="form-group">
                                <label>Kategori <span style="color: red">*</span></label>
                                <select class="form-control" name="kategori_id" id="kategori_id">
                                    <option value="" selected>-- Pilih Kategori -- </option>
                                    @foreach ($kategories as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                                    @endforeach
                                </select>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori_id"></div>
                            </div>
                            <div class="form-group">
                                <label>Satuan <span style="color: red">*</span></label>
                                <select class="form-control" name="satuan_id" id="satuan_id">
                                    <option value="" selected> -- Pilih Satuan -- </option>
                                    @foreach ($satuans as $satuan)
                                        <option value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                                    @endforeach
                                </select>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-satuan_id"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Deskripsi <span style="color: red">*</span></label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-deskripsi"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    <button type="button" class="btn btn-primary" id="store">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
