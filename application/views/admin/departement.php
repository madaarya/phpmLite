<?php if (isset($sukses)) { ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button><?php echo $sukses; ?></div>
<? } ?>
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
<a href="<?php echo site_url('admin/tambah_departement'); ?>" class="btn btn-primary"><i class="icon-plus icon-white"></i> Tambah departement</a>
<br />
<br />

<?php echo $departement; ?>
