<div class="container" style="margin-top: 60px;">
		<a href="#form" data-toggle="modal" class="btn btn-primary" onclick="submit('tambah')">Tambah Data</a>
        <a href="<?php echo base_url('admin/data_verifikasi/cetak')?>" class="btn btn-warning">Cetak PDF</a>
        <a href="<?php echo base_url('admin/data_verifikasi/cetak_xls')?>" class="btn btn-success">Cetak XLS</a>
        <br>
		<div class="col-md-12">
        <br>
			<table id="data" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<td scope="col">Id Tanggapan</td>
						<td scope="col">ID Pengaduan</td>
						<td scope="col">Tanggal Tanggapan</td>
						<td scope="col">Tulis Tanggapan</td>
						<td scope="col">ID Petugas</td>
                        <td scope="col">Aksi</td>
					</tr>
				</thead>
				<tbody id="target">

				</tbody>
			</table>
		</div>
	</div>
	<div class="modal fade" id="form" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1>Data Tanggapan</h1>
				</div>
               <center><font color=red><p id="pesan"></p></font></center>
				<table class="table">
					<tr>
						<td>Id Pengaduan</td>
						<td>
                            <input type="text" name="id_pengaduan" placeholder="Id Pengaduan" class="form-control">
                            <input type="hidden" name="id_tanggapan" value="">
                        </td>
					</tr>
					<tr>
						<td>Tanggal Tanggapan</td>
						<td>
                            <input type="text" name="tgl_tanggapan" placeholder="Tanggal Tanggapan" class="form-control">
                        </td>
					</tr>
					<tr>
						<td>Tulis Tanggapan</td>
						<td>
                            <input type="text" name="tanggapan" placeholder="Tulis Tanggapan" class="form-control">
                        </td>
					</tr>
					<tr>
						<td>Id Petugas</td>
						<td>
                            <input type="text" name="id_petugas" placeholder="Id Petugas" class="form-control">
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
                            <button type="button" id="btn-tambah" onclick="tambahdata()" class="btn btn-success">Tambah</button>
                            <button type="button" id="btn-ubah" onclick="ubahdata()" class="btn btn-success">Ubah</button>
                            <button type="button" data-dismiss="modal" class="btn btn-danger">Batal</button>
                        </td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		ambilData();

		function ambilData() {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()."admin/data_verifikasi/ambilData" ?>',
				dataType: 'json',
				success: function (data) {
					var baris = '';
					for (var i = 0; i < data.length; i++) {
						baris += '<tr>' +
							'<td>' + data[i].id_tanggapan + '</td>' +
							'<td>' + data[i].id_pengaduan + '</td>' +
							'<td>' + data[i].tgl_tanggapan + '</td>' +
							'<td>' + data[i].tanggapan + '</td>' +
                            '<td>' + data[i].id_petugas + '</td>' +
                            '<td><a href="#form" data-toggle="modal" class="btn btn-primary" onclick="submit('+data[i].id_tanggapan+')">Edit</a> <a onclick="hapusdata('+data[i].id_tanggapan+')" class="btn btn-danger">Hapus</a> <a class="btn btn-success">Verifikasi</a> </td>' +
							'</tr>';
					}
					$('#target').html(baris);
				}
			});
        }
        
        function tambahdata()
        {
            var id_pengaduan=$("[name='id_pengaduan']").val();
            var tgl_tanggapan=$("[name='tgl_tanggapan']").val();
            var tanggapan=$("[name='tanggapan']").val();
            var id_petugas=$("[name='id_petugas']").val();

            $.ajax({
                type: 'POST',
                data: 'id_pengaduan=' +id_pengaduan +
                '&tgl_tanggapan='+ tgl_tanggapan+
                '&tanggapan='+ tanggapan+
                '&id_petugas='+ id_petugas,

                url: '<?php echo base_url("admin/data_verifikasi/tambahdata")?>',
                dataType: 'json',
                success: function(hasil){
                    $('#pesan').html(hasil.pesan);

                    if (hasil.pesan == '') {
                        $('#form').modal('hide');
                        ambilData();

                        $("[name='id_pengaduan']").val('');
                        $("[name='tgl_tanggapan']").val('');
                        $("[name='tanggapan']").val('');
                        $("[name='id_petugas']").val('');

                    }
                }
            });
        }

        function submit(x)
        {
            if(x=='tambah')
            {
                $('#btn-tambah').show();
                $('#btn-ubah').hide();
            } else {
                $('#btn-tambah').hide();
                $('#btn-ubah').show();


                $.ajax({
                    type: 'POST',
                    data: 'id_tanggapan='+x,
                    url: '<?php echo base_url().'admin/data_verifikasi/ambilId'?>',
                    dataType: 'json',
                    success: function(hasil){
                        $("[name='id_tanggapan']").val(hasil[0].id_tanggapan);
                        $("[name='id_pengaduan']").val(hasil[0].id_pengaduan);
                        $("[name='tgl_tanggapan']").val(hasil[0].tgl_tanggapan);
                        $("[name='tanggapan']").val(hasil[0].tanggapan);
                        $("[name='id_petugas']").val(hasil[0].id_petugas);
                    }
                })

            }
        }

        function ubahdata()
        {
            var id_tanggapan=$("[name='id_tanggapan']").val();
            var id_pengaduan=$("[name='id_pengaduan']").val();
            var tgl_tanggapan=$("[name='tgl_tanggapan']").val();
            var tanggapan=$("[name='tanggapan']").val();
            var id_petugas=$("[name='id_petugas']").val();


            $.ajax({
                type: 'POST',
                data:  'id_tanggapan=' +id_tanggapan +
                '&id_pengaduan=' +id_pengaduan +
                '&tgl_tanggapan='+ tgl_tanggapan+
                '&tanggapan='+ tanggapan+
                '&id_petugas='+ id_petugas,
                url: '<?php echo base_url().'admin/data_verifikasi/ubahdata' ?>',
                dataType: 'json',
                success: function (hasil) {
                    $('#pesan').html(hasil.pesan);

                    if (hasil.pesan == '') {
                        $('#form').modal('hide');
                        ambilData();
                    }
                }
            });
        }

        function hapusdata(id_tanggapan)
        {
            var tanya = confirm('Apakah anda yakin akan menghapus data?');

            if(tanya)
            {
                $.ajax({
                    type: 'POST',
                    data: 'id_tanggapan='+id_tanggapan,
                    url: '<?php echo base_url()."admin/data_verifikasi/hapusdata" ?>',
                    success: function()
                    { 
                        ambilData();
                     }
                });
            }
        }

	</script>