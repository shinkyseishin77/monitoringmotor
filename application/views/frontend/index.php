<h1 class="page-title"><span class="gradient-text">Live Monitoring Motor</span></h1>

<div class="filter-bar">
    <form method="GET" action="<?= base_url('monitoring-public') ?>" style="display: flex; gap: 1rem; width: 100%; justify-content: center; flex-wrap: wrap;">
        <input type="text" name="search" class="modern-input" placeholder="Cari Nopol, Pemilik, atau Merk..." value="<?= $this->input->get('search') ?>">
        <select name="status" class="modern-select">
            <option value="">Semua Status</option>
            <option value="tersedia" <?= $this->input->get('status') == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
            <option value="service" <?= $this->input->get('status') == 'service' ? 'selected' : '' ?>>Service</option>
            <option value="digunakan" <?= $this->input->get('status') == 'digunakan' ? 'selected' : '' ?>>Digunakan</option>
        </select>
        <button type="submit" class="btn-modern btn-primary-modern"><i class="fa fa-filter"></i> Filter</button>
    </form>
</div>

<div class="modern-grid">
    <?php if(!empty($motors)): ?>
        <?php foreach($motors as $m): ?>
            <div class="modern-card">
                <div class="card-header-modern">
                    <div>
                        <h3 class="card-title-modern"><?= $m->nomor_polisi ?></h3>
                        <p class="card-subtitle-modern"><?= $m->merk ?> <?= $m->tipe ?> (<?= $m->tahun ?>)</p>
                    </div>
                    <?php if($m->status == 'tersedia'): ?>
                        <span class="pbadge pbadge-success"><i class="fa fa-check-circle" style="margin-right: 5px;"></i>Tersedia</span>
                    <?php elseif($m->status == 'service'): ?>
                        <span class="pbadge pbadge-warning"><i class="fa fa-wrench" style="margin-right: 5px;"></i>Service</span>
                    <?php else: ?>
                        <span class="pbadge pbadge-info"><i class="fa fa-road" style="margin-right: 5px;"></i>Digunakan</span>
                    <?php endif; ?>
                </div>
                
                <div class="data-block">
                    <div class="data-row" style="margin-bottom: 5px; padding-bottom: 5px;">
                        <span class="data-label"><i class="fa fa-user" style="width: 15px;"></i> Pemilik</span>
                        <span class="data-value"><?= $m->nama_pemilik ?> (<?= $m->no_hp ?>)</span>
                    </div>
                    <div class="data-row" style="margin-bottom: 5px; padding-bottom: 5px;">
                        <span class="data-label"><i class="fa fa-map-marker-alt" style="width: 15px;"></i> Lokasi Posisi</span>
                        <span class="data-value"><?= !empty($m->lokasi) ? htmlspecialchars($m->lokasi) : '-' ?></span>
                    </div>
                    <?php if($m->status == 'digunakan'): ?>
                    <div class="data-row" style="margin-bottom: 5px; padding-bottom: 5px;">
                        <span class="data-label"><i class="fa fa-id-badge" style="width: 15px;"></i> Pengguna</span>
                        <span class="data-value"><?= !empty($m->digunakan_oleh) ? htmlspecialchars($m->digunakan_oleh) : '-' ?></span>
                    </div>
                    <div class="data-row" style="margin-bottom: 0px; padding-bottom: 0px; border-bottom: none;">
                        <span class="data-label"><i class="fa fa-location-arrow" style="width: 15px;"></i> Tujuan</span>
                        <span class="data-value"><?= !empty($m->tujuan) ? htmlspecialchars($m->tujuan) : '-' ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="card-footer-modern">
                    <i class="fa-regular fa-clock"></i> Terakhir diupdate: <?= date('d M Y H:i', strtotime($m->updated_at)) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state-modern">
            <div class="empty-state-icon"><i class="fa-solid fa-motorcycle"></i></div>
            <p class="empty-state-text">Tidak ada data motor ditemukan.</p>
        </div>
    <?php endif; ?>
</div>

<div style="margin-top: 3rem; display: flex; justify-content: center;">
    <?= $pagination ?>
</div>
