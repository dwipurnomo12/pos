<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_operasional">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Biaya Operasional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="operasional_id">
                        <div class="col">
                            <div class="form-group">
                                <label>Operasional <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="operasional" id="edit_operasional">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-operasional"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Biaya <span style="color: red">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">
                                            Rp
                                          </div>
                                        </div>
                                        <input type="number" class="form-control" name="biaya" id="edit_biaya">                                        
                                    </div>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-biaya"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Rentang Bayar <span style="color: red">*</span></label>
                                    <select class="form-control" name="rentang_id" id="edit_rentang_id">
                                        @foreach ($rentangs as $rentang)
                                            <option value="{{ $rentang->id }}">{{ $rentang->rentang_bayar }}</option>
                                        @endforeach
                                    </select>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-edit_rentang_id"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    <button type="button" class="btn btn-primary" id="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
