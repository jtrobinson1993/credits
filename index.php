<?
include_once 'php/utils.php';
// getUserName() and getUserID() are now vars referencing logged in user
// isLoggedIn() and isAdmin() are now true/false
// getCredits(getUserID()); returns number of credits or -1 if error
?>
<!DOCTYPE html>
<head>
  <title>Bettr</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#278EC0">
  <link href="https://fonts.googleapis.com/css?family=Didact+Gothic" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700|Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/styles.css" />
  <link rel="stylesheet" href="styles/games/slot-machine/styles.css" />
  <link rel="stylesheet" href="styles/stocks/styles.css" />
  <link rel="stylesheet" href="styles/lottery/styles.css" />
  <link rel="icon" sizes="100x100" href="<?=getUserImage(getUserID())?>">
  <script src="scripts/utils.js"></script>
  <script src="scripts/app.js"></script>
  <script src="scripts/games/slot-machine/app.js"></script>
</head>
<body>
  <div class="site-wrap">
    <? if(isLoggedIn()) : ?>
    <div class="flyout">
      <div class="constraint">
        <div class="logo">Bettr<span class="tagline"> the better better</span></div>
        <div class="side-menu">
          <ul class="tabs">
            <li class="tab transactions" data-tab="transactions">Transactions</li>
            <li class="tab stocks" data-tab="stocks">Stocks</li>
            <li class="tab games" data-tab="games">Games</li>
            <li class="tab lottery" data-tab="lottery">Lottery</li>
          </ul>
        </div>
        <div class="transactions-container"></div>
        <div class="refresh-transactions"><button class="refresh-transactions-btn">Refresh</button></div>
      </div>
    </div>
    <div class="main-wrap">
      <header>
        <div class="constraint">
          <div class="credit-count">
            <? if(isLoggedIn()) : ?>
              <?= getCredits(getUserID()) ?>
            <? endif; ?>
          </div>
            <div class="welcome">
              Welcome to Bettr, <strong class="welcome-user-name"><?= getUserName() ?></strong>
            </div>
        </div>
      </header>
      <div class="main-content">
        <div class="constraint">
          <? include_once 'php/contents/transactions.php'; ?>
          <? include_once 'php/contents/stocks.php'; ?>
          <? include_once 'php/games/slot-machine/index.php'; ?>
          <? include_once 'php/contents/lottery.php'; ?>
        </div>
      </div>
      <footer>
        <div class="constraint">
          &copy; Bettr Enterprises <?= date("Y")?><i class="our-names"> - Jethrow Randlebrot & Jebediah Grizzwald</i>
        </div>
      </footer>
    </div>
  <? else : ?>
    <div class="login">
      <div class="slogan">Sign in to experience</div>
      <h1>Bettr</h1>
      <div class="login-form form">
        <div class="error-msg"></div>
        <input type="text" name="name" class="display-name" placeholder="Display Name" />
        <input type="text" name="pw" class="username" placeholder="Username" />
        <button class="submit">Log In</button>
      </div>
      <div class="register">
        Not a member? Click here to sign up.
      </div>
    </div>
  <? endif; ?>
  </div>
  <div class="overlay">
    <div class="popup">
      <div class="close">X</div>
      <div class="popup-content logout">
        <h4>Not <?=getUserName()?>?</h4>
        <button class="logout">Logout</button>
      </div>
    </div>
  </div>
</body>

<? $connection->close(); ?>
