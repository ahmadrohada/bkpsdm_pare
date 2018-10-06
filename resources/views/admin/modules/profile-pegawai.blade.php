<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">
            Profil Pegawai 
            
        </h3>
        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body" style="margin-left:20px;">
        <strong><i class="fa    fa-sitemap margin-r-5"></i> Jabatan</strong>
                <p class="text-muted">
                {{ $jabatan }}
                </p>

               
                <hr>
                <strong><i class="fa   fa-bar-chart margin-r-5"></i> Eselon</strong>
                <p class="text-muted">
                {{ $jenis_jabatan }} / 
                {{ $eselon }}
                </p>

                <hr>
                <strong><i class="fa  fa-users margin-r-5"></i> Golongan Terakhir</strong>
                <p class="text-muted">
                {{ $golongan}} / 
                {{ $tmt_jabatan }}
                </p>

                <hr>
                <strong><i class="fa   fa-phone margin-r-5"></i> No. Handphone</strong>
                <p class="text-muted">
                {{ $no_hp }} 
                </p>

                <hr>
                <strong><i class="fa   fa-envelope-o margin-r-5"></i> Email</strong>
                <p class="text-muted">
                {{ $email }}
                </p>

                <hr>
                <strong><i class="fa   fa-map margin-r-5"></i> Alamat</strong>
                <p class="text-muted">
                {{ $alamat }}
                </p>


                <hr>
                
                
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

          