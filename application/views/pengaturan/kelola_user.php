<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><?= $title ?></h3>
        <button class="btn btn-primary" onclick="openAddUser()"><i class="fa-solid fa-user-plus"></i> Tambah Pengguna</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role Akses</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($users)): ?>
                        <tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>
                    <?php else: ?>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td><strong><?= $u->nama ?></strong></td>
                            <td><?= $u->email ?></td>
                            <td><span class="badge badge-info" style="background:#17a2b8; color:#fff;"><?= $u->role_name ?></span></td>
                            <td>
                                <?php if($u->is_active): ?>
                                    <span class="text-success"><i class="fa-solid fa-check-circle"></i> Aktif</span>
                                <?php else: ?>
                                    <span class="text-danger"><i class="fa-solid fa-times-circle"></i> Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick='openEditUser(<?= json_encode($u) ?>)' title="Edit"><i class="fa-solid fa-edit"></i> Edit</button>
                                <?php if($u->id != 1 && $u->id != $this->session->userdata('user_id')): ?>
                                <form action="<?= base_url('kelola_user/hapus/'.$u->id) ?>" method="post" class="form-confirm" style="display:inline;">
                                    <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form User -->
<div id="modalUserForm" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Pengguna</h3>
            <span class="close" onclick="closeModal('modalUserForm')">&times;</span>
        </div>
        <form id="formUser" action="<?= base_url('kelola_user/simpan') ?>" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password <small id="pass_hint" class="text-muted">(Minimal 5 karakter)</small></label>
                    <input type="password" name="password" id="password" class="form-control" minlength="5">
                </div>
                <div class="form-group">
                    <label class="form-label">Role Akses</label>
                    <select name="role_id" id="role_id" class="form-control" required>
                        <?php foreach($roles as $r): ?>
                            <option value="<?= $r->id ?>"><?= $r->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group d-flex align-items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" style="width:18px; height:18px;" checked>
                    <label class="form-label mb-0" for="is_active">Status Aktif</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modalUserForm')">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddUser() {
        document.getElementById('modalTitle').innerText = 'Tambah Pengguna';
        document.getElementById('formUser').action = '<?= base_url("kelola_user/simpan") ?>';
        document.getElementById('nama').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('password').setAttribute('required', 'required');
        document.getElementById('pass_hint').innerText = '(Minimal 5 karakter)';
        document.getElementById('role_id').value = '2'; // default non admin
        document.getElementById('is_active').checked = true;
        
        openModal('modalUserForm');
    }

    function openEditUser(user) {
        document.getElementById('modalTitle').innerText = 'Edit Pengguna';
        document.getElementById('formUser').action = '<?= base_url("kelola_user/update/") ?>' + user.id;
        document.getElementById('nama').value = user.nama;
        document.getElementById('email').value = user.email;
        document.getElementById('password').value = '';
        document.getElementById('password').removeAttribute('required');
        document.getElementById('pass_hint').innerText = '(Kosongkan jika tidak ingin mengubah sandi)';
        document.getElementById('role_id').value = user.role_id;
        document.getElementById('is_active').checked = user.is_active == 1;
        
        openModal('modalUserForm');
    }
</script>
