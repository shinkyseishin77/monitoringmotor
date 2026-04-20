<h1 class="page-title"><span class="gradient-text">Live Monitoring AC</span></h1>

<div class="filter-bar">
    <form method="GET" action="<?= base_url('monitoring-ac-public') ?>" style="display: flex; gap: 1rem; width: 100%; justify-content: center; flex-wrap: wrap;">
        <input type="text" name="search" class="modern-input" placeholder="Cari Nama Unit, Merk, atau Lokasi..." value="<?= $this->input->get('search') ?>">
        <select name="status" class="modern-select">
            <option value="">Semua Status</option>
            <option value="aktif" <?= $this->input->get('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
            <option value="service" <?= $this->input->get('status') == 'service' ? 'selected' : '' ?>>Service</option>
            <option value="mati" <?= $this->input->get('status') == 'mati' ? 'selected' : '' ?>>Mati / Rusak</option>
        </select>
        <button type="submit" class="btn-modern btn-primary-modern"><i class="fa fa-filter"></i> Filter</button>
    </form>
</div>

<div class="modern-grid">
    <?php if(!empty($acs)): ?>
        <?php foreach($acs as $ac): ?>
            <div class="modern-card" style="border-left-color: <?= $ac->status == 'aktif' ? 'var(--success)' : ($ac->status == 'service' ? 'var(--warning)' : 'var(--danger)') ?>;">
                <div class="card-header-modern">
                    <div>
                        <h3 class="card-title-modern"><?= $ac->nama_unit ?></h3>
                        <p class="card-subtitle-modern"><?= $ac->merk ?> <?= $ac->tipe ?> (Cap: <?= $ac->kapasitas ?>)</p>
                    </div>
                    <?php if($ac->status == 'aktif'): ?>
                        <span class="pbadge pbadge-success"><i class="fa fa-check" style="margin-right: 5px;"></i>Aktif</span>
                    <?php elseif($ac->status == 'service'): ?>
                        <span class="pbadge pbadge-warning"><i class="fa fa-wrench" style="margin-right: 5px;"></i>Service</span>
                    <?php else: ?>
                        <span class="pbadge pbadge-danger"><i class="fa fa-times-circle" style="margin-right: 5px;"></i>Rusak</span>
                    <?php endif; ?>
                </div>
                
                <div class="data-block" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <div class="data-row" style="margin-bottom: 0; padding-bottom: 0; border: none;">
                        <span class="data-label"><i class="fa fa-map-marker-alt" style="width: 15px;"></i> Lokasi</span>
                        <span class="data-value"><?= $ac->lokasi ?></span>
                    </div>
                    <?php if(!empty($ac->tanggal_pasang)): ?>
                    <div class="data-row" style="margin-bottom: 0; padding-bottom: 0; border: none;">
                        <span class="data-label"><i class="fa fa-calendar-alt" style="width: 15px;"></i> Tgl. Pasang</span>
                        <span class="data-value"><?= date('d M Y', strtotime($ac->tanggal_pasang)) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="data-row" style="margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px dashed #e2e8f0; border-bottom: none; flex-direction: column; align-items: flex-start; text-align: left; gap: 0.3rem;">
                        <span class="data-label"><i class="fa fa-clipboard-list" style="width: 15px;"></i> Catatan Admin</span>
                        <span style="font-size: 0.85rem; color: var(--text-primary); font-style: italic;">
                            <?= !empty($ac->catatan) ? htmlspecialchars($ac->catatan) : 'Tidak ada catatan.' ?>
                        </span>
                    </div>
                </div>
                
                <div class="card-footer-modern">
                    <i class="fa-regular fa-clock"></i> Terakhir diupdate: <?= date('d M Y H:i', strtotime($ac->updated_at)) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state-modern">
            <div class="empty-state-icon"><i class="fa-solid fa-snowflake"></i></div>
            <p class="empty-state-text">Tidak ada data AC ditemukan.</p>
        </div>
    <?php endif; ?>
</div>

<div style="margin-top: 3rem; display: flex; justify-content: center;">
    <?= $pagination ?>
</div>
