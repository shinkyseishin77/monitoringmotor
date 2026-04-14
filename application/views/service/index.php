<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary"><i class="fa-solid fa-clipboard-list"></i></div>
        <div class="stat-details"><h3><?= $stats['total'] ?></h3><p>Total Service</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon danger" style="background:#fce4e4; color:#e74c3c;"><i class="fa-solid fa-clock"></i></div>
        <div class="stat-details"><h3><?= $stats['pending'] ?></h3><p>Pending</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon warning"><i class="fa-solid fa-spinner fa-spin"></i></div>
        <div class="stat-details"><h3><?= $stats['proses'] ?></h3><p>Dalam Proses</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon success"><i class="fa-solid fa-check-double"></i></div>
        <div class="stat-details"><h3><?= $stats['selesai'] ?></h3><p>Selesai</p></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Service Motor</h3>
        <?php if(isset($permissions['service']['can_create']) || $role_id == 1): ?>
            <a href="<?= base_url('service/tambah') ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Service</a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <form method="get" class="d-flex gap-2 justify-content-between mb-3" style="max-width: 600px;">
            <input type="text" name="search" class="form-control" placeholder="Cari keluhan, nopol, pemilik..." value="<?= $this->input->get('search') ?>">
            <select name="status" class="form-control" style="max-width:200px;">
                <option value="">Semua Status</option>
                <option value="pending" <?= $this->input->get('status') == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="proses" <?= $this->input->get('status') == 'proses' ? 'selected' : '' ?>>Proses</option>
                <option value="selesai" <?= $this->input->get('status') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
            <a href="<?= base_url('service') ?>" class="btn btn-secondary">Reset</a>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Motor</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($services)): ?>
                        <tr><td colspan="5" class="text-center">Data service tidak ditemukan</td></tr>
                    <?php else: ?>
                        <?php foreach($services as $m): ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($m->tanggal_service)) ?></td>
                            <td>
                                <strong><?= $m->nomor_polisi ?></strong><br>
                                <small class="text-muted"><?= $m->nama_pemilik ?> - <?= $m->merk ?></small>
                            </td>
                            <td><?= strlen($m->keluhan) > 50 ? substr($m->keluhan,0,50).'...' : $m->keluhan ?></td>
                            <td>
                                <?php
                                $badge = 'secondary';
                                if($m->status == 'pending') $badge = 'danger';
                                if($m->status == 'proses') $badge = 'warning';
                                if($m->status == 'selesai') $badge = 'success';
                                ?>
                                <span class="badge badge-<?= $badge ?>"><?= ucfirst($m->status) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('service/detail/'.$m->id) ?>" class="btn btn-sm btn-info" style="background:#17a2b8; color:#fff;" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                
                                <?php if($m->status != 'selesai' && (isset($permissions['service']['can_update']) || $role_id == 1)): ?>
                                    <form action="<?= base_url('service/update_status/'.$m->id) ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-sm btn-success" title="Update Status Cepat: Maju ke tahap selanjutnya">
                                            <i class="fa-solid fa-forward-step"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <?php if(isset($permissions['service']['can_update']) || $role_id == 1): ?>
                                    <a href="<?= base_url('service/edit/'.$m->id) ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa-solid fa-edit"></i></a>
                                <?php endif; ?>
                                
                                <?php if(isset($permissions['service']['can_delete']) || $role_id == 1): ?>
                                    <form action="<?= base_url('service/hapus/'.$m->id) ?>" method="post" class="form-confirm" style="display:inline;">
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
