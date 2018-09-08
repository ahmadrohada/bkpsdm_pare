<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">
            <small> {{ $nama_skpd }} </small>
        </h3>
        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body">
		<div class="row">
		
			<div class="col-md-3 col-xs-6 jpt" style="cursor:pointer;">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3>
							{{ $jabPTP }}
						</h3>
						<p>
							<strong class="hidden-xs">Pimpinan Tinggi Pratama</strong>
							<strong class="hidden-lg">JPT</strong>
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-ios-people"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6 administrator" style="cursor:pointer;">
				<div class="small-box bg-green">
					<div class="inner">
						<h3>
							{{ $administrator }}
						</h3>
						<p>
							<strong>Administrator</strong>
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-ios-people"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6 pengawas" style="cursor:pointer;">
				<div class="small-box bg-red">
					<div class="inner">
						<h3>
							{{ $pengawas }}
						</h3>
						<p>
							<strong>Pengawas</strong>
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-ios-people"></i>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-xs-6 jfu-jft" style="cursor:pointer;">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3>
							{{ $pelaksana_fungsional }}
						</h3>
						<p>
							<strong class="hidden-xs">Pelaksana & Fungsional</strong>
							<strong class="hidden-lg">JFU & JFT</strong>
						</p>
					</div>
					<div class="icon">
						<i class="ion ion-ios-people"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
	

	$(document).on('click','.jpt',function(){
	
		window.location =  "{{  URL::to('skpd/distribusi-kegiatan/jpt')}}";
	});
	$(document).on('click','.administrator',function(){
	
		window.location =  "{{  URL::to('skpd/distribusi-kegiatan/administrator')}}";
	});
	$(document).on('click','.pengawas',function(){
	
		window.location =  "{{  URL::to('skpd/distribusi-kegiatan/pengawas')}}";
	});
	$(document).on('click','.jfu-jft',function(){
	
		window.location =  "{{  URL::to('skpd/distribusi-kegiatan/jfujft')}}";
	});



});
</script>
