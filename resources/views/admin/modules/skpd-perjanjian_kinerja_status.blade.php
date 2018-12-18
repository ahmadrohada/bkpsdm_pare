
<div id="myTimeline"></div>
	 
	 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css" />
<link rel="stylesheet" href="{{asset('assets/timeline/style-albe-timeline.css')}}" />

<script src="{{asset('assets/timeline/jquery-albe-timeline.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() {
	//Json Object
var data = [
	{
		time: '2018-11-29 20:45:09',
		body: [{
			tag: 'p',
			content: "Disetujui"
		},
		{
			tag: 'h4',
			content: "Kepala Daerah"
		},
		{
			tag: 'p',
			content: 'Lorem ipsum dolor sit amet, nisl lorem, wisi egestas orci tempus class massa, suscipit eu elit urna in urna, gravida wisi aenean eros massa, cursus quisque leo quisque dui.'
		}]
	},
	{
		time: '2018-11-28 13:20:00',
		body: [{
			tag: 'p',
			content: "Diterima"
		},
		{
			tag: 'h4',
			content: "Kepala Daerah"
		},
		{
			tag: 'p',
			content: 'Lorem ipsum dolor sit amet, nisl lorem, wisi egestas orci tempus class massa, suscipit eu elit urna in urna, gravida wisi aenean eros massa, cursus quisque leo quisque dui.'
		}]
	},
	{
		time: '2018-11-28 07:58:02 ',
		body: [{
			tag: 'p',
			content: "Diusulkan"
		},
		{
			tag: 'h4',
			content: "kepala SKPD"
		},
		{
			tag: 'p',
			content: 'Lorem ipsum dolor sit amet, nisl lorem, wisi egestas orci tempus class massa, suscipit eu elit urna in urna, gravida wisi aenean eros massa, cursus quisque leo quisque dui.'
		}]
	}
];



	$('#myTimeline').albeTimeline(data, {
		effect: 'fadeIn',
		showGroup: false,
		
		formatDate: 'dd de MMMM de yyyy HH:mm'
	});

	

});
</script>
