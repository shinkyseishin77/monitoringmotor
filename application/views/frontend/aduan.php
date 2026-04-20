<div style="max-width: 600px; margin: 0 auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h2 style="margin-bottom: 2rem; color: #333; text-align: center;">Kirim Aduan / Laporan</h2>

    <?php if($this->session->flashdata('success')): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('publicfrontend/submit_aduan') ?>">
        <div class="form-group">
            <label>Nama Pelapor *</label>
            <input type="text" name="nama_pelapor" class="form-control" required placeholder="Masukkan nama Anda">
        </div>
        
        <div class="form-group">
            <label>Nomor HP / WhatsApp Active *</label>
            <input type="text" name="no_hp" class="form-control" required placeholder="08xxxxxx">
        </div>
        
        <div class="form-group">
            <label>Isi Aduan / Keluhan *</label>
            <textarea name="isi_aduan" class="form-control" rows="5" required placeholder="Deskripsikan keluhan atau aduan mengenai motor / layanan..."></textarea>
            <small style="color:#666;">Jelaskan dengan detail nomor polisi motor atau permasalahan yang dialami.</small>
        </div>
        
        <button type="submit" class="btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; margin-top: 1rem;"><i class="fa fa-paper-plane"></i> Kirim Aduan</button>
    </form>
</div>
