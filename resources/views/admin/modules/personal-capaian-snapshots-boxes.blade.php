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
				<div class="small-box bg-red skp" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>Create Capaian</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-yellow capaian" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
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


				<div class="col-md-3 col-xs-6">
				<div class="small-box bg-yellow capaian" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
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


				<div class="col-md-3 col-xs-6">
				<div class="small-box bg-yellow capaian" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
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



		</div>
	</div>
</div>


<script>
$(document).ready(function(){

   
	$(".skp").click(function(){
		window.location.assign("personal/skp");
    });

	$(".capaian").click(function(){
		window.location.assign("personal/capaian");
    });

	

});
</script>