<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon info" style="background: rgba(52, 152, 219, 0.1); color: #3498db;"><i class="fa-solid fa-snowflake"></i></div>
        <div class="stat-details"><h3><?= $stats['total'] ?></h3><p>Total AC</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon success"><i class="fa-solid fa-check-circle"></i></div>
        <div class="stat-details"><h3><?= $stats['aktif'] ?></h3><p>Aktif</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon warning"><i class="fa-solid fa-wrench"></i></div>
        <div class="stat-details"><h3><?= $stats['service'] ?></h3><p>Sedang Service</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon danger"><i class="fa-solid fa-power-off"></i></div>
        <div class="stat-details"><h3><?= $stats['mati'] ?></h3><p>Mati / Rusak</p></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lokasi & Status AC</h3>
    </div>
    <div class="card-body">
        <form method="get" class="d-flex gap-2 justify-content-between mb-3" style="max-width: 600px;">
            <input type="text" name="search" class="form-control" placeholder="Cari unit ac, lokasi..." value="<?= $this->input->get('search') ?>">
            <select name="status" class="form-control" style="max-width:200px;">
                <option value="">Semua Status</option>
                <option value="aktif" <?= $this->input->get('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="service" <?= $this->input->get('status') == 'service' ? 'selected' : '' ?>>Service</option>
                <option value="mati" <?= $this->input->get('status') == 'mati' ? 'selected' : '' ?>>Mati/Rusak</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
            <a href="<?= base_url('monitoring_ac') ?>" class="btn btn-secondary">Reset</a>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Unit</th>
                        <th>Kapasitas / Merk</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($acs)): ?>
                        <tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>
                    <?php else: ?>
                        <?php foreach($acs as $a): ?>
                        <tr>
                            <td><strong><?= $a->nama_unit ?></strong></td>
                            <td><?= $a->kapasitas ?> PK <br><small class="text-muted"><?= $a->merk ?> <?= $a->tipe ?></small></td>
                            <td><i class="fa-solid fa-map-marker-alt text-muted"></i> <?= $a->lokasi ?></td>
                            <td>
                                <?php
                                $badge = 'secondary';
                                if($a->status == 'aktif') $badge = 'success';
                                if($a->status == 'service') $badge = 'warning';
                                if($a->status == 'mati') $badge = 'danger';
                                ?>
                                <span class="badge badge-<?= $badge ?>"><?= ucfirst($a->status) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('unit_ac/detail/'.$a->id) ?>" class="btn btn-sm btn-info" style="background:#17a2b8; color:#fff;" title="Riwayat AC"><i class="fa-solid fa-history"></i></a>
                                
                                <?php if(isset($permissions['monitoring_ac']['can_update']) || $role_id == 1): ?>
                                    <button class="btn btn-sm btn-primary" onclick="openUpdateModal(<?= $a->id ?>, '<?= $a->nama_unit ?>', '<?= $a->status ?>')" title="Update Status Pemeriksaan"><i class="fa-solid fa-sync"></i> Update / Periksa</button>
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

<!-- Modal Update Status AC -->
<div id="modalUpdateAC" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Update / Pemeriksaan AC: <span id="modalAcNama"></span></h3>
            <span class="close" onclick="closeModal('modalUpdateAC')">&times;</span>
        </div>
        <form id="formUpdateAC" method="post" action="">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Status Unit AC</label>
                    <select name="status_ac" id="status_ac" class="form-control" required>
                        <option value="aktif">Aktif / Dingin</option>
                        <option value="service">Sedang Service</option>
                        <option value="mati">Mati / Rusak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Suhu Saat Diperiksa (°C)</label>
                    <input type="number" step="0.1" name="suhu" class="form-control" placeholder="Contoh: 18.5">
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan Pemeriksaan</label>
                    <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Filter kotor, freon kurang..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modalUpdateAC')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Pemeriksaan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openUpdateModal(id, nama, status) {
        document.getElementById('modalAcNama').innerText = nama;
        document.getElementById('formUpdateAC').action = '<?= base_url("monitoring_ac/update_status/") ?>' + id;
        document.getElementById('status_ac').value = status;
        openModal('modalUpdateAC');
    }
</script>
