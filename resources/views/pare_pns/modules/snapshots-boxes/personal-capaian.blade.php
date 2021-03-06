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
				<div class="small-box bg-yellow capaian_bulanan" style="cursor:pointer;">
					<div class="inner">
						<h3 class="personal_jm_capaian_bulanan">
							{{$jm_capaian_bulanan}}
						</h3>
						<p>
							<strong>Bulanan</strong>
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
				</div>
			</div>


			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-aqua capaian_triwulan" style="cursor:pointer;">
					<div class="inner">
						<h3 class="personal_jm_capaian_triwulan">
							{{$jm_capaian_triwulan}}
						</h3>
						<p>
							<strong>Triwulan</strong>
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
				</div>
			</div>


			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-red capaian_tahunan" style="cursor:pointer;">
					<div class="inner">
						<h3 class="personal_jm_capaian_tahunan">
							{{$jm_capaian_tahunan}}
						</h3>
						<p>
							<strong>Tahunan</strong>
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-green capaian_gabungan" style="cursor:pointer;">
					<div class="inner">
						<h3 class="personal_jm_capaian_gabungan">
							*
						</h3>
						<p>
							<strong>Gabungan</strong>
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
				</div>
			</div>

			



		</div>
	</div>
</div>


<script>
$(document).ready(function(){

   
	$(".capaian_bulanan").click(function(){
		window.location.assign("capaian-bulanan");
    });

	$(".capaian_triwulan").click(function(){
		window.location.assign("capaian-triwulan");
    });

	$(".capaian_tahunan").click(function(){
		window.location.assign("capaian-tahunan");
	});
	
	$(".capaian_gabungan").click(function(){
		window.location.assign("capaian-gabungan");
    });
	
	

});
</script>