<div class="modal fade" tabindex="-1" role="dialog" id="modal_detail_produk">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="produk_id">
                        <div class="col">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Kode Produk</label>
                                    <input type="text" class="form-control" name="kd_produk" id="detail_kd_produk" disabled>
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Nama Produk</label>
                                    <input type="text" class="form-control" name="nm_produk" id="detail_nm_produk" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="detail_harga_beli">Harga Beli</label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                        <input type="text" class="form-control" id="detail_harga_beli" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="detail_harga_jual">Harga Jual</label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                        <input type="text" class="form-control" id="detail_harga_jual" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Kategori</label>
                                    <select class="form-control" name="kategori_id" id="detail_kategori_id" disabled>
                                        @foreach ($kategories as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Satuan</label>
                                    <select class="form-control" name="satuan_id" id="detail_satuan_id" disabled>
                                        @foreach ($satuans as $satuan)
                                            <option value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="detail_deskripsi" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
