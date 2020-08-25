{{-- GLOBAL ADMIN SCRIPTS --}}



{!! HTML::script('public/assets/js/admin/admin.js', array('type' => 'text/javascript')) !!}

{!! HTML::script('public/assets/js/sweetalert2.all.min.js', array('type' => 'text/javascript')) !!}

{!! HTML::script('public/assets/js/dataTables.rowsGroup.js', array('type' => 'text/javascript')) !!}


{!! HTML::script('public/assets/bower_components/jquery-datetimepicker/jquery.datetimepicker.full.min.js', array('type' => 'text/javascript')) !!}
{!! HTML::script('public/assets/bower_components/select2/dist/js/select2.full.js', array('type' => 'text/javascript')) !!}

{!! HTML::script('public/assets/bower_components/dropzone/dist/dropzone.js', array('type' => 'text/javascript')) !!}




<script type="text/javascript">
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

     


      

      function show_loader(){
        Swal.fire({
            title				: "Memproses data...",
            text				: "Harap tunggu",
            imageUrl			: "{{asset('assets/images/loader/loading.gif')}}",
            showConfirmButton	: false,
            allowOutsideClick 	: false,
            closeOnClickOutside	: false,
			closeOnEsc			: false,
			//backdrop			: false,
			//background			: "#cbef9f",
			
          })
      }

	  function show_loader_2(){
        Swal.fire({
            title				: "",
            text				: "sedang memuat data",
            imageUrl			: "{{asset('assets/images/loader/loading.gif')}}",
            showConfirmButton	: false,
            allowOutsideClick 	: false,
            closeOnClickOutside	: false,
			closeOnEsc			: false,
			backdrop			: false,
			background			: "#cbef9f",
          })
	  }
	  
      /* Fungsi */
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

	

	
      

</script>


