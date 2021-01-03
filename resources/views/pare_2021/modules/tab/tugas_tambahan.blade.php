<!-- ===============================  KEGIATAN TAHUNAN JFT =================================== -->

<div class="row">
	<div class="col-md-5">
		<div class="box box-tugas_tambahan ">
			<div class="box-header with-border">
				<h1 class="box-title">
				</h1>
				<div class="box-tools pull-right">
					{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				</div>
			</div>
			<div class="box-body" style="padding-left:0px; padding-right:0px;">
				
				<input type='text' id='tugas_tambahan_cari' class="form-control" placeholder="cari">
				<div class="table-responsive auto">
					<div id="tugas_tambahan_tree"></div>
				</div>
			</div>
		</div>	
	</div>
	<div class="col-md-7">
		@include('pare_pns.tables.skp_tahunan-tugas_tambahan')
	</div>
</div>

     
<script type="text/javascript">
	

	function LoadTugasTambahanTab(){

		$('#tugas_tambahan_tree').jstree({
            'core' : {
						'data' : {
						"url" 	: "{{ url("api/tugas_tambahan_tree") }}",
						"data" 	: function (node) {
							return  {  
										"id" 				: node.id ,
										"data" 				: node.data,
										"skp_tahunan_id" 	: {!! $skp->id !!}
                                    };
						},
				}
				
			},
						'check_callback' : true,
						'themes' : { 'responsive' : false },
						'plugins': ['search'] ,
	    }).on("loaded.jstree", function(){
			//$('#tugas_tambahan_tree').jstree('open_all');
		}).on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				//detail_table_jabatan((data.instance.get_node(data.selected[0]).type)+'|'+(data.instance.get_node(data.selected[0]).id));
			}
		});

		LoadTugasTambahanTable();
	}
	
	
	var to = false;
	$('#tugas_tambahan_cari').keyup(function () {
		if(to) { clearTimeout(to); }
			to = setTimeout(function () {
			var v = $('#tugas_tambahan_cari').val();
			$('#tugas_tambahan_tree').jstree(true).search(v);
		}, 250);
	});
	
	

	
	

</script>
