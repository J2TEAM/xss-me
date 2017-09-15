<?php
/* Developed by Juno_okyo */
setcookie('canyouseeme', 'I am Juno_okyo'); // secret cookie for demo

if (isset($_POST['name']) && ! empty($_POST['name'])) {
  $name = $_POST['name'];
  setcookie('name', $name);
} else {
  $name = isset($_COOKIE['name']) ? $_COOKIE['name'] : '';
}

if (isset($_GET['error'])) {
  $name = '';
}
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Juno_okyo">
    <meta name="copyright" content="J2TEAM">
    <meta name="description" content="A simple web application to learn about Cross-Site Scripting (XSS)">
    <title>XSS - Cross Site Scripting</title>
    <link href="https://junookyo.blogspot.com/favicon.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mini.css/2.3.4/mini-dark.min.css">
  </head>
  <body>
    <header>
      <a href="index.php" class="logo">XSS Me</a>
      <a href="index.php" class="button">Home</a>
      <a href="index.php?page=About" class="button">About</a>
      <a href="index.php#name=juno_okyo" class="button">DOM-based XSS</a>
    </header>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ul class="breadcrumbs">
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_GET['page']) && ! empty($_GET['page'])): ?><li><?php echo $_GET['page']; ?></li><?php endif; ?>
          </ul>
          <?php if (isset($_GET['page']) && strtolower($_GET['page']) === 'about'): ?>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          <?php else: ?>
          <form action="index.php" method="post" accept-charset="utf-8" id="form">
            Your name: <input type="text" name="name" value="<?php if ( ! empty($name)) { echo $name; } ?>" placeholder="John Doe..." autofocus required>
            <button type="submit" class="primary">Say Hi!</button>
          </form>
          <?php endif; ?>

          <div id="name">
            <?php if ( ! empty($name)): ?>
            <span class="toast large">Hello, <?php echo $name; ?>!</span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
      const $name = document.getElementById('name');
      function showNameFromHash() {
        let hash = window.top.location.hash;

        if (hash.length > 6 && hash.includes('#name')) {
          let newName = hash.substr(6); // #name=X
          $name.innerHTML = '<span class="toast large">Hello, ' + newName + '!</span>';
          try {
            eval(newName);
          } catch(e) {
            console.error(e.message);
          }
        }
      }
      showNameFromHash();
      window.addEventListener('hashchange', showNameFromHash, false);
    </script>
  </body>
</html>