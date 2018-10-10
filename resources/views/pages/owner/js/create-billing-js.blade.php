<script>
    $(document).ready(function () {
       $('#client').on('change',function (e) {
          e.preventDefault();
          $('#client-id').val(this.value);
       });
    });
</script>
