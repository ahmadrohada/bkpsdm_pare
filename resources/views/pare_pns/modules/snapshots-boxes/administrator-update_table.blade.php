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
				<div class="small-box bg-red  sasaran" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>UPDATE SASARAN</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-yellow  program" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>UPDATE PROGRAM</strong>
						</p>
					</div>
					<div class="icon">
						<i class="fa  fa-tasks"></i>
					</div>
				</div>
			</div>


			<div class="col-md-3 col-xs-6">
				<div class="small-box bg-purple  kegiatan" style="cursor:pointer;">
					<div class="inner">
						<h3>
							*
						</h3>
						<p>
							<strong>UPDATE KEGIATAN</strong>
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

    $(".sasaran").click(function(){
		$.ajax({
		url     	: '{{ url("api/new_update_sasaran") }}',
		type    	: "GET",
		data    	: {  },
		success		: function (data) {

				

			},
			error: function (data) {
				
			}

		}); 
    });

	$(".program").click(function(){
		$.ajax({
		url     	: '{{ url("api/new_update_program") }}',
		type    	: "GET",
		data    	: {  },
		success		: function (data) {

				

			},
			error: function (data) {
				
			}

		}); 
    });

	$(".kegiatan").click(function(){
		$.ajax({
		url     	: '{{ url("api/new_update_kegiatan") }}',
		type    	: "GET",
		data    	: {  },
		success		: function (data) {

				

			},
			error: function (data) {
				
			}

		}); 
    });

});
</script>