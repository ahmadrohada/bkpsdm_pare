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




            <div class="modal fade modal-primary" id="confirmSave" role="dialog" aria-labelledby="confirmSaveLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> {{ Lang::get('modals.confirm_modal_title_text') }} </h4>
                        </div>
                        <div class="modal-body">
                            <p>{{ Lang::get('modals.confirm_modal_title_std_msg') }}</p>
                        </div>
                        <div class="modal-footer">
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-outline pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                            {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-outline pull-right btn-flat', 'type' => 'button', 'id' => 'confirm' )) !!}
                        </div>
                    </div>
                </div>
            </div>
		

	</div>
</div>

<script type="text/javascript">




// CONFIRMATION SAVE MODEL
$('#confirmSave').on('show.bs.modal', function (e) {
    var message = $(e.relatedTarget).attr('data-message');
    var title = $(e.relatedTarget).attr('data-title');
    var form = $(e.relatedTarget).closest('form');
    $(this).find('.modal-body p').text(message);
    $(this).find('.modal-title').text(title);
    $(this).find('.modal-footer #confirm').data('form', form);
});
$('#confirmSave').find('.modal-footer #confirm').on('click', function(){
      $(this).data('form').submit();
});

// CONFIRMATION DELETE MODAL
$('#confirmDelete').on('show.bs.modal', function (e) {
    var message = $(e.relatedTarget).attr('data-message');
    var title = $(e.relatedTarget).attr('data-title');
    var form = $(e.relatedTarget).closest('form');
    $(this).find('.modal-body p').text(message);
    $(this).find('.modal-title').text(title);
    $(this).find('.modal-footer #confirm').data('form', form);
});
$('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
      $(this).data('form').submit();
});

</script>