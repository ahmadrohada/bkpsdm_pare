<div class="box {{ $h_box }}" style="min-height:440px;">
    <div class="box-header with-border">
        <h1 class="box-title">
           Peta Jabatan
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body">

		<div class="input-group input-group-sm">
              <input type="input" class="form-control" id="input-search" placeholder="Type to search..." value="">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info " id="btn-clear-search"><i class="fa fa-undo"></i></button>
                    </span>
				</div>
				<p class="margin"></p>
		<div id="treeview-searchable" class="treeview"></div>

	</div>
</div>

@section('template_scripts')

@include('admin.structure.dashboard-scripts')

	
<script src="../assets/js/bootstrap-treeview.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	$.ajax({
			url		: "{{ url("api_resource/skpd_peta_jabatan") }}",
			method	: "GET",
			dataType: "json",
			data    : {},
			success	: function(data) {
				initTree(data);
						
			},
			error: function(data){
				
			}
		});

	
	function initTree(treeData) {
		$('#treeview-searchable').treeview({
							data:treeData,
							showBorder:false,
							highlightSelected:true,
							selectedBackColor:'#adb0b5',
							collapseIcon:'fa  fa-arrow-circle-o-down',
							expandIcon:'fa  fa-arrow-circle-o-right',
							emptyIcon:'fa  fa-hand-o-right',
							loadingIcon:'fa fa-spinner faa-spin animated',							
							levels: 3
							


	});
	}
	
	

	






    var selectors = {
        'tree': '#treeview-searchable',
        'input': '#input-search',
        'reset': '#btn-clear-search'
    };
    var lastPattern = ''; // closure variable to prevent redundant operation

    // collapse and enable all before search //
    function reset(tree) {
        tree.collapseAll();
        tree.enableAll();
    }

    // find all nodes that are not related to search and should be disabled:
    // This excludes found nodes, their children and their parents.
    // Call this after collapsing all nodes and letting search() reveal.
    //
    function collectUnrelated(nodes) {
        var unrelated = [];
        $.each(nodes, function (i, n) {
            if (!n.searchResult && !n.state.expanded) { // no hit, no parent
                unrelated.push(n.nodeId);
            }
            if (!n.searchResult && n.nodes) { // recurse for non-result children
                $.merge(unrelated, collectUnrelated(n.nodes));
            }
        });
        return unrelated;
    }

    // search callback
    var search = function (e) {
        var pattern = $(selectors.input).val();
        if (pattern === lastPattern) {
            return;
        }
        lastPattern = pattern;
        var tree = $(selectors.tree).treeview(true);
        reset(tree);
        if (pattern.length < 3) { // avoid heavy operation
            tree.clearSearch();
        } else {
            tree.search(pattern);
            // get all root nodes: node 0 who is assumed to be
            //   a root node, and all siblings of node 0.
            var roots = tree.getSiblings(0);
            roots.push(tree.getNode(0));
            //first collect all nodes to disable, then call disable once.
             //  Calling disable on each of them directly is extremely slow! 
            var unrelated = collectUnrelated(roots);
            tree.disableNode(unrelated, {silent: true});
        }
    };

    // typing in search field
    $(selectors.input).on('keyup', search);

    // clear button
    $(selectors.reset).on('click', function (e) {
        $(selectors.input).val('');
        var tree = $(selectors.tree).treeview(true);
        reset(tree);
        tree.clearSearch();
    });	
		
});
</script>

@endsection