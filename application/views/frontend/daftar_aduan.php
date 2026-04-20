<h1 class="page-title"><span class="gradient-text">Status Aduan Publik</span></h1>

<div class="table-container-modern" style="margin-top: 1rem;">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="margin: 0; font-size: 1.2rem; color: var(--text-primary);">Daftar Pengaduan Terbaru</h3>
            <p style="margin: 0; color: var(--text-secondary); font-size: 0.9rem;">Pantau progres dari aduan yang telah masuk ke sistem kami.</p>
        </div>
        <a href="<?= base_url('aduan-public') ?>" class="btn-modern btn-primary-modern" style="padding: 0.5rem 1rem; font-size: 0.85rem;"><i class="fa fa-plus"></i> Buat Aduan</a>
    </div>

    <div style="overflow-x: auto;">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Pelapor</th>
                    <th>Waktu Laporan</th>
                    <th style="min-width: 250px;">Aduan / Keluhan</th>
                    <th>Status</th>
                    <th style="min-width: 200px;">Tanggapan Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($aduans)): ?>
                    <?php foreach($aduans as $a): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 600;"><?= $a->nama_pelapor ?></div>
                            </td>
                            <td>
                                <div><?= date('d M Y', strtotime($a->created_at)) ?></div>
                                <div style="font-size: 0.8rem; color: var(--text-secondary);"><?= date('H:i', strtotime($a->created_at)) ?></div>
                            </td>
                            <td>
                                <div style="color: var(--text-primary); line-height: 1.4; font-size: 0.95rem;">
                                    <?= nl2br(htmlspecialchars($a->isi_aduan)) ?>
                                </div>
                            </td>
                            <td>
                                <?php if($a->status == 'pending'): ?>
                                    <span class="pbadge pbadge-danger"><i class="fa fa-clock" style="margin-right: 4px;"></i>Pending</span>
                                <?php elseif($a->status == 'proses'): ?>
                                    <span class="pbadge pbadge-warning"><i class="fa fa-spinner fa-spin" style="margin-right: 4px;"></i>Proses</span>
                                <?php elseif($a->status == 'ditolak'): ?>
                                    <span class="pbadge pbadge-dark"><i class="fa fa-times" style="margin-right: 4px;"></i>Ditolak</span>
                                <?php else: ?>
                                    <span class="pbadge pbadge-success"><i class="fa fa-check" style="margin-right: 4px;"></i>Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(!empty($a->alasan)): ?>
                                    <div style="background: #f8fafc; padding: 0.75rem; border-radius: var(--radius-md); border-left: 3px solid <?= $a->status == 'ditolak' ? 'var(--text-secondary)' : 'var(--primary-color)' ?>; font-size: 0.85rem; color: var(--text-secondary);">
                                        <?= nl2br(htmlspecialchars($a->alasan)) ?>
                                    </div>
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-size: 0.85rem; font-style: italic;">
                                        Belum ada tanggapan
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 3rem;">
                            <div style="color: #cbd5e1; font-size: 3rem; margin-bottom: 1rem;"><i class="fa fa-folder-open"></i></div>
                            <div style="font-size: 1.1rem; color: var(--text-secondary);">Belum ada aduan yang tercatat.</div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 2rem; display: flex; justify-content: center;">
    <?= $pagination ?>
</div>
