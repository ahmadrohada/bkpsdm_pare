{{-- GLOBAL ADMIN SCRIPTS --}}



{!! HTML::script('/assets/js/admin/admin.js', array('type' => 'text/javascript')) !!}

{!! HTML::script('/assets/js/sweetalert2.all.min.js', array('type' => 'text/javascript')) !!}



{!! HTML::script('/assets/bower_components/jquery-datetimepicker/jquery.datetimepicker.full.min.js', array('type' => 'text/javascript')) !!}
{!! HTML::script('/assets/bower_components/select2/dist/js/select2.full.js', array('type' => 'text/javascript')) !!}




<script type="text/javascript">
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
</script>


