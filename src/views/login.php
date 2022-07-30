<section>
<div class="row justify-content-sm-center">
  <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 pt-5">
    <form
      class="shadow-lg text-center border border-light p-5 bg-light"
      method="post"
    >
      <p class="h4 mb-4">Login</p>
      <input
        type="text"
        name="username"
        class="form-control mb-4"
        placeholder="Username"
        required
      />
      <input
        type="password"
        name="password"
        class="form-control mb-4"
        placeholder="Password"
        required
      />

      <div class="d-flex justify-content-around">
        <div>
          <div class="custom-control custom-checkbox">
            <input
              type="checkbox"
              name="remember"
              class="custom-control-input"
              id="defaultLoginFormRemember"
            />
            <label
              class="custom-control-label"
              for="defaultLoginFormRemember"
              >Remember me</label
            >
          </div>
        </div>
        <div>
          <a href="">Forgot password?</a>
        </div>
      </div>
      <?php
        if (isset($err)) {
          print "<div class='text-danger mt-3' id='err-text'><i>*$err!!</i></div>";
          print "<script>setTimeout(() =>document.getElementById('err-text').remove(), 3000);</script>";
        }
      ?>
      <input
        class="btn btn-primary btn-block my-4"
        type="submit"
        value="Sign In"
      />
      <p>
        Not a member?
        <a href="/register">Register</a>
      </p>
    </form>
  </div>
</div>
</section>
