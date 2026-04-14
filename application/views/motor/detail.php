<div class="d-flex gap-2 mb-3">
    <a href="<?= base_url('motor') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    <?php if(isset($permissions['motor']['can_update']) || $role_id == 1): ?>
        <a href="<?= base_url('motor/edit/'.$motor->id) ?>" class="btn btn-primary"><i class="fa-solid fa-edit"></i> Edit Motor</a>
    <?php endif; ?>
</div>

<div class="d-flex gap-2" style="flex-wrap: wrap;">
    <div class="card" style="flex:1; min-width: 300px;">
        <div class="card-header">
            <h3 class="card-title">Informasi Kendaraan</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <tr><th style="width: 150px; background: none; border:none; padding:0.5rem 0;">No Polisi</th><td style="border:none; padding:0.5rem 0;">: <strong><?= $motor->nomor_polisi ?></strong></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Pemilik</th><td style="border:none; padding:0.5rem 0;">: <?= $motor->nama_pemilik ?></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">No HP</th><td style="border:none; padding:0.5rem 0;">: <?= $motor->no_hp ?></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Kendaraan</th><td style="border:none; padding:0.5rem 0;">: <?= $motor->merk ?> <?= $motor->tipe ?> (<?= $motor->tahun ?>)</td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Status Saat Ini</th><td style="border:none; padding:0.5rem 0;">: 
                    <?php
                    $badge = 'secondary';
                    if($motor->status == 'tersedia') $badge = 'success';
                    if($motor->status == 'service') $badge = 'warning';
                    if($motor->status == 'digunakan') $badge = 'danger';
                    ?>
                    <span class="badge badge-<?= $badge ?>"><?= ucfirst($motor->status) ?></span>
                </td></tr>
            </table>
        </div>
    </div>

    <div class="card" style="flex:2; min-width: 400px;">
        <div class="card-header">
            <h3 class="card-title">Riwayat Service</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                <table class="table" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keluhan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($services)): ?>
                        <tr><td colspan="3" class="text-center">Belum ada riwayat service</td></tr>
                        <?php else: ?>
                            <?php foreach($services as $s): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($s->tanggal_service)) ?></td>
                                <td><?= $s->keluhan ?></td>
                                <td><span class="badge badge-<?= $s->status == 'selesai' ? 'success' : ($s->status == 'proses' ? 'warning' : 'secondary') ?>"><?= ucfirst($s->status) ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Log Monitoring</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
            <table class="table" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Lokasi / Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($logs)): ?>
                    <tr><td colspan="3" class="text-center">Data log masih kosong</td></tr>
                    <?php else: ?>
                        <?php foreach($logs as $l): ?>
                        <tr>
                            <td><?= date('d M Y H:i', strtotime($l->created_at)) ?></td>
                            <td><span class="badge badge-<?= $l->status == 'tersedia' ? 'success' : ($l->status == 'service' ? 'warning' : 'danger') ?>"><?= ucfirst($l->status) ?></span></td>
                            <td>
                                <?php if($l->status == 'digunakan'): ?>
                                    Digunakan oleh: <?= $l->digunakan_oleh ?>, Tujuan: <?= $l->tujuan ?>
                                <?php else: ?>
                                    Lokasi: <?= $l->lokasi ? $l->lokasi : '-' ?>
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
