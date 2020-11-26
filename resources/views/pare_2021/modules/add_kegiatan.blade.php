<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <small> {{ $jenis_jabatan }} </small>
        </h3>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">




        <a class="btn btn-sm btn-success modalMd" href="#" title=""><span class="fa fa-plus"></span> Tambah Kegiatan</a>


            
		

	</div>
</div>


@include('pare_pns.modals.add-kegiatan')

<script type="text/javascript">


    $(document).on('click','.modalMd',function(e){
        $('.modal-add-kegiatan').modal('show');
	});
	



</script>