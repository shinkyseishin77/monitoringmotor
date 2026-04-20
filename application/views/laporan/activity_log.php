<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $title ?></h3>
    </div>
    <div class="card-body">
        <form method="get" class="d-flex gap-2 justify-content-between mb-3" style="max-width: 600px;">
            <input type="text" name="search" class="form-control" placeholder="Cari user, ip address..." value="<?= $this->input->get('search') ?>">
            <select name="module" class="form-control" style="max-width:200px;">
                <option value="">Semua Modul</option>
                <option value="auth" <?= $this->input->get('module') == 'auth' ? 'selected' : '' ?>>Auth</option>
                <option value="motor" <?= $this->input->get('module') == 'motor' ? 'selected' : '' ?>>Motor</option>
                <option value="service" <?= $this->input->get('module') == 'service' ? 'selected' : '' ?>>Service</option>
                <option value="unit_ac" <?= $this->input->get('module') == 'unit_ac' ? 'selected' : '' ?>>Unit AC</option>
                <option value="jadwal_service" <?= $this->input->get('module') == 'jadwal_service' ? 'selected' : '' ?>>Penjadwalan</option>
                <option value="monitoring_motor" <?= $this->input->get('module') == 'monitoring_motor' ? 'selected' : '' ?>>Monitoring Motor</option>
                <option value="monitoring_ac" <?= $this->input->get('module') == 'monitoring_ac' ? 'selected' : '' ?>>Monitoring AC</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
            <a href="<?= base_url('activity_log') ?>" class="btn btn-secondary">Reset</a>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Modul</th>
                        <th>Aksi</th>
                        <th>IP Address</th>
                        <th>Detail Perubahan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($logs)): ?>
                        <tr><td colspan="6" class="text-center">Data log tidak ditemukan</td></tr>
                    <?php else: ?>
                        <?php foreach($logs as $l): ?>
                        <tr>
                            <td><small><?= date('d M Y H:i:s', strtotime($l->created_at)) ?></small></td>
                            <td><?= $l->user_name ?></td>
                            <td><span class="badge badge-secondary"><?= $l->modul ?></span></td>
                            <td>
                                <?php
                                $badge = 'secondary';
                                if($l->aksi == 'login') $badge = 'primary';
                                if($l->aksi == 'logout') $badge = 'warning';
                                if($l->aksi == 'create') $badge = 'success';
                                if($l->aksi == 'update' || $l->aksi == 'update_status') $badge = 'info';
                                if($l->aksi == 'delete') $badge = 'danger';
                                ?>
                                <span class="badge badge-<?= $badge ?>"><?= $l->aksi ?></span>
                            </td>
                            <td><small>-</small></td>
                            <td>
                                <?php if($l->data_lama || $l->data_baru): ?>
                                    <button class="btn btn-sm btn-secondary" onclick="viewDetail(<?= htmlspecialchars(json_encode([
                                        'old' => json_decode($l->data_lama),
                                        'new' => json_decode($l->data_baru)
                                    ])) ?>)"><i class="fa-solid fa-code"></i> Data</button>
                                <?php else: ?>
                                    -
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

<div id="modalDataDetail" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3>Detail Perubahan Data</h3>
            <span class="close" onclick="closeModal('modalDataDetail')">&times;</span>
        </div>
        <div class="modal-body d-flex gap-2">
            <div style="flex:1; border: 1px solid #ddd; border-radius: 4px; padding: 10px; background: #fafafa;">
                <h5>Data Lama:</h5>
                <pre id="preOldData" style="font-size: 0.8rem; white-space: pre-wrap; overflow-x: auto; margin:0;"></pre>
            </div>
            <div style="flex:1; border: 1px solid #ddd; border-radius: 4px; padding: 10px; background: #e8f4f8;">
                <h5>Data Baru:</h5>
                <pre id="preNewData" style="font-size: 0.8rem; white-space: pre-wrap; overflow-x: auto; margin:0;"></pre>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('modalDataDetail')">Tutup</button>
        </div>
    </div>
</div>

<script>
    function viewDetail(dataStr) {
        let oldD = (dataStr && dataStr.old) ? JSON.stringify(dataStr.old, null, 2) : 'Null / None';
        let newD = (dataStr && dataStr.new) ? JSON.stringify(dataStr.new, null, 2) : 'Null / None';
        
        document.getElementById('preOldData').textContent = oldD;
        document.getElementById('preNewData').textContent = newD;
        openModal('modalDataDetail');
    }
</script>
