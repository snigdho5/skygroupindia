</div>
<footer>
	<?php echo COMPANY_NAME .' &copy; '. date("Y") .' '. COPYRIGHT_COMPANY;?>
</footer>

<style type="text/css">
  .bootstrap-datetimepicker-widget{
    z-index: 999999;
  }
</style>

<style type="text/css">
  .pagination > .active > a, .pagination > a:hover {
  background: #e32124;
  color: #fff;
  border: 1px solid #e32124;
}
.pagination>a, .pagination>strong {
  position: relative;
  float: left;
  padding: 6px 12px;
  margin-left: -1px;
  line-height: 1.42857143;
  color: #337ab7;
  text-decoration: none;
  background-color: #fff;
  border: 1px solid #ddd;
}

.pagination >strong{
  background:#e32124;
  color:#fff;
  border:1px solid #e32124;
}
</style>


<script type="text/javascript">
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });


  $(document).ready(function() {
    $('#only-one [data-accordion]').accordion();
    $('#multiple [data-accordion]').accordion({
      singleOpen: false
  });

  $('#single[data-accordion]').accordion({
    transitionEasing: 'cubic-bezier(0.455, 0.030, 0.515, 0.955)',
    transitionSpeed: 200
  });
});


  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("body").toggleClass("toggled");
  });


  $.validate({
    lang: 'en'
  });


function goBack() {
  window.history.back();
}
</script>

</body>
</html>