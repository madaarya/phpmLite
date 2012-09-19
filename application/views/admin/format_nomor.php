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
<br />

<?php
echo $this->session->flashdata('delete') . br();
echo $tombol_new;
?>
<br />
<br />

<?php echo $nomor; ?>
<?php echo $this->pagination->create_links(); ?>
