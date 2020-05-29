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
				<div class="small-box bg-teal skp_jabatan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							&nbsp;
						</h3>
						<p>
							<strong>Create SKP</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-red skp_tahunan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{ $jm_skp_tahunan }}
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

			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-green skp_bulanan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							{{ $jm_skp_bulanan }}
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

   
	$(".skp_jabatan").click(function(){
		window.location.assign("skp_jabatan");
    });

	$(".skp_tahunan").click(function(){
		window.location.assign("skp_tahunan");
    });

	$(".skp_bulanan").click(function(){
		window.location.assign("skp_bulanan");
    });

	

});
</script>