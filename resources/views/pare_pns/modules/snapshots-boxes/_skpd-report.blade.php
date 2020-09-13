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
				<div class="small-box bg-yellow tpp_report" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>TPP Report</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa   fa-clipboard"></i>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>


<script>
$(document).ready(function(){

   
	/* $(".tpp_report").click(function(){
		window.location.assign("report/tpp");
    }); */


});
</script>