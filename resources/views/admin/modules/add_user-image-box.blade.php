<div class="box box-widget widget-user ">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-black" style="background: url('{{asset('assets/images/bg_profile.png')}}') center center;">
        <h3 class="widget-user-username">
        <font style="font-size:18px; color:white; text-shadow: 1px 1px 1px #000, 3px 3px 5px #000;">
            {{ $nama  }}
        </font>
        </h3>
        <h5 class="widget-user-desc" style="text-shadow: 1px 1px 1px #000, 3px 3px 5px #000;">
            {{ $nip }}
        </h5>
    </div>

    <div class="widget-user-image">
        <img style="border: 3px solid white; padding: 0px; width: 100px; height: 100px; margin-top:0px;" class="img-circle" src="{{ $foto }}" alt="User Avatar">
    </div>
       
    <div class="box-footer">
        <div class="row" style="margin-top:15px;">




        </div>



        <div class="box-body" style="margin-top:-20px;">
                <input type="hidden" class="pegawai_id" value="{{ $pegawai_id }}" >
                <input type="hidden" class="nip" value="{{ $nip }}" >
                <hr>
                
                <button class="btn btn-block btn-info add_user">Add to PARE</button>
                
                 <!--  
              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>

              -->
            </div> 


    </div>
</div>

@include('admin.modals.add-user')


@section('template_scripts')

<script type="text/javascript">
	$(document).ready(function() {


        

        
		$(document).on('click','.add_user',function(e){
			
			pegawai_id = $('.pegawai_id').val();
            nip = $('.nip').val();
			//alert(pegawai_id);
            $(".add-user").modal('show');

		});
		
		
	});
</script>

@endsection