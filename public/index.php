<?php require_once('../includes/initialize.php'); ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <link rel="stylesheet" href="stylesheets/responsive_style.css">
    <link rel="stylesheet" href="stylesheets/nav.css">
    <title>Let's code | JuliusAnghelina.ro</title>
  </head>
  <body>
    <header>
      <h1>A story about change</h1>
    </header>

    <nav id="main">
      <ul>
        <li class="logo"><a href="#">JuliusAnghelina.ro</a></li>
        <li><a href="#">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#portfolio">Portfolio</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>

    <div class="wrapper">

      <!-- Top Container -->
      <section class="top-container">
        <header class="showcase">
          <h1>This is the main title</h1>
          <p>This button doesn't go nowhere now but it could turn out useful </p>
          <a href="" class="btn">Dummy Button</a>
        </header>
        <div class="top-box top-box-a">
          <h4>Membership</h4>
          <p class="price">$200/mo</p>
          <a href="" class="btn">It's a trap</a>
        </div>
        <div class="top-box top-box-b">
          <h4>PRO Membership</h4>
          <p class="price">$400/mo</p>
          <a href="" class="btn">It's a bigger trap</a>
        </div>
      </section>

      <!-- Boxes section -->
      <a name="about"></a>
      <section class="boxes">
        <div class="box">
          <i class="fab fa-html5 fa-5x"></i>
          <h3>Analytics</h3>
          <p>Just some dummy text. Don't you think it looks good?</p>
        </div>
        <div class="box">
        <i class="fab fa-css3-alt fa-5x"></i>
          <h3>Marketing</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        <div class="box">
          <i class="fab fa-js-square fa-5x"></i>
          <h3>Development</h3>
          <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
        </div>
        <div class="box">
          <i class="fab fa-php fa-5x"></i>
          <h3>Support</h3>
          <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
      </section>

      <!-- Portfolio -->
      <a name="portfolio"></a>
      <div class="line"></div>
      <h2>Portfolio</h2>
        <?php
          // 1. the current page number ($current_page)
          $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

          // 2. records per page ($per_page)
          $per_page = 4;

          // 3. total record count ($total_count)
          $total_count = Photograph::count_all();

          $pagination = new Pagination($page, $per_page, $total_count);

          // find the records for this page
          $sql = "SELECT * FROM photographs ";
          $sql .= "LIMIT {$per_page} ";
          $sql .= "OFFSET {$pagination->offset()}";
          $photos = Photograph::find_by_sql($sql);
        ?>

        <div id="pagination" style="clear: both;">
          <?php
          if ($pagination->total_pages() > 1) {

            if ($pagination->has_previous_page()) {
              echo "<a href=\"index.php?page=";
              echo $pagination->previous_page();
              echo "\">&laquo; Previous</a> ";
            } else {
              echo "&laquo; Previous</a> ";
            }
            for ($i=1; $i <= $pagination->total_pages(); $i++) {
              if ($i == $page) {
                echo " <span class=\"selected\">{$i}</span>";
              } else {
                echo " <a href=\"index.php?page={$i}\">{$i}</a> ";
              }
            }
            if ($pagination->has_next_page()) {
              echo "<a href=\"index.php?page=";
              echo $pagination->next_page();
              echo "\">Next &raquo;</a> ";
            } else {
              echo " Next &raquo;</a> ";
            }
          }
          ?>
        </div>

      <section class="portfolio">
        <?php foreach ($photos as $photo): ?>
          <div style="float: left; margin-left: 20px;">
            <a href="photo.php?id=<?php echo $photo->id; ?>">
              <img src="<?php echo $photo->image_path(); ?>" width="300" />
            </a>
            <p><?php echo $photo->caption; ?></p>
          </div>
        <?php endforeach; ?>
      </section>

      <!-- info section -->
      <a name="contact"></a>
      <section class="info">
          <img src="http://juliusanghelina.ro/wp-content/uploads/2016/12/juliusanghelina.png" alt="">
          <div>
          
            <h2>Find me on social media</h2>
            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            
            <a href="https://www.facebook.com/juliusAnghelina/"><i class="fab fa-facebook-square fa-3x"></i></a>
            <a href="http://instagram.com/iulius2000/"><i class="fab fa-instagram fa-3x"></i>
            <a href="https://www.linkedin.com/in/julius-anghelina-a96049b8/"><i class="fab fa-linkedin fa-3x"></i>
            <a href="https://twitter.com/JuliusAnghelina"><i class="fab fa-twitter-square fa-3x"></i>
          </div>
      </section>

      <!-- Footer -->
      <footer class="footer">
        <p>&copy; 2018 &nbsp;  | &nbsp; <a href="http://juliusanghelina.ro/web-development/" target="_blank"> JuliusAnghelina.ro</a></p>
      </footer>

    </div>   <!-- wrapper ends -->

    <script src="javascripts/scripts.js"></script>

  </body>
</html>
