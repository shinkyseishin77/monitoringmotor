<div style="background: white; border-radius: 10px; padding: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <h2 style="margin-bottom: 2rem; color: #333; text-align: center;">Daftar Status Aduan</h2>

    <form method="GET" action="<?= base_url('daftar-aduan') ?>" style="margin-bottom: 2rem; display: flex; gap: 10px; justify-content: center;">
        <input type="text" name="search" class="form-control" placeholder="Cari nama atau keluhan..." value="<?= $this->input->get('search') ?>" style="max-width: 300px;">
        <select name="status" class="form-control" style="max-width: 200px;">
            <option value="">Semua Status</option>
            <option value="pending" <?= $this->input->get('status') == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="proses" <?= $this->input->get('status') == 'proses' ? 'selected' : '' ?>>Proses</option>
            <option value="selesai" <?= $this->input->get('status') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
            <option value="ditolak" <?= $this->input->get('status') == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
        </select>
        <button type="submit" class="btn-primary">Filter</button>
    </form>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">No</th>
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">Tanggal</th>
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">Pelapor</th>
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">Aduan</th>
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">Status</th>
                    <th style="padding: 12px; border-bottom: 1px solid #ddd;">Tanggapan / Alasan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($aduans)): ?>
                    <?php $no = $this->input->get('per_page') ? $this->input->get('per_page') + 1 : 1; ?>
                    <?php foreach($aduans as $a): ?>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px;"><?= $no++ ?></td>
                            <td style="padding: 12px;"><?= date('d/m/Y', strtotime($a->created_at)) ?></td>
                            <td style="padding: 12px;"><strong><?= $a->nama_pelapor ?></strong></td>
                            <td style="padding: 12px; max-width: 300px; word-wrap: break-word;"><?= nl2br($a->isi_aduan) ?></td>
                            <td style="padding: 12px;">
                                <?php if($a->status == 'pending'): ?>
                                    <span style="background: #fce4e4; color: #cc0000; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">Pending</span>
                                <?php elseif($a->status == 'proses'): ?>
                                    <span style="background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">Diproses</span>
                                <?php elseif($a->status == 'selesai'): ?>
                                    <span style="background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">Selesai</span>
                                <?php elseif($a->status == 'ditolak'): ?>
                                    <span style="background: #343a40; color: #ffffff; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px; color: #555; max-width: 250px;">
                                <?php if($a->status == 'ditolak' && !empty($a->alasan)): ?>
                                    <span style="color: #dc3545;"><i class="fa-solid fa-circle-exclamation"></i> <?= nl2br($a->alasan) ?></span>
                                <?php elseif($a->status == 'selesai' && !empty($a->alasan)): ?>
                                    <span style="color: #28a745;"><i class="fa-solid fa-check"></i> <?= nl2br($a->alasan) ?></span>
                                <?php else: ?>
                                    <em><?= !empty($a->alasan) ? nl2br($a->alasan) : '-' ?></em>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 2rem; text-align: center; color: #888;">Belum ada aduan terkait.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 2rem;">
        <?= $pagination ?>
    </div>
</div>
