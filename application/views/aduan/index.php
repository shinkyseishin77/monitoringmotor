<div class="row mb-4">
    <div class="col-md-6">
        <form action="<?= base_url('aduan') ?>" method="get" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau keluhan..." value="<?= $this->input->get('search') ?>">
            <select name="status" class="form-select" style="max-width: 150px;">
                <option value="">Semua Status</option>
                <option value="pending" <?= $this->input->get('status') == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="proses" <?= $this->input->get('status') == 'proses' ? 'selected' : '' ?>>Proses</option>
                <option value="selesai" <?= $this->input->get('status') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                <option value="ditolak" <?= $this->input->get('status') == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
        </form>
    </div>
</div>

<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Waktu</th>
                        <th width="15%">Pelapor</th>
                        <th width="15%">No HP</th>
                        <th width="20%">Isi Aduan</th>
                        <th width="15%">Tanggapan / Alasan</th>
                        <th width="10%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($aduans)): ?>
                        <?php $no = $this->input->get('per_page') ? $this->input->get('per_page') + 1 : 1; ?>
                        <?php foreach($aduans as $a): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($a->created_at)) ?></td>
                                <td><?= $a->nama_pelapor ?></td>
                                <td><?= $a->no_hp ?></td>
                                <td><?= nl2br($a->isi_aduan) ?></td>
                                <td><?= !empty($a->alasan) ? nl2br($a->alasan) : '-' ?></td>
                                <td>
                                    <?php if($a->status == 'pending'): ?>
                                        <span class="badge bg-danger">Pending</span>
                                    <?php elseif($a->status == 'proses'): ?>
                                        <span class="badge bg-warning text-dark">Proses</span>
                                    <?php elseif($a->status == 'ditolak'): ?>
                                        <span class="badge bg-dark">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(isset($permissions['aduan']['can_update']) || $role_id == 1): ?>
                                    <button type="button" class="btn btn-sm btn-info text-white" onclick="openModal('updateModal<?= $a->id ?>')" title="Update Status">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    <?php endif; ?>
                                    
                                    <?php if(isset($permissions['aduan']['can_delete']) || $role_id == 1): ?>
                                    <a href="<?= base_url('aduan/hapus/'.$a->id) ?>" class="btn btn-sm btn-danger text-white form-confirm" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- Modal Update Status -->
                            <div class="modal" id="updateModal<?= $a->id ?>" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.5);">
                                <div class="modal-dialog" style="background-color:#fff; margin:10% auto; padding:20px; border-radius:5px; width:500px; max-width:90%;">
                                    <div class="modal-content" style="border:none; box-shadow:none;">
                                        <div class="modal-header" style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #ddd; padding-bottom:10px; margin-bottom:15px;">
                                            <h5 class="modal-title" style="margin:0;">Update Status Aduan</h5>
                                            <button type="button" class="btn-close" onclick="closeModal('updateModal<?= $a->id ?>')" style="background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
                                        </div>
                                        <form action="<?= base_url('aduan/update_status/'.$a->id) ?>" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Status Aduan</label>
                                                    <select name="status" class="form-select mb-3" required id="statusSelect_<?= $a->id ?>">
                                                        <option value="pending" <?= $a->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                        <option value="proses" <?= $a->status == 'proses' ? 'selected' : '' ?>>Proses</option>
                                                        <option value="selesai" <?= $a->status == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                                        <option value="ditolak" <?= $a->status == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                                    </select>
                                                    
                                                    <div id="alasanDiv_<?= $a->id ?>">
                                                        <label class="form-label" style="display:block; margin-top:15px;">Tanggapan / Alasan Penolakan</label>
                                                        <textarea name="alasan" class="form-control" rows="3" placeholder="Masukkan keterangan tambahan jika ditolak atau diproses/selesai..." style="width:100%;"><?= htmlspecialchars($a->alasan ?? '') ?></textarea>
                                                        <small class="text-muted" style="display:block; margin-top:5px;">Opsional untuk proses/selesai, wajib jika ditolak (rekomendasi).</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top:1px solid #ddd; padding-top:15px; margin-top:15px; text-align:right;">
                                                <button type="button" class="btn btn-secondary" onclick="closeModal('updateModal<?= $a->id ?>')">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">Tidak ada data aduan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?= $pagination ?>
    </div>
</div>

<script>
function toggleAlasan(select, id) {
    // Both ditolak, proses, and selesai might have a reason, so keep it always visible or change placeholder.
    // If we want it only for ditolak, we can hide it. But "tanggapan/alasan" should be visible always so Admin can reply.
}
// It's already visible by default since we didn't add display:none. So we can just leave it as is.
</script>
