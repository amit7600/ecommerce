
 <!-- Jquery Core Js -->
 <script src="{{URL::asset('adminLTE/plugins/jquery/jquery.min.js')}}"></script>

<!-- Jquery Util Js -->
 <script src="{{URL::asset('adminLTE/plugins/jquery/jquery-ui.js')}}"></script>

<!-- Bootstrap Core Js -->
<script src="{{URL::asset('adminLTE/plugins/bootstrap/js/bootstrap.js')}}"></script>

<!-- Select Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- Jquery DataTable Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/jquery-countto/jquery.countTo.js')}}"></script>

<!-- Morris Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/morrisjs/morris.js')}}"></script>

<!-- ChartJs -->
<script src="{{URL::asset('adminLTE/plugins/chartjs/Chart.bundle.js')}}"></script>

<!-- Flot Charts Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/flot-charts/jquery.flot.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/flot-charts/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/flot-charts/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/flot-charts/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('adminLTE/plugins/flot-charts/jquery.flot.time.js')}}"></script>

<!-- Sparkline Chart Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/jquery-sparkline/jquery.sparkline.js')}}"></script>

<!-- Bootstrap Notify Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/bootstrap-notify/bootstrap-notify.js')}}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/node-waves/waves.js')}}"></script>

<!-- SweetAlert Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/sweetalert/sweetalert.min.js')}}"></script>

<!-- Dropzone Plugin Js -->
<script src="{{URL::asset('adminLTE/plugins/dropzone/dropzone.js')}}"></script>

<!-- Custom Js -->
<script src="{{URL::asset('adminLTE/js/admin.js')}}"></script>
<!-- <script src="{{URL::asset('adminLTE/js/pages/index.js')}}"></script> -->

<script src="{{URL::asset('adminLTE/js/pages/ui/dialogs.js')}}"></script>

<script src="{{URL::asset('adminLTE/js/pages/ui/modals.js')}}"></script>

<script src="{{URL::asset('adminLTE/js/pages/tables/jquery-datatable.js')}}"></script>

<!-- Bootstrap Tags Input Plugin Js -->
    <script src="{{URL::asset('adminLTE/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>

<!-- Bootstrap Tags Input type head Js -->
<script src="{{URL::asset('adminLTE/plugins/bootstrap-tagsinput/typeahead.bundle.js')}}"></script>

<!-- Demo Js -->
<script src="{{URL::asset('adminLTE/js/demo.js')}}"></script>

<script src="{{URL::asset('adminLTE/js/pages/ui/tooltips-popovers.js')}}"></script>
<script src="{{URL::asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').click(function(e){
            $('#sidebar').toggleClass('active');
        });
    });
</script>
<script>
    function deleteValue (route, obj) {
        // Delete id from table
        $('#errorAlertMessage').empty('')
        $conf = confirm("<?php echo __('language.deleteMessage'); ?>")
        if($conf) {
            $.ajax({
                type: "DELETE",
                url: route,
                data: {
                    "_token": "{{ csrf_token() }}"
                    },
                success: function(msg){
                    $('#errorAlertMessage').append('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+msg.success+'</div>');
                    // $(this).closest("tr").remove();
                    $(obj).closest('tr').hide();
                    // setTimeout(function(){ location.reload(); }, 1000);
                },
                error: function(request,msg,error) {
                    // handle failure
                    $('#errorAlertMessage').append('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+error+'</div>');
                    // $(this).parent('tr').remove();
                    // setTimeout(function(){ location.reload(); }, 1000);
                }
            })
        }
    }
</script>
