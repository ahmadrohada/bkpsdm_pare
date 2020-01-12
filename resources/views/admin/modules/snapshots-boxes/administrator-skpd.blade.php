<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h3 class="box-title">
            <small></small>
        </h3>
        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
           </div>
    </div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-aqua pegawai" style="cursor:pointer;" >
					<div class="inner">
						<h3>
							{{$total_pegawai}}
							
						</h3>
						<p>
							<strong>Total Pegawai</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-users"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6 hidden">
				<div class="small-box bg-red unit_kerja" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{$total_unit_kerja}}
						</h3>
						<p>
							<strong>Unit Kerja</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-institution"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-green struktur_organisasi" style="cursor:pointer;">
					<div class="inner">
						<h3>
							&nbsp;
						</h3>
						<p>
							<strong>Struktur Organisasi</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-sitemap"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6 hidden">
				<div class="small-box bg-yellow rencana_kerja" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>Renja</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-tasks"></i>
					</div>
				</div>
			</div>


			<div class="col-md-3 col-xs-6 hidden">
				<div class="small-box bg-aqua perjanjian_kinerja" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>Perjanjian Kinerja</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-tasks"></i>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-xs-6 hidden">
				<div class="small-box bg-red skp_tahunan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>SKP Tahunan</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>


			<div class="col-md-3 col-xs-6" hidden>
				<div class="small-box bg-green skp_bulanan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>SKP Bulanan</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>


<script>
$(document).ready(function(){

    $(".pegawai").click(function(){
		window.location.assign("./pegawai");
    });

	$(".unit_kerja").click(function(){
		window.location.assign("unit-kerja");
    });

	$(".struktur_organisasi").click(function(){
		window.location.assign("struktur-organisasi");
    });

	$(".rencana_kerja").click(function(){
		window.location.assign("renja");
    });

	$(".perjanjian_kinerja").click(function(){
		window.location.assign("perjanjian_kinerja");
    });

	$(".skp_tahunan").click(function(){
		window.location.assign("skp_tahunan");
    });

	$(".skp_bulanan").click(function(){
		window.location.assign("skp_bulanan");
    });


});
</script>