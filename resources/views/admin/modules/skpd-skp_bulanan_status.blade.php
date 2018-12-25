
<div id="myTimeline"></div>
	 
	 
	 <link rel="stylesheet" href="https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css" />
	 <link rel="stylesheet" href="{{asset('assets/timeline/style-albe-timeline.css')}}" />
	 
	 <script src="{{asset('assets/timeline/jquery-albe-timeline.js')}}"></script>
	 
	 <script type="text/javascript">
	 $(document).ready(function() {
		 //Json Object
	 
			 $.ajax({
					 url			: '{{ url("api_resource/skp_bulanan_timeline_status") }}',
					 data 		: {skp_bulanan_id : {!! $skp->id!!} },
					 method		: "GET",
					 dataType	: "json",
					 success	: function(data) {
						 status(data);
						 	
					 },
					 error: function(data){
						 
					 }						
			 });
	 
	 
	 
	 
		 function status(data){
			 $('#myTimeline').albeTimeline(
					 data, 
					 {
					 effect: 'fadeInUp',
					 showGroup: false,
					 language : 'en-us',
					 sortDesc : true,
					 formatDate: 'dd de MMMM de yyyy HH:mm'
			 });	
		 }
	 
		 
	 
		 
	 
	 });
	 </script>
	 