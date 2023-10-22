<?php
include "./view/view_header.php";
?>
<div class="container">
  <div class="row justify-content-center align-items-center">
  <div class="col-auto text-center">
    <label for="inputPassword6" class="col-form-label">Password</label>
  </div>
  <div class="col-auto">
    <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
  </div>
  <div class="col-auto">
    <span id="passwordHelpInline" class="form-text">
      Must be 8-20 characters long.
    </span>
  </div>
  <?php
  if (function_exists('curl_init')) {
    echo 'cURL está habilitado en esta instalación de PHP.';
} else {
    echo 'cURL no está habilitado en esta instalación de PHP.';
}
?>
</div>
</div>


<?php
include "./view/view_footer.php";
?>