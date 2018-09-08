<div class="modal fade add-kegiatan_skp_tahunan_modal" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Add Kegiatan SKP Tahunan
                </h4>
            </div>

            <form  id="add-kegiatan_skp_tahunan-form" method="POST" action="">

			<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
						<label class="control-label">Kegiatan Perjanjian Kinerja:</label>
							<select class="form-control kegiatan_pk" id="kegiatan_pk" name="kegiatan_pk" style="width:100%;">
								@foreach( $kegiatan_pk as $x )
									<option value="{{ $x->id }}" >{{ $x->label }}</option>
								@endforeach 
							</select>
						</div>
					</div>
					<br>

					<div class="row">
						<div class="col-md-12">
						<label class="control-label">Kegiatan :</label>
						<textarea name="label" rows="5" required class="form-control" id="label" placeholder="Kegiatan" style="resize:none;"></textarea>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4 ak_field">
						<label class="control-label">Angka Kredit :</label>
						<input type="text" name="angka_kredit" id="angka_kredit" required class="form-control input-sm" placeholder="AK" maxlength="5" onkeypress='return angka(event)'>
						</div>
					
						<div class="col-md-4">
						<label class="control-label">Output :</label>
						<input type="text" name="quantity" id="quantity" required class="form-control input-sm" placeholder="qty" onkeypress='return angka(event)'>        
						</div>

						<div class="col-md-4">
						<label class="control-label">Satuan :</label>
						<input type="text" name="satuan" autocomplete="off" id="satuan" required class="form-control satuan input-sm" placeholder="satuan">
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
						<label class="control-label">Kualitas/Mutu :</label>
						<div class="input-group input-group-sm">
						<input type="text" name="quality" id="quality" required class="form-control"  placeholder="kualitas/mutu" maxlength="3" onkeypress='return angka(event)'>
						<span class="input-group-addon">%</span>
						</div>
						</div>
						<div class="col-md-4">
						<label class="control-label">Target Waktu :</label>
						<div class="input-group input-group-sm">
						<input type="text" name="target_waktu" id="target_waktu" required class="form-control" maxlength="2" onkeypress='return angka(event)'>
						<span class="input-group-addon">Bulan</span>
						</div>
						</div>
						<div class="col-md-4">
						<label class="control-label">Biaya Kegiatan :</label>
						<div class="input-group input-group-sm">
						<span class="input-group-addon">Rp.</span>
						<input type="text" name="cost" id="cost" required class="form-control" placeholder="biaya kegiatan" maxlength="14" onkeypress='return angka(event)'>
						</div>
						</div>
					</div>



			</div>
			<div class="modal-footer">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-primary btn-sm pull-right btn-flat', 'type' => 'button', 'id' => 'simpan_kegiatan_skp_tahunan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">
$(document).ready(function() {

	$('.kegiatan_pk').select2();
   


});
</script>