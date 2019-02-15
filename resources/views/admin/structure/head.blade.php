{{-- HTML5 Shim and Respond.js for IE8 support --}}


{{-- Load Admin CSS --}}



{!! HTML::style(asset('/assets/bower_components/bootstrap/dist/css/bootstrap.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
{!! HTML::style(asset('/assets/bower_components/font-awesome/css/font-awesome.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
{!! HTML::style(asset('/assets/bower_components/Ionicons/css/ionicons.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}

{!! HTML::style(asset('/assets/bower_components/select2/dist/css/select2.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}

{!! HTML::style(asset('/assets/bower_components/data-table/DataTables-1.10.18/css/dataTables.bootstrap.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
<!--
{!! HTML::style(asset('/assets/bower_components/data-table/DataTables-1.10.18/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
{!! HTML::style(asset('/assets/bower_components/data-table/DataTables-1.10.18/css/buttons.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
{!! HTML::style(asset('/assets/bower_components/data-table/DataTables-1.10.18/css/select.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
{!! HTML::style(asset('/assets/bower_components/data-table/DataTables-1.10.18/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}

-->
{!! HTML::style(asset('/assets/bower_components/jquery-datetimepicker/jquery.datetimepicker.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}

{!! HTML::style(asset('/assets/css/styles.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}



{!! HTML::style(asset('/assets/css/AdminLTE.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
{!! HTML::style(asset('/assets/css/skins/_all-skins.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}



{{-- Load Template Specific CSS --}}
@yield('style-sheets')

{{-- Load Layout Specific INLINE CSS --}}
<style type='text/css'>
	@yield('template_fastload_css')
</style>



