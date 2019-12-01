<div class="modal fade modal-tpp_report_data" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    TPP Report Data 
                </h4>
            </div>

            <form  id="kegiatan_tahunan_form" method="POST" action="">
			<input type="hidden"  name="sasaran_id" class="sasaran_id">
			<div class="modal-body">
				<div class="form-group">
					<label>Golongan</label>
					<p class="label-perjanjian-kinerja">
						<span class="golongan"></span>
					</p>
				</div>
				<div class="form-group">
					<label>Jabatan</label>
					<p class="label-perjanjian-kinerja">
						<span class="jabatan"></span>
					</p>
				</div>
				<div class="form-group">
					<label>Eselon</label>
					<p class="label-perjanjian-kinerja">
						<span class="eselon"></span>
					</p>
				</div>
				<div class="form-group">
					<label>Unit Kerja</label>
					<p class="label-perjanjian-kinerja">
						<span class="unit_kerja"></span>
					</p>
				</div>
				
			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').' button_simpan" aria-hidden="true"></i> <span name="text_button_submit"></span>', array('class' => 'btn btn-primary btn-sm pull-right btn-flat btn-submit', 'type' => 'button', 'id' => 'simpan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">




</script>