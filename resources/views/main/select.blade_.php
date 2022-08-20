@extends('layouts.app')

@yield('scripts')
<script type="text/javascript">
  (function() {
 
  var bar = $('.bar');
  var percent = $('.percent');
  var status = $('#status');

  $('form').ajaxForm({
      beforeSubmit: validate,
      beforeSend: function() {
          status.empty();
          var percentVal = '0%';
          var posterValue = $('input[name=file]').fieldValue();
          bar.width(percentVal)
          percent.html(percentVal);
      },
      uploadProgress: function(event, position, total, percentComplete) {
          var percentVal = percentComplete + '%';
          bar.width(percentVal)
          percent.html(percentVal);
      },
      success: function() {
          var percentVal = 'Wait, Saving';
          bar.width(percentVal)
          percent.html(percentVal);
      },
      complete: function(xhr) {
          status.html(xhr.responseText);
          alert('Uploaded Successfully');
          window.location.href = "/file-upload";
      }
  });
</script>

@yield('styles')

@section('content')
<div class="progress">
  <div class="bar"></div >
  <div class="percent">0%</div >
</div>
@endsection