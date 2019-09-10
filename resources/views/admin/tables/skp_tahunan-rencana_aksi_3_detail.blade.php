<div id='rencana_aksi' hidden>
	<div class="box box-primary">
		<div class="box-header with-border">
			<h1 class="box-title">
				Detail Kegiatan Tahunan 
			</h1>

			<div class="box-tools pull-right">
				{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail_detail_kegiatan_tahunan','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}

				{!! Form::button('<i class="fa fa-question-circle "></i>', array('class' => 'btn btn-box-tool bantuan','data-id' => '410', 'title' => 'Bantuan', 'data-toggle' => 'tooltip')) !!}
			</div>
		</div>
		<div class="box-body table-responsive">

			<strong>Kegiatan Tahunan</strong>
			<p class="text-muted " style="margin-top:8px;padding-bottom:8px;">
				<span class="kegiatan_tahunan_label"></span>
				<input type="hidden" class="kegiatan_tahunan_id">
				<input type="hidden" class="kegiatan_renja_id">
			</p>

			<p><strong>Target</strong></p>
			<i class="fa  fa-gg"></i> <span class="txt_ak" style="margin-right:10px;"></span>
			<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
			<i class="fa fa-hourglass-start"></i> <span class="txt_waktu_pelaksanaan" style="margin-right:10px;"></span>
			<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span>

			<hr>
					
			<table class="table table-hover table-condensed">
				<tr class="success">
					<th>No</th>
					<th>Indikator</th>
					<th>Target</th>
				</tr>
			</table>
			<table class="table table-hover table-condensed" id="list_indikator"></table>
			  
		</div>
	</div>

	<div class="box box-primary">
		<div class="box-header with-border">
			<h1 class="box-title">
				List Rencana Aksi
			</h1>

		</div>
		<div class="box-body table-responsive">
			<div class="toolbar">
				
			</div>

			<table id="rencana_aksi_table" class="table table-striped table-hover" >
				<thead>
					<tr>
						<th>No</th>
						<th>RENCANA AKSI</th>
						<th>PELAKSANA</th>
						<th>WAKTU</th>
						<th>TARGET</th>
					</tr>
				</thead>
			</table>

		</div>
	</div>
</div>



<script type="text/javascript">

</script>