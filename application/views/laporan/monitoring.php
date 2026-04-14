<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><?= $title ?></h3>
        <div class="btn-group">
            <a href="<?= base_url('laporan_monitoring?tipe=motor') ?>" class="btn <?= $tipe == 'motor' ? 'btn-primary' : 'btn-secondary' ?>">Log Motor</a>
            <a href="<?= base_url('laporan_monitoring?tipe=ac') ?>" class="btn <?= $tipe == 'ac' ? 'btn-primary' : 'btn-secondary' ?>" style="margin-left:-5px;">Log AC</a>
        </div>
    </div>
    <div class="card-body">
        <form method="get" class="d-flex gap-2 mb-3 align-items-end" style="max-width: 600px; flex-wrap: wrap;">
            <input type="hidden" name="tipe" value="<?= $tipe ?>">
            <div class="form-group mb-0 flex-1" style="min-width: 150px;">
                <label>Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="<?= $this->input->get('start_date') ?>">
            </div>
            <div class="form-group mb-0 flex-1" style="min-width: 150px;">
                <label>Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="<?= $this->input->get('end_date') ?>">
            </div>
            
            <div class="d-flex gap-2 pb-1">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i> Filter</button>
                <a href="<?= base_url('laporan_monitoring?tipe='.$tipe) ?>" class="btn btn-secondary"><i class="fa-solid fa-sync"></i> Reset</a>
                <button type="button" class="btn btn-success" onclick="window.print()"><i class="fa-solid fa-print"></i> Cetak</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <?php if($tipe == 'motor'): ?>
                    <tr>
                        <th>Waktu Log</th>
                        <th>Target Motor</th>
                        <th>Status</th>
                        <th>Lokasi</th>
                        <th>Digunakan Oleh (Tujuan)</th>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <th>Waktu Log</th>
                        <th>Target AC</th>
                        <th>Status</th>
                        <th>Suhu (°C)</th>
                        <th>Catatan Teknisi</th>
                    </tr>
                    <?php endif; ?>
                </thead>
                <tbody>
                    <?php if(empty($logs)): ?>
                        <tr><td colspan="5" class="text-center">Tidak ada data log yang ditemukan</td></tr>
                    <?php else: ?>
                        <?php foreach($logs as $l): ?>
                            <?php if($tipe == 'motor'): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($l->created_at)) ?></td>
                                <td><strong><?= $l->nomor_polisi ?></strong> (<?= $l->nama_pemilik ?>)</td>
                                <td><span class="badge badge-<?= $l->status == 'tersedia' ? 'success' : ($l->status == 'service' ? 'warning' : 'danger') ?>"><?= ucfirst($l->status) ?></span></td>
                                <td><?= $l->lokasi ? $l->lokasi : '-' ?></td>
                                <td><?= $l->digunakan_oleh ? $l->digunakan_oleh . ' - ' . $l->tujuan : '-' ?></td>
                            </tr>
                            <?php else: ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($l->created_at)) ?></td>
                                <td><strong><?= $l->nama_unit ?></strong> (<?= $l->lokasi ?>)</td>
                                <td><span class="badge badge-<?= $l->status == 'aktif' ? 'success' : ($l->status == 'service' ? 'warning' : 'danger') ?>"><?= ucfirst($l->status) ?></span></td>
                                <td><?= $l->suhu ? $l->suhu . '°C' : '-' ?></td>
                                <td><?= $l->catatan ? $l->catatan : '-' ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
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
    .sidebar, .topbar, form, .pagination, .d-print-none, .btn-group { display: none !important; }
    .main-content { margin-left: 0 !important; width: 100% !important; }
    .card { box-shadow: none; border: none; }
    .card-header { padding: 0; margin-bottom: 20px; }
    h3::after { content: " (<?= ucfirst($tipe) ?>)"; }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { border: 1px solid #000; padding: 8px; font-size: 12px; }
}
</style>
