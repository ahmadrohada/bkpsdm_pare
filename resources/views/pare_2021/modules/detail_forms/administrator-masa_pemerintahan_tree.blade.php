
<input type='text' id = 'cari' class="form-control" placeholder="cari">
<div id="mp" class=""></div>
     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>




<script type="text/javascript">
$(document).ready(function() {
	
		$(".masa_pemerintahan").click(function(){
		initMPTree();
		
    });
	
	
	function initMPTree() {
		$('#mp')
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api/administrator_masa_pemerintahan_tree") }}",
						"data" 	: function (node) {
							return { "renja_id" : {!! $mp->id !!} };
						},
						"dataType" : "json"
				}
				,'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
			}
			,"plugins" : [ "search"/* ,"state","contextmenu","wholerow" */ ]
				
		})
		.on("loaded.jstree", function(){
			$('#mp').jstree('open_all');
		});
	};


	var to = false;
	$('#cari').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
			var v = $('#cari').val();
			$('#mp').jstree(true).search(v);
		}, 250);
	});
	
	

});
</script>
