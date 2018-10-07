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


            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-warning">28</h5>
                    <span class="description-text text-success">SKP</span>
                </div>
            </div>
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-warning">24</h5>
                    <span class="description-text text-success">CAPAIAN</span>
                </div>
            </div>
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header text-warning">36</h5>
                    <span class="description-text text-success">TPP</span>
                </div>
            </div>


        </div>



        <div class="box-body" style="margin-top:-20px;">
                <input type="text" class="user_id" value="{{ $user_id }}" >
                <hr>
                <strong><i class="fa fa-user margin-r-5"></i> Usename</strong>
                <p class="text-muted">
                {{ $username }}
                <span class="text-success pull-right ubah" style="cursor:pointer;">
					ubah
				</span>
                </p>

                <hr>
                <strong><i class="fa  fa-key margin-r-5"></i> Password</strong>
                <p class="text-muted">
                ******** 
                <span class="text-success pull-right reset" style="cursor:pointer;">
					reset
				</span>
                </p>

                
                
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

@include('admin.modals.ubah-username')
@include('admin.modals.reset-password')


@section('template_scripts')

<script type="text/javascript">
	$(document).ready(function() {


        

        
		$(document).on('click','.ubah',function(e){
			
			user_id = $('.user_id').val();
			//alert(user_id);

            $(".ubah-username").modal('show');
			//window.location.assign("lihat_users");
		});

        $(document).on('click','.reset',function(e){
			
			user_id = $('.user_id').val();
			//alert(pegawai_id);

            $(".reset-password").modal('show');
			//window.location.assign("lihat_users");
		});
		
		
	});
</script>

@endsection