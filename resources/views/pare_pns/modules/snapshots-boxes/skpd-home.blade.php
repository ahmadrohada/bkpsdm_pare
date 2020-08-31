<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h3 class="box-title">
            <small></small>
        </h3>
        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
           </div>
    </div>
	<div class="box-body" style="padding:20px 20px 0px 20px;">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-fuchsia pegawai" style="cursor:pointer;" >
					<div class="inner">
						<h3>
							{{$total_pegawai}}
							
						</h3>
						<p>
							TOTAL PEGAWAI
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-users"></i>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-teal unit_kerja_box" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{$total_unit_kerja}}
						</h3>
						<p>
							UNIT KERJA
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-institution"></i>
					</div>
				</div>
			</div>

			@if ( $skpd_id == 19 )
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-maroon puskesmas" style="cursor:pointer;">
					<div class="inner">
						<h3>{{$total_puskesmas}}</h3>
						<p>PUSKESMAS</p>
					</div>
					<div class="icon">
						<i class="fa fa-hospital-o"></i>
					</div>
				</div>
			</div>
			@endif

			
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-green struktur_organisasi" style="cursor:pointer;">
					<div class="inner">
						<h3>
							&nbsp;
						</h3>
						<p>
							STRUKTUR ORGANISASI
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-sitemap"></i>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-light-blue rencana_kerja" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{$total_pohon_kinerja}}
						</h3>
						<p>
							POHON KINERJA
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-tasks"></i>
					</div>
				</div>
			</div>


			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12" hidden>
				<div class="small-box bg-aqua perjanjian_kinerja" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							PERJANJIAN KINERJA
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-tasks"></i>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-red skp_tahunan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{$total_skp_tahunan}}
						</h3>
						<p>
							SKP TAHUNAN
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>


			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12" hidden>
				<div class="small-box bg-green skp_bulanan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							SKP BULANAN
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-purple tpp_report" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{$total_tpp_report}}
						</h3>
						<p>
							TPP REPORT
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-money"></i>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-yellow capaian_perjanjian_kinerja" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							CAPAIAN PERJANJIAN KINERJA
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-tasks"></i>
					</div>
				</div>
			</div>

		


		</div>
	</div>
</div>


<script>
$(document).ready(function(){

    $(".pegawai").click(function(){
		window.location.assign("pegawai");
    });

	$(".unit_kerja_box").click(function(){
		window.location.assign("unit_kerja");
    });

	$(".struktur_organisasi").click(function(){
		window.location.assign("struktur_organisasi");
    });

	$(".rencana_kerja").click(function(){
		window.location.assign("pohon_kinerja");
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

	$(".tpp_report").click(function(){
		window.location.assign("tpp_report");
    });

	$(".puskesmas").click(function(){
		window.location.assign("puskesmas");
    });

	$(".capaian_perjanjian_kinerja").click(function(){
		window.location.assign("capaian_pk");
    });
	

});
</script>