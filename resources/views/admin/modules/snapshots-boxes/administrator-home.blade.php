<div class="box {{ $h_box}}">
    <div class="box-header with-border">
		<h1 class="box-title">
            
        </h1>
        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-aqua total_pegawai" style="cursor:pointer;" >
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
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-green total_users" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{$total_users_confirmed}}
						</h3>
						<p>
							<strong>User PARE</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-users"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-red total_skpd" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{$total_skpd}}
						</h3>
						<p>
							<strong>SKPD</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-institution"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-yellow masa_pemerintahan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>Masa Pemerintahan</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-hourglass-start"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-yellow pohon_kinerja_skpd" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>Pohon Kinerja SKPD</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-tasks"></i>
					</div> 
				</div>
			</div>

			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-red skp skp_tahunan" style="cursor:pointer;">
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

			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-green tpp_report" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>TPP Report</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-money"></i>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>


<script>
$(document).ready(function(){

    $(".total_pegawai").click(function(){
		window.location.assign("pegawai");
    });

	$(".total_users").click(function(){
		window.location.assign("users");
    });

	$(".total_skpd").click(function(){
		window.location.assign("skpd");
    });

	$(".masa_pemerintahan").click(function(){
		window.location.assign("masa_pemerintahan");
	});

	$(".pohon_kinerja_skpd").click(function(){
		window.location.assign("pohon_kinerja");
    });

	$(".skp_tahunan").click(function(){
		window.location.assign("skp_tahunan");
    });

	$(".tpp_report").click(function(){
		window.location.assign("tpp_report");
    });


});
</script>