<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
			Jabatan {!!  $jenis_jabatan !!}
        </h3>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="user_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>JABATAN</th>
					<th>JENIS</th>
					<th>UNIT KERJA</th>
					<th>ACTION</th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>

