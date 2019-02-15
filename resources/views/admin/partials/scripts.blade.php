{{-- GLOBAL ADMIN SCRIPTS --}}



<!--
{!! HTML::script('/assets/bower_components/jquery/dist/jquery.min.js', array('type' => 'text/javascript')) !!}
{!! HTML::script('/assets/bower_components/data-table/DataTables-1.10.18/js/dataTables.bootstrap.js', array('type' => 'text/javascript')) !!}
{!! HTML::script('/assets/bower_components/data-table/DataTables-1.10.18/js/dataTables.buttons.min.js', array('type' => 'text/javascript')) !!}
{!! HTML::script('/assets/bower_components/data-table/DataTables-1.10.18/js/dataTables.select.min.js', array('type' => 'text/javascript')) !!}
{!! HTML::script('/assets/bower_components/data-table/DataTables-1.10.18/js/dataTables.editor.min.js', array('type' => 'text/javascript')) !!}


-->



{!! HTML::script('/assets/js/admin/admin.js', array('type' => 'text/javascript')) !!}

{!! HTML::script('/assets/bower_components/sweetalert/sweetalert2.all.js', array('type' => 'text/javascript')) !!}



{!! HTML::script('/assets/bower_components/jquery-datetimepicker/jquery.datetimepicker.full.min.js', array('type' => 'text/javascript')) !!}
{!! HTML::script('/assets/bower_components/select2/dist/js/select2.full.js', array('type' => 'text/javascript')) !!}




<script type="text/javascript">
      //alert();

     
     function formatRupiah(angka, prefix)
      {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split	= number_string.split(','),
          sisa 	= split[0].length % 3,
          rupiah 	= split[0].substr(0, sisa),
          ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);
          
        if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
      }

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
</script>


