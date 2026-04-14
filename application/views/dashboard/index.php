<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fa-solid fa-motorcycle"></i>
        </div>
        <div class="stat-details">
            <h3><?= $stats_motor['total'] ?></h3>
            <p>Total Motor</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fa-solid fa-wrench"></i>
        </div>
        <div class="stat-details">
            <h3><?= $stats_motor['service'] ?></h3>
            <p>Motor Sedang Service</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon info" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
            <i class="fa-solid fa-snowflake"></i>
        </div>
        <div class="stat-details">
            <h3><?= $stats_ac['total'] ?></h3>
            <p>Total Unit AC</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="fa-solid fa-thermometer-half"></i>
        </div>
        <div class="stat-details">
            <h3><?= $stats_ac['service'] ?></h3>
            <p>AC Sedang Service</p>
        </div>
    </div>
</div>

<?php if($count_jadwal > 0): ?>
<div class="alert alert-warning" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <strong><i class="fa-solid fa-bell"></i> Peringatan!</strong> Terdapat <?= $count_jadwal ?> jadwal service yang mendekati waktu (3 hari ke depan).
    </div>
    <a href="<?= base_url('penjadwalan') ?>" class="btn btn-warning btn-sm">Lihat Jadwal</a>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Jadwal Service Mendekati</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Jenis Service</th>
                        <th>Target (Motor/AC)</th>
                        <th>Lokasi / Pemilik</th>
                        <th>Tanggal Jadwal</th>
                        <th>Sisa Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($jadwal_mendekati)): ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada jadwal yang mendekati (3 hari ke depan).</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach($jadwal_mendekati as $jdw): 
                            $date_target = new DateTime($jdw->tanggal_jadwal);
                            $date_now = new DateTime(date('Y-m-d'));
                            $diff = $date_now->diff($date_target);
                            
                            $sisa_hari = (int)$diff->format('%R%a');
                            $color_class = 'primary';
                            $text_sisa = '';
                            
                            if ($sisa_hari < 0) {
                                $color_class = 'danger';
                                $text_sisa = abs($sisa_hari) . ' hari terlambat';
                            } elseif ($sisa_hari == 0) {
                                $color_class = 'danger';
                                $text_sisa = 'Hari ini!';
                            } elseif ($sisa_hari <= 3) {
                                $color_class = 'warning';
                                $text_sisa = $sisa_hari . ' hari lagi';
                            } else {
                                $text_sisa = $sisa_hari . ' hari lagi';
                            }
                        ?>
                        <tr>
                            <td>
                                <?php if($jdw->jenis_service == 'ac'): ?>
                                    <span class="badge badge-info" style="background:#d1ecf1; color:#0c5460;">AC</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?= ucfirst($jdw->jenis_service) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($jdw->jenis_service == 'ac'): ?>
                                    <strong><?= $jdw->nama_unit ?? 'N/A' ?></strong>
                                <?php else: ?>
                                    <strong><?= $jdw->nomor_polisi ?? 'N/A' ?></strong>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($jdw->jenis_service == 'ac'): ?>
                                    <?= $jdw->lokasi_ac ?? '-' ?>
                                <?php else: ?>
                                    <?= $jdw->nama_pemilik ?? '-' ?>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y', strtotime($jdw->tanggal_jadwal)) ?></td>
                            <td>
                                <span class="badge badge-<?= $color_class ?>"><?= $text_sisa ?></span>
                            </td>
                            <td>
                                <span class="badge badge-secondary"><?= ucfirst($jdw->status) ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
