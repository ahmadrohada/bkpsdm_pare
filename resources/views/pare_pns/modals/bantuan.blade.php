<!-- diinclude di pare_pns-partials-breadcrumb -->


<div class="modal fade modal-bantuan" id="bantuan" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title topic">
                    Bantuan
                </h4>
            </div>
            <div class="modal-body">
                Tes    ID : <span class="tes_data"></span>
                <br><br>

                <p class="information" style="line-height:1.5; text-align: justify;"></p>
                
            

 

                        
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">

 
    
    $(document).on('click','.bantuan',function(e){
        var id = $(this).data('id') ;



        $.ajax({
				url			: '{{ url("api/bantuan_detail") }}',
				data 		: {bantuan_id : id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {

                    $('.tes_data').html(data['id']);
                    $('.topic').html(data['topic']);
                    $('.information').html(data['information']);
		            $('.modal-bantuan').modal('show');




                },
				error: function(data){
					
				}						
		});	



		


    });
    



</script>