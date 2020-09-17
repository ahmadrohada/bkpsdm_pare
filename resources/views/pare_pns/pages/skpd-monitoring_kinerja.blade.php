@extends('pare_pns.layouts.dashboard')

@section('template_title')
{{ Pustaka::capital_string(\Auth::user()->Pegawai->JabatanAktif->SKPD->skpd )  }}
@stop
  
 
@section('content')
	 <div class="content-wrapper" >
	    <section class="content-header">
			<h1>
				<a class="back_button" data-toggle="tooltip" title="kembali" href="{{ route('skpd-capaian_pk_triwulan') }}"><span class="fa fa-angle-left"></span></a>
				Monitoring Kinerja
			</h1>
				{!! Breadcrumbs::render('skpd-pohon_kinerja') !!}
      </section>
	  
	    <section class="content">
			
			@include('pare_pns.tables.skpd-monitoring_kinerja')
	    </section>
	</div>
<script type="text/javascript">
$(document).ready(function() {
	
	

});
</script>


@stop

