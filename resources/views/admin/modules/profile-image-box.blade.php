<div class="box box-widget widget-user ">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-black" style="background: url('{{asset('assets/images/bg_profile.png')}}') center center;">
        <h3 class="widget-user-username">
        <font style="font-size:18px; color:white; text-shadow: 1px 1px 1px #000, 3px 3px 5px #000;">
            {{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
        </font>
        </h3>
        <h5 class="widget-user-desc" style="text-shadow: 1px 1px 1px #000, 3px 3px 5px #000;">
            {{ \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->nip }}
        </h5>
    </div>

    <div class="widget-user-image">
        <img style="border: 3px solid white; padding: 0px; width: 100px; height: 100px; margin-top:0px;" class="img-circle" src="data:image/png;base64,{{ chunk_split(base64_encode(\Auth::user()->pegawai->foto->isi)) }}" alt="User Avatar">
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
       
                <hr>
                <strong><i class="fa    fa-sitemap margin-r-5"></i> Jabatan</strong>
                <p class="text-muted">
                {{ Pustaka::capital_string(\Auth::user()->pegawai->history_jabatan->where('status','active')->first()->jabatan) }}
                </p>

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
                <strong><i class="fa   fa-bar-chart margin-r-5"></i> Eselon</strong>
                <p class="text-muted">
                {{ \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->eselon->jenis_jabatan->jenis_jabatan}} / 
                {{\Auth::user()->pegawai->history_jabatan->where('status','active')->first()->eselon->eselon}}
                </p>

                <hr>
                <strong><i class="fa  fa-users margin-r-5"></i> Golongan Terakhir</strong>
                <p class="text-muted">
                {{ \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->golongan->golongan}} / 
                {{ Pustaka::tgl_form(\Auth::user()->pegawai->history_jabatan->where('status','active')->first()->tmt_jabatan) }}
                </p>

                <hr>
                <strong><i class="fa   fa-phone margin-r-5"></i> No. Handphone</strong>
                <p class="text-muted">
                {{ \Auth::user()->pegawai->no_hp}} 
                </p>

                <hr>
                <strong><i class="fa   fa-envelope-o margin-r-5"></i> Email</strong>
                <p class="text-muted">
                {{ \Auth::user()->pegawai->email}}
                </p>

                <hr>
                <strong><i class="fa   fa-map margin-r-5"></i> Alamat</strong>
                <p class="text-muted">
                {{ \Auth::user()->pegawai->alamat}}
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


          