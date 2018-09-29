<div class="box box-widget widget-user ">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-black" style="background: url('{{asset('assets/images/bg_profile.png')}}') center center;">
        <h3 class="widget-user-username">
        <font style="font-size:18px; color:white;">
            {{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
        </font>
        </h3>
        <h5 class="widget-user-desc">
            {{ Pustaka::capital_string(\Auth::user()->pegawai->history_jabatan->where('status','active')->first()->jabatan) }}
        </h5>
    </div>

    <div class="widget-user-image">
        <img style="border: 3px solid white; padding: 0px; width: 100px; height: 100px; margin-top:8px;" class="img-circle" src="data:image/png;base64,{{ chunk_split(base64_encode(\Auth::user()->pegawai->foto->isi)) }}" alt="User Avatar">
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
                    <h5 class="description-header text-warning">567</h5>
                    <span class="description-text text-success">TPP</span>
                </div>
            </div>


        </div>



        <div class="box-body" style="margin-top:-20px;">
            <hr>
                <strong><i class="fa fa-university margin-r-5"></i> SKPD</strong>

                <p class="text-muted">
                {{ Pustaka::capital_string(\Auth::user()->pegawai->history_jabatan->where('status','active')->first()->Skpd->skpd) }}
                </p>

                <hr>

                <strong><i class="fa  fa-tags margin-r-5"></i> Unit Kerja</strong>

                <p class="text-muted">
                {{ Pustaka::capital_string(\Auth::user()->pegawai->history_jabatan->where('status','active')->first()->UnitKerja->unit_kerja) }}
                </p>
                <hr>

                <strong><i class="fa   fa-bar-chart margin-r-5"></i> Pangkat / Golongan</strong>

                <p class="text-muted">
                {{ \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->golongan->pangkat}} / 
                {{\Auth::user()->pegawai->history_jabatan->where('status','active')->first()->golongan->golongan}}
                </p>
                <hr>

              <strong><i class="fa   fa-paperclip margin-r-5"></i> Jabatan</strong>
                <p class="text-muted">
                {{ Pustaka::capital_string(\Auth::user()->pegawai->history_jabatan->where('status','active')->first()->jabatan) }}
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
</div>


          