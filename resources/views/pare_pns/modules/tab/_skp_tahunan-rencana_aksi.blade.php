<div class="row">
	<div class="col-md-12">

		<?php
			switch(  $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan ) {
				case '1': //eselon 2
						
				break;
				case '2': //eselon 3
						if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_irban)){ //JIKA IRBAN
							?>@include('pare_pns.tables.skp_tahunan-rencana_aksi_time_table_3')<?php
						}else{
							?>@include('pare_pns.tables.skp_tahunan-rencana_aksi_time_table_2')<?php
						}
				break;
				case '3': //eselon 4
						if (in_array( $skp->PejabatYangDinilai->id_jabatan, $id_jabatan_lurah)){ //JIKA LURAH
							?>@include('pare_pns.tables.skp_tahunan-rencana_aksi_time_table_2')<?php
						}else{
							?>@include('pare_pns.tables.skp_tahunan-rencana_aksi_time_table_3')<?php
						}
				break;
				case '4': // JFU
						?>@include('pare_pns.tables.skp_tahunan-rencana_aksi_time_table_4')<?php
				break;
				case '5': // JFT
						
				break;
			}
		?>

	</div>
</div>

<script type="text/javascript">
	


</script>
