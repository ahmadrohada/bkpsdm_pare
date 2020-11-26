<div class="modal fade modal-add-kegiatan" id="confirmSave" role="dialog" aria-labelledby="confirmSaveLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> {{ Lang::get('modals.confirm_modal_title_text') }} </h4>
                        </div>
                        <div class="modal-body">
                            
                        <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" placeholder="Email">
                </div>
                <br>

                <div class="input-group">
                    <input type="text" class="form-control">
                    <span class="input-group-addon"><i class="fa fa-check"></i></span>
                </div>
                <br>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                    <input type="text" class="form-control">
                    <span class="input-group-addon"><i class="fa fa-ambulance"></i></span>
                </div>
                            



                        </div>
                        <div class="modal-footer">
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-primary pull-right btn-flat', 'type' => 'button', 'id' => 'confirm' )) !!}
                        </div>
                    </div>
                </div>
            </div>