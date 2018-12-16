
<input type='text' id = 'cari_keg' class="form-control" placeholder="cari">
<div id="ditribusi_renja" class="demo"></div>
     

<link rel="stylesheet" href="{{asset('assets/jstree/themes/default/style.css')}}" />
<script src="{{asset('assets/jstree/jstree.min.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() {
	
	
	$(".distribusi_kegiatan").click(function(){
		initTree();
    });
	
	
	function initTree() {
		$('#ditribusi_renja')
		.on("loaded.jstree", function(){
			$('#ditribusi_renja').jstree('open_all');
		})
		.on("changed.jstree", function (e, data) {
			if(data.selected.length) {
				//alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text);
				//alert(data.instance.get_node(data.selected[0]).id)
				
			}
		})
		.jstree({
            'core' : {
				'data' : {
						"url" 	: "{{ url("api_resource/skpd_renja_distribusi_kegiatan_tree") }}",
						"data" 	: function (node) {
							return { "id" : node.id };
						},
						"dataType" : "json"
				}
				,'check_callback' : true,
						'themes' : {
							'responsive' : false
						}
			}
			,"plugins" : [ "search"/* ,"state","contextmenu","wholerow" */ ]
			
		
	    }).on('create_node.jstree', function (e, data) {
		          
			$.get('response.php?operation=create_node', { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text })
				.done(function (d) {
					data.instance.set_id(data.node, d.id);
				})
				.fail(function () {
					data.instance.refresh();
				});
		}).on('rename_node.jstree', function (e, data) {
			$.get('response.php?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
				.fail(function () {
					data.instance.refresh();
				});
		}).on('delete_node.jstree', function (e, data) {
			$.get('{{ url("api_resource/hapus_kegiatan_renja") }}', { 'id' : data.node.id })
				.fail(function () {
					data.instance.refresh();
				});
		});
	}


	
	var to = false;
	$('#cari_keg').keyup(function () {
		if(to) { clearTimeout(to); }
		to = setTimeout(function () {
		var v = $('#cari_keg').val();
		$('#ditribusi_renja').jstree(true).search(v);
		}, 250);
	});
	
	

});
</script>
