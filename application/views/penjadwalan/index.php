<?php if($count_mendekati > 0): ?>
<div class="alert alert-danger mb-3">
    <strong><i class="fa-solid fa-bell"></i> Perhatian:</strong> Ada <?= $count_mendekati ?> jadwal service (Motor & AC) yang mendekati waktu atau hari ini dijadwalkan.
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Jadwal Service</h3>
        <?php if(isset($permissions['jadwal_service']['can_create']) || $role_id == 1): ?>
            <a href="<?= base_url('penjadwalan/tambah') ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Jadwal</a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <form method="get" class="d-flex gap-2 justify-content-between mb-3" style="max-width: 700px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama, nopol, ac..." value="<?= $this->input->get('search') ?>">
            <select name="jenis" class="form-control" style="max-width:150px;">
                <option value="">Semua Jenis</option>
                <option value="regular" <?= $this->input->get('jenis') == 'regular' ? 'selected' : '' ?>>Regular (Mtr)</option>
                <option value="ganti_oli" <?= $this->input->get('jenis') == 'ganti_oli' ? 'selected' : '' ?>>Ganti Oli</option>
                <option value="tune_up" <?= $this->input->get('jenis') == 'tune_up' ? 'selected' : '' ?>>Tune Up</option>
                <option value="ac" <?= $this->input->get('jenis') == 'ac' ? 'selected' : '' ?>>Master AC</option>
            </select>
            <select name="status" class="form-control" style="max-width:150px;">
                <option value="">Semua Status</option>
                <option value="dijadwalkan" <?= $this->input->get('status') == 'dijadwalkan' ? 'selected' : '' ?>>Dijadwalkan</option>
                <option value="selesai" <?= $this->input->get('status') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                <option value="terlewat" <?= $this->input->get('status') == 'terlewat' ? 'selected' : '' ?>>Terlewat</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
            <a href="<?= base_url('penjadwalan') ?>" class="btn btn-secondary">Reset</a>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Jenis Service</th>
                        <th>Target (Motor/AC)</th>
                        <th>Lokasi / Pemilik</th>
                        <th>Tanggal Jadwal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($jadwal)): ?>
                        <tr><td colspan="6" class="text-center">Data jadwal tidak ditemukan</td></tr>
                    <?php else: ?>
                        <?php foreach($jadwal as $jdw): 
                            // Determine row color based on datetime differences
                            $color_class = 'secondary';
                            $text_sisa = '';
                            
                            if ($jdw->status == 'dijadwalkan') {
                                $date_target = new DateTime($jdw->tanggal_jadwal);
                                $date_now = new DateTime(date('Y-m-d'));
                                $diff = $date_now->diff($date_target);
                                $sisa_hari = (int)$diff->format('%R%a');
                                
                                if ($sisa_hari < 0) {
                                    $color_class = 'danger'; // Terlewat
                                } elseif ($sisa_hari == 0) {
                                    $color_class = 'danger'; // Hari ini
                                } elseif ($sisa_hari <= 3) {
                                    $color_class = 'warning'; // Mendekati
                                } else {
                                    $color_class = 'primary'; // Masih lama (Biru)
                                }
                            } elseif ($jdw->status == 'selesai') {
                                $color_class = 'success';
                            } else { // terlewat
                                $color_class = 'danger';
                            }
                        ?>
                        <tr>
                            <td>
                                <?php if($jdw->jenis_service == 'ac'): ?>
                                    <span class="badge badge-info" style="background:#d1ecf1; color:#0c5460;">AC</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?= ucfirst(str_replace('_', ' ', $jdw->jenis_service)) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($jdw->jenis_service == 'ac'): ?>
                                    <strong><?= $jdw->nama_unit ?? '<i class="text-muted">Unit Terhapus</i>' ?></strong>
                                <?php else: ?>
                                    <strong><?= $jdw->nomor_polisi ?? '<i class="text-muted">Motor Terhapus</i>' ?></strong><br>
                                    <small><?= $jdw->merk ?> <?= $jdw->tipe ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($jdw->jenis_service == 'ac'): ?>
                                    <i class="fa-solid fa-map-marker-alt text-muted"></i> <?= $jdw->lokasi_ac ?? '-' ?>
                                <?php else: ?>
                                    <?= $jdw->nama_pemilik ?? '-' ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= date('d M Y', strtotime($jdw->tanggal_jadwal)) ?></strong>
                            </td>
                            <td>
                                <span class="badge badge-<?= $color_class ?>"><?= ucfirst($jdw->status) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('penjadwalan/detail/'.$jdw->id) ?>" class="btn btn-sm btn-info" style="background:#17a2b8; color:#fff;" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                
                                <?php if($jdw->status == 'dijadwalkan' && (isset($permissions['jadwal_service']['can_update']) || $role_id == 1)): ?>
                                    <a href="<?= base_url('penjadwalan/selesai/'.$jdw->id) ?>" class="btn btn-sm btn-success" title="Tandai Selesai"><i class="fa-solid fa-check"></i></a>
                                <?php endif; ?>

                                <?php if(isset($permissions['jadwal_service']['can_update']) || $role_id == 1): ?>
                                    <a href="<?= base_url('penjadwalan/edit/'.$jdw->id) ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa-solid fa-edit"></i></a>
                                <?php endif; ?>
                                
                                <?php if(isset($permissions['jadwal_service']['can_delete']) || $role_id == 1): ?>
                                    <form action="<?= base_url('penjadwalan/hapus/'.$jdw->id) ?>" method="post" class="form-confirm" style="display:inline;">
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
