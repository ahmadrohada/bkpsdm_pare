
<div class="row">
	<div class="col-md-8">
		<div class="table-responsive">
			<div id="general_timeline"></div>
		</div>
	</div>
	<div class="col-md-4">

	
		
	</div>


</div>









	 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css" />
<link rel="stylesheet" href="{{asset('assets/timeline/style-albe-timeline.css')}}" />

<script src="{{asset('assets/timeline/jquery-albe-timeline.js')}}"></script>

<script type="text/javascript">


	function status_show(){
		$.ajax({
				url			: '{{ url("api_resource/skp_tahunan_general_timeline") }}',
				data 		: { 
								renja_id : {!! $skp->Renja->id !!}
								},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					status(data);	
				},
				error: function(data){
					
				}						
		});
	}

	function status(data){
		$('#general_timeline').albeTimeline(
				data, 
				{
				effect: 'fadeIn',
				showGroup: false,
				language : 'en-us',
				sortDesc : true,
				formatDate: 'dd de MMMM de yyyy HH:mm'
		});	
	}


</script>
