<div class="card" style="max-width: 800px;">
    <div class="card-header">
        <h3 class="card-title"><?= $title ?></h3>
    </div>
    <div class="card-body">
        <?php if(validation_errors()): ?>
            <div class="alert alert-danger"><?= validation_errors() ?></div>
        <?php endif; ?>

        <form action="<?= $action ?>" method="post">
            <div class="d-flex gap-2">
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Nama Pemilik <span style="color:red;">*</span></label>
                    <input type="text" name="nama_pemilik" class="form-control" value="<?= set_value('nama_pemilik', isset($motor) ? $motor->nama_pemilik : '') ?>" required>
                </div>
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">No HP <span style="color:red;">*</span></label>
                    <input type="text" name="no_hp" class="form-control" value="<?= set_value('no_hp', isset($motor) ? $motor->no_hp : '') ?>" required>
                </div>
            </div>

            <div class="d-flex gap-2">
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Merk (Contoh: Honda) <span style="color:red;">*</span></label>
                    <input type="text" name="merk" class="form-control" value="<?= set_value('merk', isset($motor) ? $motor->merk : '') ?>" required>
                </div>
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Tipe (Contoh: Beat) <span style="color:red;">*</span></label>
                    <input type="text" name="tipe" class="form-control" value="<?= set_value('tipe', isset($motor) ? $motor->tipe : '') ?>" required>
                </div>
            </div>

            <div class="d-flex gap-2">
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Nomor Polisi <span style="color:red;">*</span></label>
                    <input type="text" name="nomor_polisi" class="form-control" value="<?= set_value('nomor_polisi', isset($motor) ? $motor->nomor_polisi : '') ?>" required style="text-transform: uppercase;">
                </div>
                <div class="form-group flex-1" style="width: 50%;">
                    <label class="form-label">Tahun Pembuatan</label>
                    <input type="text" name="tahun" class="form-control" value="<?= set_value('tahun', isset($motor) ? $motor->tahun : '') ?>" maxlength="4">
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan</button>
                <a href="<?= base_url('motor') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
