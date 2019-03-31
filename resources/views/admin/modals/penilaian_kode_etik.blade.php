<div class="modal fade modal-penilaian_kode_etik" id="penilaian_kode_etik" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Penilaian Kode Etik Pegawai
                </h4>
            </div>
            <div class="modal-body">


              <strong>Santun</strong>
              <p class="text-muted">Senantiasa bersikap halus dan baik budi bahasanya maupun tingkahlakunya</p>
			  <input  value="1" class="rating-kk ketelitian" name="ketelitian">
              <hr>

              <strong>Amanah</strong>
              <p class="text-muted">Dapat mempertanggungjawabkan tugas, fungsi dan perannya kepada masyarakat</p>
			  <input value="1" class="rating-kk akurasi" name="akurasi" >
              <hr>

			  
			  <strong>Harmonis</strong>
			  <p class="text-muted">Memelihara rasa persatuan dan kesatuan, saling menghormati serta menjaga dan menjalin kerjasama dengan sesama pegawai maupun pihak lainnya</p>
			  <input   value="1" class="rating-kk kerapihan" name="kerapihan">
			  <hr>

			  <strong>Adaftif</strong>
			  <p class="text-muted">Dapat mengantisipasi berbagai potensi, masalah dan perubahan yang terjadi dalam lingkup tugas, fungsi dan perannya</p>
			  <input  value="1" class="rating-kk keterampilan" name="keterampilan" >
			  <hr>

			  <strong>Terbuka</strong>
			  <p class="text-muted">Membuka diri terhadap hak masyarakat untuk memperoleh informasi yang benar, dan/atau daerah.jujur dan tidak diskriminatif tentang penyelenggaraan tugas, fungsi dan perannya dengan tetap memperlihatkan perlindungan atas hak azasi pribadi, golongan dan rahasia negara </p>
			  <input  value="1" class="rating-kk keterampilan" name="keterampilan" >
			  <hr>

			  <strong>Efektif</strong>
			  <p class="text-muted">mampu mencapai target pelaksanaan tugas dan fungsi dengan cara atau proses yang paling optimal serta dengan mengunakan masukan terrendah untuk mencapai keluaran yang maksimal</p>
			  <input  value="1" class="rating-kk keterampilan" name="keterampilan" >
			  <hr>
			 
			 
                        
            </div>
        </div>
    </div>
</div>



<link rel="stylesheet" href="{{asset('assets/css/star-rating.css')}}" />
<script src="{{asset('assets/js/star-rating.js')}}"></script>

<script type="text/javascript">


	$(".rating-kk").rating({
			showCaption: true,
			min: 0, 
			max: 5, 
			step: 1, 
			size: "xs", 
			stars: "5",
			'starCaptions': {
								0: '   kosong    ', 
								1: 'Sangat Kurang', 
								2: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kurang&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 
								3: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cukup&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
								4: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Baik&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
								5: '&nbsp;&nbsp;Sangat Baik &nbsp;&nbsp;'}
	});
</script>