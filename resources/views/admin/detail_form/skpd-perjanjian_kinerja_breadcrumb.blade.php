
	  <div class="box box-primary">
    
		  <div class="box-body">
       
			  <p class="text-default text-center ">PERJANJIAN KINERJA</p>
		  	<p class="text-default text-center " style="margin-top:-14px;"><strong></strong></p>
			
      

			  <p class="text-info text-center"></p>

        <hr>

        <div class="box-body no-padding">
          <ul class="nav nav-pills nav-stacked">
            <li @if ( $form_name == "sasaran") class="active" @endif>
              <a href="#"> SASARAN
                <span class="label label-primary pull-right" id="sasaran">0</span>
              </a>
            </li>
                
            <li @if ( $form_name == "indikator_sasaran") class="active" @endif>
              <a href="#"> INDIKATOR SASARAN
                <span class="label label-primary pull-right" id="indikator_sasaran">0</span>
              </a>
            </li>
                
            <li @if ( $form_name == "program") class="active" @endif>
              <a href="#"> PROGRAM
                <span class="label label-primary pull-right" id="program">0</span>
              </a>
            </li>

            <li @if ( $form_name == "indikator_program") class="active" @endif>
              <a href="#"> INDIKATOR PROGRAM
                <span class="label label-primary pull-right" id="indikator_program">0</span>
              </a>
            </li>

            <li @if ( $form_name == "kegiatan") class="active" @endif>
              <a href="#"> KEGIATAN
                <span class="label label-primary pull-right" id="kegiatan">0</span>
              </a>
            </li>

            <li @if ( $form_name == "indikator_kegiatan") class="active" @endif>
              <a href="#"> INDIKATOR KEGIATAN
                <span class="label label-primary pull-right" id="indikator_kegiatan">0</span>
              </a>
            </li>
            
          </ul>
        </div>
     


        <a href="#" class="btn btn-primary btn-block publish" disabled><b>PUBLISH</b></a>
		</div>
	</div>




<script type="text/javascript">
$(document).ready(function() {
  
  $('#addSasaran ').on('hidden.bs.modal', function(){
	  breadcrumb();
	});

  $('#createIndikatorSasaran').on('hidden.bs.modal', function(){
	  breadcrumb();
	});

  $('#createProgram').on('hidden.bs.modal', function(){
	  breadcrumb();
	});

  $('#createIndikatorProgram').on('hidden.bs.modal', function(){
	  breadcrumb();
	});

  $('#createKegiatan').on('hidden.bs.modal', function(){
	  breadcrumb();
	});

  $('#createIndikatorKegiatan').on('hidden.bs.modal', function(){
	  breadcrumb();
	});



breadcrumb();

function breadcrumb(){
  $.ajax({
      method    : "GET",
      url       : '{{ url("api_resource/breadcrumb-perjanjian-kinerja") }}',
			data      : { perjanjian_kinerja_id: {{ $perjanjian_kinerja->id }} },
			dataType  : "json",
			success   : function (data) {

              
              $('#sasaran').html(data['sasaran']);
              if ( data['sasaran'] > 0 ){
                $('#sasaran').addClass('bg-light-blue');
              }else{
                $('#sasaran').addClass('bg-red');
              }

              $('#indikator_sasaran').html(data['indikator_sasaran']);
              if ( data['indikator_sasaran'] > 0 ){
                $('#indikator_sasaran').addClass('bg-light-blue');
              }else{
                $('#sasaran').addClass('bg-red');
              }

              $('#program').html(data['program']);
              if ( data['program'] > 0 ){
                $('#program').addClass('bg-light-blue');
              }else{
                $('#program').addClass('bg-red');
              }

              $('#indikator_program').html(data['indikator_program']);
              if ( data['indikator_program'] > 0 ){
                $('#indikator_program').addClass('bg-light-blue');
              }else{
                $('#indikator_program').addClass('bg-red');
              }

              $('#kegiatan').html(data['kegiatan']);
              if ( data['kegiatan'] > 0 ){
                $('#kegiatan').addClass('bg-light-blue');
              }else{
                $('#kegiatan').addClass('bg-red');
              }

              $('#indikator_kegiatan').html(data['indikator_kegiatan']);
              if ( data['indikator_kegiatan'] > 0 ){
                $('#indikator_kegiatan').addClass('bg-light-blue');
              }else{
                $('#indikator_kegiatan').addClass('bg-red');
              }

              if ( data['publish_status'] > 0 ){
                $('.publish').attr('disabled', false);
              }else{
                $('.publish').attr('disabled', true);
              }
        
			}
		});
}
 
	
	
});
</script>