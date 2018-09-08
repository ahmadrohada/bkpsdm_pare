<div class="box box-widget widget-user-2">
  <div class="widget-user-header bg-yellow">
    <div class="widget-user-image">
			<img style="border: 1px solid white; padding: 2px; width: 65px; height: 65px;" class="img-circle" src="data:image/png;base64,{{ chunk_split(base64_encode($user->pegawai->foto->isi)) }}" alt="User Avatar">
    </div>
    <!-- /.widget-user-image -->
    <h3 class="widget-user-username">{{ Pustaka::nama_pegawai($user->pegawai->gelardpn , $user->pegawai->nama , $user->pegawai->gelarblk)  }}</h3>
    <h5 class="widget-user-desc">Lead Developer</h5>
    
  </div>
            
  <div class="box-footer no-padding">
    <ul class="nav nav-stacked">
      <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
      <li><a href="#">Tasks <span class="pull-right badge bg-aqua">5</span></a></li>
      <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
      <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li>
    </ul>
  </div>
</div>
    