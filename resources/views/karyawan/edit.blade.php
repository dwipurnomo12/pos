<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_karyawan">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Karyawan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
          <div class="modal-body">

            <input type="hidden" id="karyawan_id">
            <div class="form-group">
                <label>Nama <span style="color: red">*</span></label>
                <input type="text" class="form-control" name="name" id="edit_name">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name"></div>
            </div>
            <div class="form-group">
                <label>Email <span style="color: red">*</span></label>
                <input type="text" class="form-control" name="email" id="edit_email">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email"></div>
            </div>
            <div class="form-group">
                <label>Password <span style="color: red">(Kosongi form jika tidak ingin mengubah password)</span></label>
                <input type="password" class="form-control" name="password" id="edit_password">
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-password"></div>
            </div>
            <div class="form-group">
                <label>Pilih Role <span style="color: red">*</span></label>
                <select class="form-control" name="role" id="edit_role_id" style="width: 100%">
                <option selected>Pilih Role</option>
                    @foreach ($roles as $role)
                      <option value="{{ $role->id }}">{{ $role->role }}</option>
                    @endforeach
                </select>
                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-role_id"></div>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button type="button" class="btn btn-primary" id="update">Tambah</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>