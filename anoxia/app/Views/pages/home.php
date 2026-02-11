<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
<?= view('partials/navbar') ?>
<h1>MainPage!</h1>

<div id="loginModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
  <div style="position: relative; margin: 100px auto; padding: 20px; background-color: white; width: 300px; border: 1px solid black;">
    <span onclick="document.getElementById('loginModal').style.display='none'" style="position: absolute; top: 5px; right: 10px; cursor: pointer; font-size: 24px;">&times;</span>
    <h2>Login</h2>
    <?= view('modals/login_modal') ?>
  </div>
</div>
</body>
</html>