<div class="box {{ $h_box }}" style="min-height:440px;">
    <div class="box-header with-border">
        <h1 class="box-title">
           Struktur Organisasi
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body">

		<div id="strukturorganisasi" style="width: 100%; min-height: 480px; " />

	</div>
</div>

@section('template_scripts')

@include('admin.structure.dashboard-scripts')

	

<!-- <link rel="stylesheet" href="../assets/org_diagram/js/jquery/ui-lightness/jquery-ui-1.10.2.custom.css" /> 
<script src="../assets/org_diagram/js/jquery/jquery-1.9.1.js"></script>
<script src="../assets/org_diagram/js/jquery/jquery-ui-1.10.2.custom.min.js"></script>
-->

<link   href="{{asset('assets/org_diagram/css/primitives.latest.css')}}" media="screen" rel="stylesheet" type="text/css" />


<script src="{{asset('assets/org_diagram/js/primitives.latest.js')}}"></script>



<script type="text/javascript">
$(document).ready(function() {
	

    $.ajax({
			url		: "{{ url("api_resource/skpd_struktur_organisasi") }}",
			method	: "GET",
			dataType: "json",
			data    : { skpd_id : {{$skpd_id}} },
			success	: function(data) {
                
            jQuery("#strukturorganisasi").orgDiagram({
                items: data,
                cursorItem : 0 
            });
      
						
			},
			error: function(data){
				
			}
		});
          


});


</script>

@endsection