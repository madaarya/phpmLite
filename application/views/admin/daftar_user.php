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
        <a href="<?php echo site_url('admin/tambah_user'); ?>" class="btn btn-primary"><i class="icon-plus icon-white"></i> Tambah User</a>
    </div>

    <div class="span4 pull-right">
        <form class="form-search" method="GET" action="<?php echo site_url('admin/cari_user'); ?>" >
            <input type="text" name="kata" class="input-medium search-query" placeholder="nama user.." >
            <button type="submit" class="btn">Cari</button>
        </form>
    </div>

</div>

<br />
<?php echo $user; ?>
<?php echo $this->pagination->create_links(); ?>
