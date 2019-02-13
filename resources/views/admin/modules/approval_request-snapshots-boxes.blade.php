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
				<div class="small-box bg-blue renja" style="cursor:pointer;" >
					<div class="inner">
						<h3>
							*
							
						</h3>
						<p>
							<strong>Rencana Kerja</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-tasks"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6">
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
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-aqua skp_bulanan" style="cursor:pointer;" >
					<div class="inner">
						<h3>
							*
							
						</h3>
						<p>
							<strong>SKP Bulanan</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa fa-tasks"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-purple pengukuran_bulanan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>Pengukuran Bulanan</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-green pengukuran_tahunan" style="cursor:pointer;" >
					<div class="inner">
						<h3>
							*
							
						</h3>
						<p>
							<strong>Pengukuran Tahunan</strong>
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

	

</script>