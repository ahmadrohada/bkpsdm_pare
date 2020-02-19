<div class="box box-widget widget-user ">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-black" style="background: url('{{asset('assets/images/bg_profile.png')}}') center center;">
        <h3 class="widget-user-username">
        <font style="font-size:18px; color:white; text-shadow: 1px 1px 1px #000, 3px 3px 5px #000;">
            {{ $nama  }}
        </font>
        </h3>
        <h5 class="widget-user-desc" style="text-shadow: 1px 1px 1px #000, 3px 3px 5px #000;">
            {{ \Auth::user()->pegawai->nip }}
        </h5>
    </div>

    <div class="widget-user-image">
        <img style="border: 3px solid white; padding: 0px; width: 100px; height: 100px; margin-top:0px;" class="img-circle" src="{{ $foto }}" alt="User Avatar">
    </div>
       
    <div class="box-footer">
        <section class="content">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="a"><a href="#a" data-toggle="tab">Profile </a></li>
                    <li class="c"><a href="#c" data-toggle="tab">Security</a></li>
                </ul>
                <div class="tab-content"  style=" min-height:400px; padding:0px;">
                    <div class="active tab-pane" id="a">
                        <div class="box-body" style="margin-top:20px;">
                
                            @if (  \Auth::user()->pegawai->JabatanAktif != null )			
                                    
                                    <strong><i class="fa fa-university margin-r-5"></i> SKPD</strong>
                                    <p class="text-muted">
                                    {{ $skpd }}
                                    </p>
                    
                                    <hr style="margin-top:2px !important;">
                                    <strong><i class="fa  fa-tags margin-r-5"></i> Unit Kerja</strong>
                                    <p class="text-muted">
                                    {{ $unit_kerja }}
                                    </p>
                    
                                    <hr style="margin-top:2px !important;">
                                    <strong><i class="fa   fa-bar-chart margin-r-5"></i>Jenis Jabatan / Eselon</strong>
                                    <p class="text-muted">
                                    {{ $jenis_jabatan }} / 
                                    {{ $eselon }}
                                    </p>
                                    
                                    <hr style="margin-top:2px !important;">
                                    <strong><i class="fa  fa-users margin-r-5"></i> Golongan Terakhir</strong>
                                    <p class="text-muted">
                                    {{ $golongan}} / 
                                    {{ $tmt_golongan }}
                                    </p>
                            @endif
                                    <hr style="margin-top:2px !important;">
                                    <strong><i class="fa   fa-phone margin-r-5"></i> No. Handphone</strong>
                                    <p class="text-muted">
                                    {{ $no_hp }} 
                                    </p>
                    
                                    <hr style="margin-top:2px !important;">
                                    <strong><i class="fa   fa-envelope-o margin-r-5"></i> Email</strong>
                                    <p class="text-muted">
                                    {{ $email }}
                                    </p>
                    
                                    <hr style="margin-top:2px !important;">
                                    <strong><i class="fa   fa-map margin-r-5"></i> Alamat</strong>
                                    <p class="text-muted">
                                    {{ $alamat }}
                                    </p>
                    
                    
                                    <hr style="margin-top:2px !important;">
                                    
                                    
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
                    <div class=" tab-pane" id="c">
                        <!-- CHANGE PASSWORD -->
                        <form  id="update_password" method="POST" action="">
                            <div class="box-body" style="margin-top:20px;">
                                <input class="form-control input-sm" name="username" value="{!! $user->username !!}" type="text" style="display:none;">
                                <div class="form-group old_password ">
                                    <strong><i class="fa   fa-key margin-r-5"></i> Password Lama</strong>
                                    <input class="form-control input-sm old_password" name="old_password" type="password">
                                </div>

                                <hr style="margin-top:8px !important;">
                                <div class="form-group new_password ">
                                    <strong><i class="fa   fa-key margin-r-5"></i> Password Baru</strong>
                                    <input class="form-control input-sm" name="new_password" type="password">
                                </div>

                                <hr style="margin-top:8px !important;">
                                <div class="form-group confirm_password ">
                                    <strong><i class="fa   fa-key margin-r-5"></i> Konfirmasi Password Baru</strong>
                                    <input class="form-control input-sm confirm_password" name="confirm_password" type="password">
                                </div>
                                
                                <hr style="margin-top:8px !important;">
                                <button type="button" class="btn btn-sm btn-info pull-right" id="submit-update_password">Update Password</button>
                               
                            </div>
                        </form>
                    </div>
                </div>			
            </div>
        </section>
        
    </div>
</div>


<script type="text/javascript">
$(document).ready(function() {

    $('.old_password').on('click', function(){
		$('.old_password').removeClass('has-error');
	});

    $('.new_password').on('click', function(){
		$('.new_password').removeClass('has-error');
	});

    $('.confirm_password').on('click', function(){
		$('.confirm_password').removeClass('has-error');
	});

    
    $(document).on('click','#submit-update_password',function(e){
    //alert(user_id);
    
		var data = $('#update_password').serialize();
        $.ajax({
                url		: '{{ url("api_resource/update_password") }}',
                type	: 'POST',
                data	:  data,
                success	: function(data , textStatus, jqXHR) {
                    
                    Swal.fire({
                            title: "",
                            text: "Sukses",
                            type: "success",
                            width: "200px",
                            showConfirmButton: false,
                            allowOutsideClick : false,
                            timer: 1500
                    }).then(function () {
                            
                    },
                        function (dismiss) {
                            if (dismiss === 'timer') {
                                
                            }
                        }
                )	
                },
                error: function(jqXHR , textStatus, errorThrown) {

                    var test = $.parseJSON(jqXHR.responseText);
                    var data= test.errors;
                    $.each(data, function(index,value){
                        //alert (index+":"+value);
                        if (index == 'old_password'){
                            $('.old_password').addClass('has-error');
                        }

                        if (index == 'new_password'){
                            $('.new_password').addClass('has-error');
                        }
                        if (index == 'confirm_password'){
                            $('.confirm_password').addClass('has-error');
                        }
                        
                    }); 
                }
                
        });

    });


    var hash = window.location.hash;
	if ( hash != ''){
		$('#myTab a[href="' + hash + '"]').tab('show');
	}else{
		$('#myTab a[href="#a"]').tab('show');
	}


});
</script>        