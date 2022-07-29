<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once $_SERVER['DOCUMENT_ROOT'] .'/config.php';

  $json = file_get_contents('php://input');
  $json = json_decode($json);

  if (empty($_POST['username']) && empty($json->username)) {
    json_resp(422, null, 'missing username field');
    exit();
  }

  $username = isset($_POST['username']) ? $_POST['username'] : $json->username;

  if (empty($_POST['password']) && empty($json->password)) {
    json_resp(422, null, 'missing password field');
    exit();
  }

  $password = isset($_POST['password']) ? $_POST['password'] : $json->password;
  $remember = isset($_POST['remember']) ? true : isset($json->remember);

  $res = mysqli_query($dbconn,
   'select * from users where username = \'' .
    mysqli_real_escape_string($dbconn, $username) .
    '\';'
  );

  $res = $res->fetch_assoc();

  if (!$res || !password_verify($password, $res['hash_passwd'])) {
    json_resp(403, null, 'username or password not matched');
    exit();
  }

  session_start();
  $_SESSION['uid'] = $res['id'];
  if ($remember) {
    setcookie(
      'remb',
      $res['id'] . '|' . hash('sha256', 'remb' . $res['id'] . 'remb'),
      time() + 3600 * 24 * 30,
      '/'
    );
  }

  if (!isset($_POST['username'])) {
    json_resp(200);
  } else {
    header('Location: /');
  }

  exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/login/guard.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jetnote</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="/public/css/style.css" />
  </head>

  <body>
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

    <script
      type="text/javascript"
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
    ></script>
  </body>
</html>

