<div class="d-flex gap-2 mb-3">
    <a href="<?= base_url('penjadwalan') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    <?php if(isset($permissions['jadwal_service']['can_update']) || $role_id == 1): ?>
        <a href="<?= base_url('penjadwalan/edit/'.$jadwal->id) ?>" class="btn btn-primary"><i class="fa-solid fa-edit"></i> Edit Jadwal</a>
    <?php endif; ?>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3 class="card-title">Informasi Detail Jadwal</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <tr><th style="width: 200px; background: none; border:none; padding:0.5rem 0;">Status</th><td style="border:none; padding:0.5rem 0;">: 
                <?php
                $badge = 'secondary';
                if($jadwal->status == 'dijadwalkan') $badge = 'primary';
                if($jadwal->status == 'selesai') $badge = 'success';
                if($jadwal->status == 'terlewat') $badge = 'danger';
                ?>
                <span class="badge badge-<?= $badge ?>"><?= ucfirst($jadwal->status) ?></span>
            </td></tr>
            <tr><th style="background: none; border:none; padding:0.5rem 0;">Jenis Service</th><td style="border:none; padding:0.5rem 0;">: 
                <?php if($jadwal->jenis_service == 'ac'): ?>
                    <span class="badge badge-info" style="background:#d1ecf1; color:#0c5460;">AC</span>
                <?php else: ?>
                    <span class="badge badge-secondary"><?= ucfirst(str_replace('_', ' ', $jadwal->jenis_service)) ?></span>
                <?php endif; ?>
            </td></tr>
            
            <?php if($jadwal->jenis_service == 'ac'): ?>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Target Unit AC</th><td style="border:none; padding:0.5rem 0;">: <strong><?= $jadwal->nama_unit ?? '<i class="text-danger">Unit Terhapus</i>' ?></strong></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Lokasi AC</th><td style="border:none; padding:0.5rem 0;">: <?= $jadwal->lokasi_ac ?? '-' ?></td></tr>
            <?php else: ?>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Motor Target</th><td style="border:none; padding:0.5rem 0;">: <strong><?= $jadwal->nomor_polisi ?? '<i class="text-danger">Motor Terhapus</i>' ?></strong></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Merk / Tipe</th><td style="border:none; padding:0.5rem 0;">: <?= $jadwal->merk ?> <?= $jadwal->tipe ?></td></tr>
                <tr><th style="background: none; border:none; padding:0.5rem 0;">Pemilik Kendaraan</th><td style="border:none; padding:0.5rem 0;">: <?= $jadwal->nama_pemilik ?? '-' ?></td></tr>
            <?php endif; ?>
            
            <tr><th style="background: none; border:none; padding:0.5rem 0;">Tanggal Jadwal</th><td style="border:none; padding:0.5rem 0;">: <strong><?= date('d M Y', strtotime($jadwal->tanggal_jadwal)) ?></strong></td></tr>
            <tr><th style="background: none; border:none; padding:0.5rem 0; vertical-align: top;">Catatan</th><td style="border:none; padding:0.5rem 0;">:<br><div style="background: #f8f9fa; padding: 1rem; border-radius: 4px; margin-top:0.5rem;"><?= nl2br($jadwal->catatan ? $jadwal->catatan : '<em>Tidak ada catatan...</em>') ?></div></td></tr>
        </table>
    </div>
</div>
