<div class="row">

    <div class="span4 pull-right">
        <form class="form-search" method="GET" action="<?php echo site_url('admin/cari_user'); ?>" >

            <input type="text" name="kata" class="input-medium search-query" placeholder="nama user..">
            <button type="submit" class="btn">Cari</button>
        </form>
    </div>
</div>
<br />
<?php
echo $user . br();
echo anchor("admin/daftar_user", '<i class="icon-chevron-left"></i> Kembali', 'class="btn"');
?>