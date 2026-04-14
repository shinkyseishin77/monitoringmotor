<div class="row d-flex gap-3">
    <!-- List Role -->
    <div class="col" style="flex:1; min-width:300px;">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Role</h3>
                <button class="btn btn-primary btn-sm" onclick="openAddRole()"><i class="fa-solid fa-plus"></i> Tambah Role</button>
            </div>
            <div class="card-body p-0">
                <table class="table" style="margin:0;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($roles as $r): ?>
                        <tr>
                            <td><?= $r->id ?></td>
                            <td><?= $r->name ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="openEditRole(<?= $r->id ?>, '<?= $r->name ?>')" <?= $r->id == 1 ? 'disabled' : '' ?>><i class="fa-solid fa-edit"></i> Edit</button>
                                <?php if($r->id != 1): ?>
                                <form action="<?= base_url('kelola_role/hapus/'.$r->id) ?>" method="post" class="form-confirm" style="display:inline;">
                                    <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="alert alert-info mt-3">
            <i class="fa-solid fa-info-circle"></i> Role ID 1 adalah Administrator bawaan sistem dan memiliki akses ke seluruh fitur.<br>
            Anda tidak dapat mengedit permission atau menghapus role ID 1.
        </div>
    </div>

    <!-- Form Role -->
    <div class="col" style="flex:2; min-width: 500px; display:none;" id="panelRoleForm">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" id="formTitle">Tambah Role & Hak Akses</h3>
            </div>
            <div class="card-body">
                <form id="formRole" action="<?= base_url('kelola_role/simpan') ?>" method="post">
                    <div class="form-group">
                        <label class="form-label">Nama Role</label>
                        <input type="text" name="role_name" id="role_name" class="form-control" required placeholder="Contoh: Teknisi, Supervisor">
                    </div>
                    
                    <h4 class="mt-3 mb-2" style="font-size: 1rem; color: #555; border-bottom:1px solid #ddd; padding-bottom:5px;">Hak Akses Modul</h4>
                    <div class="table-responsive">
                        <table class="table" style="font-size: 0.9rem;">
                            <thead>
                                <tr>
                                    <th>Modul</th>
                                    <th>Cetak / Daftar (View)</th>
                                    <th>Tambah (Create)</th>
                                    <th>Edit (Update)</th>
                                    <th>Hapus (Delete)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($modules as $mod): ?>
                                <tr>
                                    <td><strong><?= ucfirst(str_replace('_', ' ', $mod)) ?></strong></td>
                                    <td class="text-center"><input type="checkbox" name="permissions[<?= $mod ?>][view]" value="1" class="cb-perm cb-view"></td>
                                    <td class="text-center"><input type="checkbox" name="permissions[<?= $mod ?>][create]" value="1" class="cb-perm cb-create"></td>
                                    <td class="text-center"><input type="checkbox" name="permissions[<?= $mod ?>][update]" value="1" class="cb-perm cb-update"></td>
                                    <td class="text-center"><input type="checkbox" name="permissions[<?= $mod ?>][delete]" value="1" class="cb-perm cb-delete"></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-secondary" onclick="closeForm()">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    <?php
    // convert roles to json for JS manipulation
    $roleJs = json_encode($roles);
    echo "const rolesData = $roleJs;\n";
    ?>

    const panelForm = document.getElementById('panelRoleForm');
    const formRole = document.getElementById('formRole');
    const roleNameInput = document.getElementById('role_name');
    const titleForm = document.getElementById('formTitle');
    const cbPerms = document.querySelectorAll('.cb-perm');

    function closeForm() {
        panelForm.style.display = 'none';
        cbPerms.forEach(cb => cb.checked = false);
    }

    function openAddRole() {
        formRole.action = '<?= base_url("kelola_role/simpan") ?>';
        titleForm.innerText = 'Tambah Role & Hak Akses';
        roleNameInput.value = '';
        cbPerms.forEach(cb => cb.checked = false);
        panelForm.style.display = 'block';
    }

    function openEditRole(id, name) {
        formRole.action = '<?= base_url("kelola_role/update/") ?>' + id;
        titleForm.innerText = 'Edit Role & Hak Akses';
        roleNameInput.value = name;
        cbPerms.forEach(cb => cb.checked = false);
        
        // Find role permissions
        const role = rolesData.find(r => r.id == id);
        if (role && role.permissions) {
            role.permissions.forEach(p => {
                if (p.can_view == 1) {
                    let cb = document.querySelector(`input[name="permissions[${p.module}][view]"]`);
                    if (cb) cb.checked = true;
                }
                if (p.can_create == 1) {
                    let cb = document.querySelector(`input[name="permissions[${p.module}][create]"]`);
                    if (cb) cb.checked = true;
                }
                if (p.can_update == 1) {
                    let cb = document.querySelector(`input[name="permissions[${p.module}][update]"]`);
                    if (cb) cb.checked = true;
                }
                if (p.can_delete == 1) {
                    let cb = document.querySelector(`input[name="permissions[${p.module}][delete]"]`);
                    if (cb) cb.checked = true;
                }
            });
        }
        
        panelForm.style.display = 'block';
    }
</script>
