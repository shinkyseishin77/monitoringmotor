<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary" style="background: rgba(52, 152, 219, 0.1); color: #3498db;"><i class="fa-solid fa-snowflake"></i></div>
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
        <h3 class="card-title">Daftar Unit AC</h3>
        <?php if(isset($permissions['unit_ac']['can_create']) || $role_id == 1): ?>
            <a href="<?= base_url('unit_ac/tambah') ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Unit AC</a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <form method="get" class="d-flex gap-2 justify-content-between mb-3" style="max-width: 600px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama, merk, lokasi..." value="<?= $this->input->get('search') ?>">
            <select name="status" class="form-control" style="max-width:200px;">
                <option value="">Semua Status</option>
                <option value="aktif" <?= $this->input->get('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="service" <?= $this->input->get('status') == 'service' ? 'selected' : '' ?>>Service</option>
                <option value="mati" <?= $this->input->get('status') == 'mati' ? 'selected' : '' ?>>Mati/Rusak</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
            <a href="<?= base_url('unit_ac') ?>" class="btn btn-secondary">Reset</a>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Unit</th>
                        <th>Merk / Tipe</th>
                        <th>Kapasitas (PK)</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($acs)): ?>
                        <tr><td colspan="6" class="text-center">Data AC tidak ditemukan</td></tr>
                    <?php else: ?>
                        <?php foreach($acs as $m): ?>
                        <tr>
                            <td><strong><?= $m->nama_unit ?></strong></td>
                            <td><?= $m->merk ?> <?= $m->tipe ?></td>
                            <td><?= $m->kapasitas ?></td>
                            <td><i class="fa-solid fa-map-marker-alt text-muted"></i> <?= $m->lokasi ?></td>
                            <td>
                                <?php
                                $badge = 'secondary';
                                if($m->status == 'aktif') $badge = 'success';
                                if($m->status == 'service') $badge = 'warning';
                                if($m->status == 'mati') $badge = 'danger';
                                ?>
                                <span class="badge badge-<?= $badge ?>"><?= ucfirst($m->status) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('unit_ac/detail/'.$m->id) ?>" class="btn btn-sm btn-info" style="background:#17a2b8; color:#fff;" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                <?php if(isset($permissions['unit_ac']['can_update']) || $role_id == 1): ?>
                                    <a href="<?= base_url('unit_ac/edit/'.$m->id) ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa-solid fa-edit"></i></a>
                                <?php endif; ?>
                                <?php if(isset($permissions['unit_ac']['can_delete']) || $role_id == 1): ?>
                                    <form action="<?= base_url('unit_ac/hapus/'.$m->id) ?>" method="post" class="form-confirm" style="display:inline;">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
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
