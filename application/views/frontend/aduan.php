<h1 class="page-title"><span class="gradient-text">Kirim Aduan / Keluhan</span></h1>

<div class="form-container-modern">
    <div style="text-align: center; margin-bottom: 2rem;">
        <p style="color: var(--text-secondary); font-size: 1.1rem;">Sampaikan kendala atau laporan Anda terkait kendaraan maupun AC. Tim kami akan segera menindaklanjutinya.</p>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert-modern alert-success-modern">
            <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert-modern alert-danger-modern">
            <i class="fa fa-exclamation-triangle"></i> <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('publicfrontend/submit_aduan') ?>">
        <div class="form-group-modern">
            <label class="form-label-modern"><i class="fa fa-user" style="color: var(--primary-color); margin-right: 5px;"></i> Nama Pelapor <span style="color:var(--danger)">*</span></label>
            <input type="text" name="nama_pelapor" class="form-control-modern" required placeholder="Masukkan nama lengkap Anda">
        </div>
        
        <div class="form-group-modern">
            <label class="form-label-modern"><i class="fa fa-phone" style="color: var(--primary-color); margin-right: 5px;"></i> Nomor HP / WhatsApp aktif <span style="color:var(--danger)">*</span></label>
            <input type="text" name="no_hp" class="form-control-modern" required placeholder="Contoh: 08123456789">
        </div>
        
        <div class="form-group-modern" style="margin-bottom: 2rem;">
            <label class="form-label-modern"><i class="fa fa-comment-dots" style="color: var(--primary-color); margin-right: 5px;"></i> Rincian Keluhan <span style="color:var(--danger)">*</span></label>
            <textarea name="isi_aduan" class="form-control-modern" required placeholder="Tuliskan keluhan atau laporan Anda sedetail mungkin..."></textarea>
        </div>
        
        <button type="submit" class="btn-modern btn-primary-modern" style="width: 100%; padding: 1rem; font-size: 1.1rem; box-shadow: var(--shadow-xl);">
            <i class="fa fa-paper-plane"></i> Kirim Aduan Sekarang
        </button>
    </form>
</div>
