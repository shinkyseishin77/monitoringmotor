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
        <h3 class="card-title">Daftar Motor</h3>
        <?php if(isset($permissions['motor']['can_create']) || $role_id == 1): ?>
            <a href="<?= base_url('motor/tambah') ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Motor</a>
        <?php endif; ?>
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
            <a href="<?= base_url('motor') ?>" class="btn btn-secondary">Reset</a>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No Polisi</th>
                        <th>Pemilik</th>
                        <th>No HP</th>
                        <th>Merk/Tipe</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($motors)): ?>
                        <tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>
                    <?php else: ?>
                        <?php foreach($motors as $m): ?>
                        <tr>
                            <td><strong><?= $m->nomor_polisi ?></strong></td>
                            <td><?= $m->nama_pemilik ?></td>
                            <td><?= $m->no_hp ?></td>
                            <td><?= $m->merk ?> <?= $m->tipe ?> (<?= $m->tahun ?>)</td>
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
                                <a href="<?= base_url('motor/detail/'.$m->id) ?>" class="btn btn-sm btn-info" style="background:#17a2b8; color:#fff;" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                <?php if(isset($permissions['motor']['can_update']) || $role_id == 1): ?>
                                    <a href="<?= base_url('motor/edit/'.$m->id) ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa-solid fa-edit"></i></a>
                                <?php endif; ?>
                                <?php if(isset($permissions['motor']['can_delete']) || $role_id == 1): ?>
                                    <form action="<?= base_url('motor/hapus/'.$m->id) ?>" method="post" class="form-confirm" style="display:inline;">
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
