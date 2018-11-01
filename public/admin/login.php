<?php
require_once("../../includes/initialize.php");

if($session->is_logged_in()) {
  redirect_to("index.php");
}

// Remember to give your form's submit tag a name="submit" attribute!
if (isset($_POST['submit'])) { //form has been submitted

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // check database to see if username/password exist
    $found_user = User::authenticate($username, $password);

    if ($found_user) {
      $session->login($found_user);
      log_action('Login', "{$found_user->username} logged in.");
      redirect_to("index.php");
    } else {
      // user/pass not found in db
      $message = "Username/Password combination incorrect.";
    }

} else { //form has not been submitted
  $username = "";
  $password = "";
}

?>

<?php include_layout_template('admin_header.php') ?>

      <h2>Awesome Staff Login</h2>
      <div id=error><?php echo output_message($message); ?></div>
      <hr />
      <form action="login.php" method="post">
        <table>
           <tr>
            <td>Enter your username:</td>
            <td>
              <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
            </td>
          </tr>
          <tr>
            <td>Enter your password:</td>
            <td>
              <input type="password" name="password" maxlength="30" values="<?php echo htmlentities($password); ?>" />
            </td>
          </tr>
          </table>
          <br>
          <table>
          <tr>
            <td colspan="2">
              <input type="submit" name="submit" value="Login" style="float: right;"/>
            </td>
          </tr>
        </table>
      </form>

<?php include_layout_template('admin_footer.php') ?>
