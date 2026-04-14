<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary"><i class="fa-solid fa-motorcycle"></i></div>
        <div class="stat-details"><h3><?= $stats['total'] ?></h3><p>Total Motor</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon success"><i class="fa-solid fa-check-circle"></i></div>
        <div class="stat-details"><h3><?= $stats['tersedia'] ?></h3><p>Tersedia</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon warning"><i class="fa-solid fa-wrench"></i></div>
        <div class="stat-details"><h3><?= $stats['service'] ?></h3><p>Sedang Service</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon danger"><i class="fa-solid fa-road"></i></div>
        <div class="stat-details"><h3><?= $stats['digunakan'] ?></h3><p>Digunakan</p></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lokasi & Status Real-time</h3>
    </div>
    <div class="card-body">
        <form method="get" class="d-flex gap-2 justify-content-between mb-3" style="max-width: 600px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama, nopol, merk..." value="<?= $this->input->get('search') ?>">
            <select name="status" class="form-control" style="max-width:200px;">
                <option value="">Semua Status</option>
                <option value="tersedia" <?= $this->input->get('status') == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="service" <?= $this->input->get('status') == 'service' ? 'selected' : '' ?>>Service</option>
                <option value="digunakan" <?= $this->input->get('status') == 'digunakan' ? 'selected' : '' ?>>Digunakan</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
            <a href="<?= base_url('monitoring') ?>" class="btn btn-secondary">Reset</a>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No Polisi / Motor</th>
                        <th>Pemilik</th>
                        <th>Status</th>
                        <th>Keterangan / Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($motors)): ?>
                        <tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>
                    <?php else: ?>
                        <?php foreach($motors as $m): ?>
                        <tr>
                            <td>
                                <strong><?= $m->nomor_polisi ?></strong><br>
                                <small class="text-muted"><?= $m->merk ?> <?= $m->tipe ?></small>
                            </td>
                            <td><?= $m->nama_pemilik ?></td>
                            <td>
                                <?php
                                $badge = 'secondary';
                                if($m->status == 'tersedia') $badge = 'success';
                                if($m->status == 'service') $badge = 'warning';
                                if($m->status == 'digunakan') $badge = 'danger';
                                ?>
                                <span class="badge badge-<?= $badge ?>"><?= ucfirst($m->status) ?></span>
                            </td>
                            <td>
                                <?php if($m->status == 'digunakan'): ?>
                                    <span class="text-danger"><i class="fa-solid fa-user"></i> <?= $m->digunakan_oleh ?></span><br>
                                    <small class="text-muted"><i class="fa-solid fa-map-marker-alt"></i> <?= $m->tujuan ?></small>
                                <?php elseif($m->status == 'tersedia'): ?>
                                    <span class="text-success"><i class="fa-solid fa-home"></i> <?= $m->lokasi ? $m->lokasi : 'Parkiran Bengkel' ?></span>
                                <?php else: ?>
                                    <span class="text-warning"><i class="fa-solid fa-wrench"></i> Sedang dalam perbaikan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('motor/detail/'.$m->id) ?>" class="btn btn-sm btn-info" style="background:#17a2b8; color:#fff;" title="Riwayat Motor"><i class="fa-solid fa-history"></i></a>
                                
                                <?php if(isset($permissions['monitoring']['can_update']) || $role_id == 1): ?>
                                    <button class="btn btn-sm btn-primary" onclick="openUpdateModal(<?= $m->id ?>, '<?= $m->nomor_polisi ?>', '<?= $m->status ?>', '<?= addslashes($m->lokasi) ?>', '<?= addslashes($m->digunakan_oleh) ?>', '<?= addslashes($m->tujuan) ?>')" title="Update Status"><i class="fa-solid fa-sync"></i> Update</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?= $pagination ?>
    </div>
</div>

<!-- Modal Update Status Motor -->
<div id="modalUpdate" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Update Status Motor: <span id="modalMotorNopol"></span></h3>
            <span class="close" onclick="closeModal('modalUpdate')">&times;</span>
        </div>
        <form id="formUpdateStatus" method="post" action="">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Status Motor</label>
                    <select name="status_motor" id="status_motor" class="form-control" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="service">Service</option>
                        <option value="digunakan">Digunakan</option>
                    </select>
                </div>
                <div class="form-group" id="wrap_lokasi">
                    <label class="form-label">Lokasi Saat Ini</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Contoh: Parkiran Depan">
                </div>
                <div id="wrap_digunakan" style="display:none;">
                    <div class="form-group">
                        <label class="form-label">Digunakan Oleh</label>
                        <input type="text" name="digunakan_oleh" id="digunakan_oleh" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tujuan</label>
                        <input type="text" name="tujuan" id="tujuan" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modalUpdate')">Batal</button>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </div>
        </form>
    </div>
</div>

<script>
    const ddlStatus = document.getElementById('status_motor');
    const wrapDigunakan = document.getElementById('wrap_digunakan');

    ddlStatus.addEventListener('change', function() {
        if (this.value === 'digunakan') {
            wrapDigunakan.style.display = 'block';
        } else {
            wrapDigunakan.style.display = 'none';
        }
    });

    function openUpdateModal(id, nopol, status, lokasi, digunakan_oleh, tujuan) {
        document.getElementById('modalMotorNopol').innerText = nopol;
        document.getElementById('formUpdateStatus').action = '<?= base_url("monitoring/update_status/") ?>' + id;
        
        document.getElementById('status_motor').value = status;
        document.getElementById('lokasi').value = lokasi;
        
        if (status === 'digunakan') {
            document.getElementById('digunakan_oleh').value = digunakan_oleh;
            document.getElementById('tujuan').value = tujuan;
            wrapDigunakan.style.display = 'block';
        } else {
            wrapDigunakan.style.display = 'none';
        }
        
        openModal('modalUpdate');
    }
</script>
