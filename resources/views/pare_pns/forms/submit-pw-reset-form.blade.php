{!! Form::open(array('url' => url('/password/nip'), 'method' => 'POST', 'class' => 'lockscreen-credentials form-horizontal', 'role' => 'form')) !!}
	{!! csrf_field() !!}

    <div class="lockscreen-item">
        <div class="lockscreen-image">
        	{{-- Havent decided what to put here yet - jk --}}
            {!! HTML::image('http://placekitten.com/g/128/128', 'User Image', array('class' => '')) !!}
        </div>

	    <div class="input-group">
	        {!! Form::text('nip', null, array('id' => 'nip', 'class' => 'form-control', 'placeholder'   => Lang::get('auth.ph_nip'),'value' => '','required' => 'required',)) !!}
	        <div class="input-group-btn">
	            {!! Form::button('<i class="fa fa-arrow-right text-muted"></i>', array('class' => 'btn','type' => 'submit')) !!}
	        </div>
	    </div>

	</div>

	{!! Form::label('nip', Lang::get('auth.nip'), array('class' => 'help-block text-center control-label sr-only')); !!}

{!! Form::close() !!}