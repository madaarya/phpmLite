<script type="text/javascript">
    $(document).ready(function(){
	
        var nomor_full = $("#nomor_full").val();
        var id_session = $("#id_session").val();
		
        $.ajax({
            type:"POST",
            url: "<? echo site_url('admin/update_session_surat'); ?>",
            data: "id_session="+id_session+"&nomor_full="+nomor_full,
            success:function(pesan){
                if (pesan==1)
                {					
                }
            }											
        });
	
    });
</script>
<div class="row">
    <div class="span7 offset3">
        <?php
        if (isset($error)) {
            ?>
            <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><?php echo $error; ?></div>
            <?php
        }
        ?>
        <?php echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>
        <form enctype="multipart/form-data" method="POST" action="<?php echo site_url('admin/proses_confirm_surat_keluar'); ?>" class="form-horizontal">
            <div class="control-group">	   
                <label class="control-label">Nomor Surat</label>
                <div class="controls">
                    <?php if ($jenis == "window_close") { ?>
                        <input type="text" name="format_full" value="<?php echo $nomor_full; ?>" readonly="readonly" />

                    <?php } else { ?>

                        <input type="hidden" id="id_session" value="<?php echo $id_nomor_session; ?>" />
                        <input type="text" name="format_full" id="nomor_full" value="<?php
                        $i = 1;
                        foreach ($hasil as $m) {

                            $f = explode('+', $m->mIsi);

                            if ($f[0] == 'tahun' && $f[1] == 'otomatis') {
                                $f[1] = date('Y');
                            }

                            if ($f[0] == 'bulan' && $f[1] == 'otomatis') {
                                $f[1] = date('m');
                            }

                            if ($f[0] == 'dept') {
                                $f[1] = $this->Surat->ambil_kode_dept($departement);
                            }

                            if ($f[0] == 'start') {
                                $nol = substr_count($f[1], '0');
                                $no_akhir =  $this->Surat->ambil_nomor_terakhir($jenis_surat);
                                if($nol == 4)  {
                                switch ($no_akhir) {
        					case $no_akhir < 10:
            						$f[1] = '0000'.$no_akhir; //00009
            					break;
        					case $no_akhir < 100:
            						$f[1] = '000'.$no_akhir; //00099
            					break;
            					case $no_akhir < 1000:
            						$f[1] = '00'.$no_akhir; //00999
            					break;           					
            					case $no_akhir < 10000:
            						$f[1] = '0'.$no_akhir; //09999
            					break;
            					default:
            						$f[1] = $no_akhir; //1000
            					break;           					
            					}
                                }
                                if($nol == 3)  {
                                	switch ($no_akhir) {
        					case $no_akhir < 10:
            						$f[1] = '000'.$no_akhir; //0009
            					break;
        					case $no_akhir < 100:
            						$f[1] = '00'.$no_akhir; //0099
            					break;
            					case $no_akhir < 1000:
            						$f[1] = '0'.$no_akhir; //0999
            					break;
            					default:
            						$f[1] = $no_akhir; //1000
            					break;           					
            					}
                                }
                                if($nol == 2)  {
                                	switch ($no_akhir) {
        					case $no_akhir < 10:
            						$f[1] = '00'.$no_akhir; //001
            					break;
        					case $no_akhir < 100:
            						$f[1] = '0'.$no_akhir; //010
            					break;
            					default:
            						$f[1] = $no_akhir; //100
            					break;           					
            					}
                                }
                                if($nol == 1) {
                                	if($no_akhir < 10)
                                	{
                                	$f[1] = '0'.$no_akhir; //01
                                	}
                                	else
                                	{
                                	$f[1] = $no_akhir; //10
                                	}
                                }
                                if($nol == 0)
                                {
                                	$f[1] = $no_akhir;
                                }
                            }
                            if ($i == $count) {
                                echo $f[1];
                            } else {
                                echo $f[1].$m->mDelimiter;
                            }
                            $i++;
                        }
                        ?>" readonly="readonly" />

                    <?php } ?>

                    <?php
                    echo form_hidden('jenis_surat', $jenis_surat);
                    echo form_hidden('tanggal', $tanggal);
                    echo form_hidden('judul', $judul);
                    echo form_hidden('kepada', $kepada);
                    echo form_hidden('dari', $dari);
                    echo form_hidden('keterangan', $keterangan);
                    
                    echo form_hidden('tembusan', $tembusan);
                    /*if (!isset($id_user)) {
                        $id_user = $this->session->userdata('userid');
                    }*/
                    /*
                    if (!isset($id_departement)) {
                        $id_departement = $this->session->userdata('departement');
                    }*/

                    echo form_hidden('id_user', $id_user);
                    echo form_hidden('id_departement', $departement);
                    ?>
                </div>
            </div>

            <div class="control-group">    
                <label class="control-label">Berkas</label>
                <div class="controls">
                    <input type="file" name="berkas" /><span class="help-inline">* Format extension : pdf, doc, docx, xls  </span>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Submit</button>
                </div>  
            </div>	
<?php echo form_close(); ?>
    </div>
</div>

