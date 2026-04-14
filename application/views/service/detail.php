<div class="d-flex gap-2 mb-3">
    <a href="<?= base_url('service') ?>" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    <?php if(isset($permissions['service']['can_update']) || $role_id == 1): ?>
        <a href="<?= base_url('service/edit/'.$service->id) ?>" class="btn btn-primary"><i class="fa-solid fa-edit"></i> Edit Service</a>
    <?php endif; ?>
</div>

<div class="card" style="max-width: 800px;">
    <div class="card-header">
        <h3 class="card-title">Informasi Detail Service</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <tr><th style="width: 200px; background: none; border:none; padding:0.5rem 0;">Status</th><td style="border:none; padding:0.5rem 0;">: 
                <?php
                $badge = 'secondary';
                if($service->status == 'pending') $badge = 'danger';
                if($service->status == 'proses') $badge = 'warning';
                if($service->status == 'selesai') $badge = 'success';
                ?>
                <span class="badge badge-<?= $badge ?>"><?= ucfirst($service->status) ?></span>
            </td></tr>
            <tr><th style="background: none; border:none; padding:0.5rem 0;">Tanggal Service</th><td style="border:none; padding:0.5rem 0;">: <?= date('d M Y', strtotime($service->tanggal_service)) ?></td></tr>
            <tr><th style="background: none; border:none; padding:0.5rem 0;">Motor (No Polisi)</th><td style="border:none; padding:0.5rem 0;">: <strong><a href="<?= base_url('motor/detail/'.$service->motor_id) ?>"><?= $service->nomor_polisi ?></a></strong></td></tr>
            <tr><th style="background: none; border:none; padding:0.5rem 0;">Pemilik / No HP</th><td style="border:none; padding:0.5rem 0;">: <?= $service->nama_pemilik ?> / <?= $service->no_hp ?></td></tr>
            <tr><th style="background: none; border:none; padding:0.5rem 0;">Merk / Tipe</th><td style="border:none; padding:0.5rem 0;">: <?= $service->merk ?> <?= $service->tipe ?></td></tr>
            <tr><th style="background: none; border:none; padding:0.5rem 0; vertical-align: top;">Keluhan</th><td style="border:none; padding:0.5rem 0;">:<br><div style="background: #f8f9fa; padding: 1rem; border-radius: 4px; margin-top:0.5rem;"><?= nl2br($service->keluhan) ?></div></td></tr>
            <tr><th style="background: none; border:none; padding:0.5rem 0; vertical-align: top;">Tindakan Penanganan</th><td style="border:none; padding:0.5rem 0;">:<br><div style="background: #f8f9fa; padding: 1rem; border-radius: 4px; margin-top:0.5rem;"><?= nl2br($service->tindakan ? $service->tindakan : '<em>Belum ada tindakan...</em>') ?></div></td></tr>
            <tr><th style="background: none; border:none; padding:0.5rem 0;">Biaya Jasa</th><td style="border:none; padding:0.5rem 0;">: <strong style="font-size:1.1rem;">Rp <?= number_format($service->biaya_jasa, 0, ',', '.') ?></strong></td></tr>
        </table>
    </div>
</div>
