<?php
if ($this->session->flashdata('sukses')) {
    ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $this->session->flashdata('sukses'); ?>
    </div>
    <?php
}
?>
<div class="row">
    <div class="span2">
        <?php echo $tombol_new; ?>
    </div>

    <div class="span6 pull-right">
        <form class="form-search" method="GET" action="<?php echo site_url('admin/cari_surat'); ?>" >
            Cari berdasarkan
            <select name="kategori" class="span2">
                <option value="sJudul">Judul</option>
                <option value="sNomorfull">Nomor</option>
                <option value="sIDformat_nomor">Jenis Surat</option>
            </select>
            <input type="text" class="input-medium search-query" name="kata" >
            <button type="submit" class="btn">Cari</button>
        </form>
    </div>

</div>
<br />
<?php echo $surat; ?>
<?php echo $this->pagination->create_links(); ?>

