<h2 style="margin-bottom: 2rem; color: #333;">Live Monitoring Motor</h2>

<form method="GET" action="<?= base_url('monitoring-public') ?>" style="margin-bottom: 2rem; display: flex; gap: 10px;">
    <input type="text" name="search" class="form-control" placeholder="Cari Nopol atau Merk..." value="<?= $this->input->get('search') ?>" style="max-width: 300px;">
    <select name="status" class="form-control" style="max-width: 200px;">
        <option value="">Semua Status</option>
        <option value="tersedia" <?= $this->input->get('status') == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
        <option value="digunakan" <?= $this->input->get('status') == 'digunakan' ? 'selected' : '' ?>>Digunakan</option>
        <option value="service" <?= $this->input->get('status') == 'service' ? 'selected' : '' ?>>Service</option>
    </select>
    <button type="submit" class="btn-primary">Filter</button>
</form>

<div class="motor-grid">
    <?php if(!empty($motors)): ?>
        <?php foreach($motors as $m): ?>
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.2rem;"><?= $m->nomor_polisi ?></h3>
                        <div style="color: #666; font-size: 0.9rem;"><?= $m->merk ?> <?= $m->tipe ?> (<?= $m->tahun ?>)</div>
                    </div>
                    <div>
                        <?php if($m->status == 'tersedia'): ?>
                            <span class="status-badge status-tersedia">Tersedia</span>
                        <?php elseif($m->status == 'service'): ?>
                            <span class="status-badge status-service">Service</span>
                        <?php else: ?>
                            <span class="status-badge status-digunakan">Digunakan</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div style="font-size: 0.9rem; color: #444; background: #f9f9f9; padding: 10px; border-radius: 5px;">
                    <strong style="display: block; margin-bottom: 5px;"><i class="fa fa-info-circle"></i> Keterangan (Update Backend):</strong>
                    <?php if($m->status == 'tersedia'): ?>
                        <div style="color: #28a745;">Motor siap digunakan. Posisi: <?= !empty($m->lokasi) ? $m->lokasi : 'Pool' ?></div>
                    <?php elseif($m->status == 'digunakan'): ?>
                        <div><strong>Oleh:</strong> <?= $m->digunakan_oleh ?></div>
                        <div><strong>Tujuan:</strong> <?= $m->tujuan ?></div>
                        <div><strong>Posisi:</strong> <?= !empty($m->lokasi) ? $m->lokasi : 'Sedang jalan' ?></div>
                    <?php elseif($m->status == 'service'): ?>
                        <div style="color: #dc3545;">Motor sedang dalam perbaikan / service mingguan.</div>
                    <?php endif; ?>
                    <div style="margin-top: 10px; font-size: 0.8rem; color: #888;">
                        <i class="fa fa-clock"></i> Terakhir diupdate: <?= date('d M Y H:i', strtotime($m->updated_at)) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: white; border-radius: 10px;">
            <i class="fa-solid fa-folder-open mb-3" style="font-size: 3rem; color: #ccc;"></i>
            <p>Tidak ada data motor.</p>
        </div>
    <?php endif; ?>
</div>

<div style="margin-top: 2rem;">
    <?= $pagination ?>
</div>
