<h2 style="margin-bottom: 2rem; color: #333;">Live Monitoring AC</h2>

<form method="GET" action="<?= base_url('monitoring-ac-public') ?>" style="margin-bottom: 2rem; display: flex; gap: 10px;">
    <input type="text" name="search" class="form-control" placeholder="Cari Nama Unit, Merk, atau Lokasi..." value="<?= $this->input->get('search') ?>" style="max-width: 300px;">
    <select name="status" class="form-control" style="max-width: 200px;">
        <option value="">Semua Status</option>
        <option value="aktif" <?= $this->input->get('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
        <option value="service" <?= $this->input->get('status') == 'service' ? 'selected' : '' ?>>Service</option>
        <option value="mati" <?= $this->input->get('status') == 'mati' ? 'selected' : '' ?>>Mati / Rusak</option>
    </select>
    <button type="submit" class="btn-primary">Filter</button>
</form>

<div class="motor-grid">
    <?php if(!empty($acs)): ?>
        <?php foreach($acs as $ac): ?>
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.2rem;"><?= $ac->nama_unit ?></h3>
                        <div style="color: #666; font-size: 0.9rem;"><?= $ac->merk ?> <?= $ac->tipe ?> (Cap: <?= $ac->kapasitas ?>)</div>
                    </div>
                    <div>
                        <?php if($ac->status == 'aktif'): ?>
                            <span class="status-badge status-tersedia">Aktif</span>
                        <?php elseif($ac->status == 'service'): ?>
                            <span class="status-badge status-service">Service</span>
                        <?php else: ?>
                            <span class="status-badge bg-dark text-white" style="background:#dc3545; color:white;">Mati / Rusak</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div style="font-size: 0.9rem; color: #444; background: #f9f9f9; padding: 10px; border-radius: 5px;">
                    <strong style="display: block; margin-bottom: 5px;"><i class="fa fa-info-circle"></i> Info Monitoring:</strong>
                    <div><strong>Lokasi:</strong> <?= $ac->lokasi ?></div>
                    <div><strong>Catatan Backend:</strong> <em><?= !empty($ac->catatan) ? $ac->catatan : '-' ?></em></div>
                    
                    <div style="margin-top: 10px; font-size: 0.8rem; color: #888;">
                        <i class="fa fa-clock"></i> Terakhir diupdate: <?= date('d M Y H:i', strtotime($ac->updated_at)) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: white; border-radius: 10px;">
            <i class="fa-solid fa-snowflake mb-3" style="font-size: 3rem; color: #ccc;"></i>
            <p>Tidak ada data AC ditemukan.</p>
        </div>
    <?php endif; ?>
</div>

<div style="margin-top: 2rem;">
    <?= $pagination ?>
</div>
