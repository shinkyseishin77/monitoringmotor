<div class="d-flex gap-2 mb-3">
    <a href="<?= base_url('unit_ac') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    <?php if(isset($permissions['unit_ac']['can_update']) || $role_id == 1): ?>
        <a href="<?= base_url('unit_ac/edit/'.$ac->id) ?>" class="btn btn-primary"><i class="fa-solid fa-edit"></i> Edit AC</a>
    <?php endif; ?>
</div>

<div class="d-flex gap-2" style="flex-wrap: wrap;">
    <div class="card" style="flex:1; min-width: 300px;">
        <div class="card-header">
            <h3 class="card-title">Informasi Unit AC</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <tr><th style="width: 150px; background: none; border:none; padding:0.5rem 0;">Nama Unit</th><td style="border:none; padding:0.5rem 0;">: <strong><?= $ac->nama_unit ?></strong></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Lokasi</th><td style="border:none; padding:0.5rem 0;">: <?= $ac->lokasi ?></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Merek / Tipe</th><td style="border:none; padding:0.5rem 0;">: <?= $ac->merk ?> <?= $ac->tipe ?></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Kapasitas (PK)</th><td style="border:none; padding:0.5rem 0;">: <?= $ac->kapasitas ?></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Tanggal Pasang</th><td style="border:none; padding:0.5rem 0;">: <?= $ac->tanggal_pasang ? date('d M Y', strtotime($ac->tanggal_pasang)) : '-' ?></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Catatan</th><td style="border:none; padding:0.5rem 0;">: <?= nl2br($ac->catatan) ?></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Status Saat Ini</th><td style="border:none; padding:0.5rem 0;">: 
                    <?php
                    $badge = 'secondary';
                    if($ac->status == 'aktif') $badge = 'success';
                    if($ac->status == 'service') $badge = 'warning';
                    if($ac->status == 'mati') $badge = 'danger';
                    ?>
                    <span class="badge badge-<?= $badge ?>"><?= ucfirst($ac->status) ?></span>
                </td></tr>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Monitoring & Pemeriksaan AC</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th>Tanggal & Waktu</th>
                        <th>Status Saat Diperiksa</th>
                        <th>Suhu (°C)</th>
                        <th>Catatan Teknisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($logs)): ?>
                    <tr><td colspan="4" class="text-center">Belum ada riwayat monitoring pemeriksaan</td></tr>
                    <?php else: ?>
                        <?php foreach($logs as $l): ?>
                        <tr>
                            <td><?= date('d M Y H:i', strtotime($l->created_at)) ?></td>
                            <td><span class="badge badge-<?= $l->status == 'aktif' ? 'success' : ($l->status == 'service' ? 'warning' : 'danger') ?>"><?= ucfirst($l->status) ?></span></td>
                            <td><?= $l->suhu ? $l->suhu . ' °C' : '-' ?></td>
                            <td><?= $l->catatan ? $l->catatan : '-' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
