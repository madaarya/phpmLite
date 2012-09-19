<?php foreach ($surat_keluar->result() as $s) { ?>
    <p>
        <label><b>Jenis Surat</b></label>
        <span class="badge badge-info"><?php echo $s->fJenis_surat; ?></span>
    </p>

    <p>
        <label><b>Tanggal</b></label>
        <?php echo format_indo($s->sWaktu); ?>
    </p>

    <p>
        <label><b>Nomor Surat</b></label>
        <?php echo $s->sNomorfull; ?>
    </p>

    <p>
        <label><b>Perihal</b></label>
        <?php echo $s->sJudul; ?>
    </p>

    <p>
        <label><b>Kepada</b><label>
        <?php echo $s->sKepada; ?>
    </p>

    <p>
        <label><b>Dari</b></label>
        <?php echo $s->sDari; ?>
    </p>

    <p>
        <label><b>Keterangan</b></label>
        <?php
        if (!empty($s->sKeterangan)) {
            echo $s->sKeterangan;
        } else {
            echo "-";
        }
        ?>
    </p>

    <p>
        <label><b>File</b></label>
    <?php echo anchor("admin/ambil/" . $s->sBerkas, $s->sBerkas); ?>
    </p>

    <p>
        <label><b>Tanggal pembuatan :</b></label><?php echo format_indo_full($s->sWaktu_pembuatan); ?> oleh <?php echo $s->uNama; ?>
    </p>
<? } ?>
