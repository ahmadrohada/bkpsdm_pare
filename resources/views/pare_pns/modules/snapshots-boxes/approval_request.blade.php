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
				<div class="small-box bg-teal capaian_bulanan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>Capaian Bulanan</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-3 col-xs-12">
				<div class="small-box bg-purple capaian_tahunan" style="cursor:pointer;" >
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>Capaian Tahunan</strong>
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
	$(".renja").click(function(){
		window.location.assign("renja_approval-request");
	});
	$(".capaian_bulanan").click(function(){
		window.location.assign("capaian_bulanan_approval-request");
    });
	$(".capaian_tahunan").click(function(){
		window.location.assign("capaian_tahunan_approval-request");
    });
</script>