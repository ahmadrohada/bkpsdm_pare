<div class="box {{ $h_box}}">
    <div class="box-header with-border">
		<h1 class="box-title">
            
        </h1>
        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body" style="padding:20px 20px 0px 20px;">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-fuchsia total_pegawai" style="cursor:pointer;" >
					<div class="inner">
						<h3>{{$total_pegawai}}</h3>
						<p>TOTAL PEGAWAI</p>
					</div>
					<div class="icon">
						<i class="fa fa-users"></i>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-green total_users" style="cursor:pointer;">
					<div class="inner">
						<h3>{{$total_users}}</h3>
						<p>USER PARE</p>
					</div>
					<div class="icon">
						<i class="fa fa-users"></i>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-teal total_skpd" style="cursor:pointer;">
					<div class="inner">
						<h3>{{$total_skpd}}</h3>
						<p>SKPD</p>
					</div>
					<div class="icon">
						<i class="fa  fa-institution"></i>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12" hidden>
				<div class="small-box bg-yellow masa_pemerintahan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							&nbsp;
						</h3>
						<p>MASA PEMERINTAHAN</p>
					</div>
					<div class="icon">
						<i class="fa fa-hourglass-start"></i>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-light-blue pohon_kinerja_skpd" style="cursor:pointer;">
					<div class="inner">
						<h3>{{$total_pohon_kinerja}}</h3>
						<p>POHON KINERJA</p>
					</div>
					<div class="icon">
						<i class="fa fa-tasks"></i>
					</div> 
				</div>
			</div>

			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-red skp skp_tahunan" style="cursor:pointer;">
					<div class="inner">
						<h3>{{$total_skp_tahunan}}</h3>
						<p>SKP TAHUNAN</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-purple tpp_report" style="cursor:pointer;">
					<div class="inner">
						<h3>{{$total_TPP_report}}</h3>
						<p>TPP REPORT</p>
					</div>
					<div class="icon">
						<i class="fa  fa-money"></i>
					</div>
				</div>
			</div>

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
	
	$(".puskesmas").click(function(){
		window.location.assign("puskesmas");
    });


});
</script>