<!-- REQUIRED JS SCRIPTS -->
{{--<script src="{{ url (mix('components/select2/select2-built.js')) }}" type="text/javascript"></script>--}}
<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
<script>
$(function () {
    $('.select2').select2()
})
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
