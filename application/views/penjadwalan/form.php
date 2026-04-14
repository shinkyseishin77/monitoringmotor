<div class="card" style="max-width: 600px;">
    <div class="card-header">
        <h3 class="card-title"><?= $title ?></h3>
    </div>
    <div class="card-body">
        <?php if(validation_errors()): ?>
            <div class="alert alert-danger"><?= validation_errors() ?></div>
        <?php endif; ?>

        <form action="<?= $action ?>" method="post">
            
            <div class="form-group flex-1">
                <label class="form-label">Jenis Service <span style="color:red;">*</span></label>
                <select name="jenis_service" id="jenis_service" class="form-control" required>
                    <option value="regular" <?= set_select('jenis_service', 'regular', isset($jadwal) && $jadwal->jenis_service == 'regular') ?>>Regular (Motor)</option>
                    <option value="ganti_oli" <?= set_select('jenis_service', 'ganti_oli', isset($jadwal) && $jadwal->jenis_service == 'ganti_oli') ?>>Ganti Oli (Motor)</option>
                    <option value="tune_up" <?= set_select('jenis_service', 'tune_up', isset($jadwal) && $jadwal->jenis_service == 'tune_up') ?>>Tune Up (Motor)</option>
                    <option value="ac" <?= set_select('jenis_service', 'ac', isset($jadwal) && $jadwal->jenis_service == 'ac') ?>>Service Unit AC</option>
                </select>
            </div>

            <div class="form-group flex-1" id="wrap_motor">
                <label class="form-label">Pilih Motor <span style="color:red;">*</span></label>
                <select name="motor_id" id="motor_id" class="form-control">
                    <option value="">-- Pilih Motor --</option>
                    <?php foreach($motors as $m): ?>
                        <option value="<?= $m->id ?>" <?= set_select('motor_id', $m->id, isset($jadwal) && $jadwal->motor_id == $m->id) ?>><?= $m->label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group flex-1" id="wrap_ac" style="display:none;">
                <label class="form-label">Pilih Unit AC <span style="color:red;">*</span></label>
                <select name="unit_ac_id" id="unit_ac_id" class="form-control">
                    <option value="">-- Pilih Unit AC --</option>
                    <?php foreach($acs as $a): ?>
                        <option value="<?= $a->id ?>" <?= set_select('unit_ac_id', $a->id, isset($jadwal) && $jadwal->unit_ac_id == $a->id) ?>><?= $a->label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-flex gap-2">
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Tanggal Jadwal <span style="color:red;">*</span></label>
                    <input type="date" name="tanggal_jadwal" class="form-control" value="<?= set_value('tanggal_jadwal', isset($jadwal) ? $jadwal->tanggal_jadwal : '') ?>" required>
                </div>
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Status <span style="color:red;">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="dijadwalkan" <?= set_select('status', 'dijadwalkan', isset($jadwal) && $jadwal->status == 'dijadwalkan') ?>>Dijadwalkan</option>
                        <option value="selesai" <?= set_select('status', 'selesai', isset($jadwal) && $jadwal->status == 'selesai') ?>>Selesai</option>
                        <option value="terlewat" <?= set_select('status', 'terlewat', isset($jadwal) && $jadwal->status == 'terlewat') ?>>Terlewat</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="3"><?= set_value('catatan', isset($jadwal) ? $jadwal->catatan : '') ?></textarea>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan</button>
                <a href="<?= base_url('penjadwalan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ddlJenis = document.getElementById('jenis_service');
    const wrapMotor = document.getElementById('wrap_motor');
    const wrapAC = document.getElementById('wrap_ac');
    const inputMotor = document.getElementById('motor_id');
    const inputAC = document.getElementById('unit_ac_id');

    function toggleForms() {
        if (ddlJenis.value === 'ac') {
            wrapMotor.style.display = 'none';
            wrapAC.style.display = 'block';
            inputAC.setAttribute('required', 'required');
            inputMotor.removeAttribute('required');
        } else {
            wrapMotor.style.display = 'block';
            wrapAC.style.display = 'none';
            inputMotor.setAttribute('required', 'required');
            inputAC.removeAttribute('required');
        }
    }

    ddlJenis.addEventListener('change', toggleForms);
    toggleForms(); // run on init
});
</script>
