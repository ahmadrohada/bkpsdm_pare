<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">
            <small> {{ $nama_skpd }} </small>
        </h3>
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
						<i class="ion ion-ios-people"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-red" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{$total_users_locked}}
						</h3>
						<p>
							<strong>Locked</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-user-times"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-yellow" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{$total_users_new}}
						</h3>
						<p>
							<strong>New</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-user-plus"></i>
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


});
</script>