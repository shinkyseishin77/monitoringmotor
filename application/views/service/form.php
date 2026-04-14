<div class="card" style="max-width: 800px;">
    <div class="card-header">
        <h3 class="card-title"><?= $title ?></h3>
    </div>
    <div class="card-body">
        <?php if(validation_errors()): ?>
            <div class="alert alert-danger"><?= validation_errors() ?></div>
        <?php endif; ?>

        <form action="<?= $action ?>" method="post">
            
            <div class="form-group flex-1">
                <label class="form-label">Data Motor <span style="color:red;">*</span></label>
                <select name="motor_id" class="form-control" required <?= (isset($service) && $service->status == 'selesai') ? 'disabled' : '' ?>>
                    <option value="">-- Pilih Motor --</option>
                    <?php foreach($motors as $m): ?>
                        <option value="<?= $m->id ?>" <?= set_select('motor_id', $m->id, isset($service) && $service->motor_id == $m->id) ?>><?= $m->label ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if(isset($service) && $service->status == 'selesai'): ?>
                    <input type="hidden" name="motor_id" value="<?= $service->motor_id ?>">
                <?php endif; ?>
            </div>

            <div class="d-flex gap-2">
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Tanggal Service <span style="color:red;">*</span></label>
                    <input type="date" name="tanggal_service" class="form-control" value="<?= set_value('tanggal_service', isset($service) ? $service->tanggal_service : date('Y-m-d')) ?>" required>
                </div>
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Status <span style="color:red;">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="pending" <?= set_select('status', 'pending', isset($service) && $service->status == 'pending') ?>>Pending</option>
                        <option value="proses" <?= set_select('status', 'proses', isset($service) && $service->status == 'proses') ?>>Proses</option>
                        <option value="selesai" <?= set_select('status', 'selesai', isset($service) && $service->status == 'selesai') ?>>Selesai</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Keluhan / Masalah <span style="color:red;">*</span></label>
                <textarea name="keluhan" class="form-control" rows="3" required><?= set_value('keluhan', isset($service) ? $service->keluhan : '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Tindakan / Penanganan</label>
                <textarea name="tindakan" class="form-control" rows="3"><?= set_value('tindakan', isset($service) ? $service->tindakan : '') ?></textarea>
            </div>

            <div class="form-group" style="width: 50%;">
                <label class="form-label">Biaya Jasa (Rp)</label>
                <input type="number" name="biaya_jasa" class="form-control" value="<?= set_value('biaya_jasa', isset($service) ? (int)$service->biaya_jasa : '') ?>">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan</button>
                <a href="<?= base_url('service') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
