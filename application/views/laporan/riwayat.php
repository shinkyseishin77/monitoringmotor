<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $title ?></h3>
    </div>
    <div class="card-body">
        <form method="get" class="d-flex gap-2 mb-3 align-items-end" style="max-width: 800px; flex-wrap: wrap;">
            <div class="form-group mb-0 flex-1">
                <label>Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="<?= $this->input->get('start_date') ?>">
            </div>
            <div class="form-group mb-0 flex-1">
                <label>Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="<?= $this->input->get('end_date') ?>">
            </div>
            <div class="form-group mb-0 flex-1">
                <label>Pilih Motor</label>
                <select name="motor_id" class="form-control">
                    <option value="">Semua Motor</option>
                    <?php foreach($motors as $m): ?>
                        <option value="<?= $m->id ?>" <?= $this->input->get('motor_id') == $m->id ? 'selected' : '' ?>><?= $m->label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i> Filter</button>
                <a href="<?= base_url('riwayat') ?>" class="btn btn-secondary"><i class="fa-solid fa-sync"></i> Reset</a>
                <button type="button" class="btn btn-success" onclick="window.print()"><i class="fa-solid fa-print"></i> Cetak</button>
            </div>
        </form>

        <div class="table-responsive" id="printArea">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal Service</th>
                        <th>Motor (No Polisi)</th>
                        <th>Pemilik</th>
                        <th>Kendaraan</th>
                        <th>Keluhan</th>
                        <th>Tindakan / Penanganan</th>
                        <th>Biaya (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_biaya = 0;
                    if(empty($riwayat)): ?>
                        <tr><td colspan="7" class="text-center">Tidak ada data riwayat dengan kriteria tersebut</td></tr>
                    <?php else: ?>
                        <?php foreach($riwayat as $r): 
                            $total_biaya += $r->biaya_jasa;
                        ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($r->tanggal_service)) ?></td>
                            <td><strong><?= $r->nomor_polisi ?></strong></td>
                            <td><?= $r->nama_pemilik ?></td>
                            <td><?= $r->merk ?> <?= $r->tipe ?></td>
                            <td><small><?= $r->keluhan ?></small></td>
                            <td><small><?= $r->tindakan ? $r->tindakan : '-' ?></small></td>
                            <td class="text-right"><?= number_format($r->biaya_jasa, 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr style="background-color: #f8f9fa;">
                            <th colspan="6" class="text-right">Total Biaya Service:</th>
                            <th class="text-right" style="font-size: 1.1rem;">Rp <?= number_format($total_biaya, 0, ',', '.') ?></th>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="d-print-none">
            <?= $pagination ?>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .topbar, form, .pagination, .d-print-none { display: none !important; }
    .main-content { margin-left: 0 !important; width: 100% !important; }
    .card { box-shadow: none; border: none; }
    .card-header { padding: 0; margin-bottom: 20px; }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { border: 1px solid #000; padding: 8px; font-size: 12px; }
}
</style>
