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
                <label class="form-label">Nama Unit <span style="color:red;">*</span> <small class="text-muted">(Contoh: AC Ruang Server 1)</small></label>
                <input type="text" name="nama_unit" class="form-control" value="<?= set_value('nama_unit', isset($ac) ? $ac->nama_unit : '') ?>" required>
            </div>

            <div class="d-flex gap-2">
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Merk (Contoh: Daikin)</label>
                    <input type="text" name="merk" class="form-control" value="<?= set_value('merk', isset($ac) ? $ac->merk : '') ?>">
                </div>
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Tipe</label>
                    <input type="text" name="tipe" class="form-control" value="<?= set_value('tipe', isset($ac) ? $ac->tipe : '') ?>">
                </div>
            </div>

            <div class="d-flex gap-2">
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Kapasitas (PK)</label>
                    <input type="text" name="kapasitas" class="form-control" value="<?= set_value('kapasitas', isset($ac) ? $ac->kapasitas : '') ?>">
                </div>
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Tanggal Pasang</label>
                    <input type="date" name="tanggal_pasang" class="form-control" value="<?= set_value('tanggal_pasang', isset($ac) ? $ac->tanggal_pasang : '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Lokasi Ruangan <span style="color:red;">*</span></label>
                <input type="text" name="lokasi" class="form-control" value="<?= set_value('lokasi', isset($ac) ? $ac->lokasi : '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="3"><?= set_value('catatan', isset($ac) ? $ac->catatan : '') ?></textarea>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan</button>
                <a href="<?= base_url('unit_ac') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
