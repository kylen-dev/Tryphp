<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Player Information</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <!-- MDB -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>" />
    <script src="script.js"></script>
</head>

<body>
    <?php 
    session_start();
    //Php database connection
    $localhost = 'localhost:3307';
    $dbname = 'project';
    $username = 'root';
    $password = '';

    try {
    $pdo = new PDO("mysql:host=$localhost;dbname=$dbname", $username, $password); 
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
      
        } 
       catch (PDOException $e) { 
       echo "Connection failed: " . $e->getMessage(); 
       } 
       if(!isset($_SESSION['username'])){
        header("location: login.php");
      }

    if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM players WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();
   }

   if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $rank = $_POST['rank'];
    $team = $_POST['team'];
    $player = $_POST['player'];
    $position = $_POST['position'];
    $points = $_POST['points'];
    $rebounds = $_POST['rebounds'];
    $assists = $_POST['assists'];

     $sql = "UPDATE players SET rank = ?, team = ?, player = ?, position = ?, points = ?, rebounds = ?, assists = ? WHERE id = ?";
     $stmt = $pdo->prepare($sql);
     if ($stmt->execute([$rank, $team, $player, $position, $points, $rebounds, $assists, $id])) {
       echo "Update successful!";
       header("location: index.php");
      } else {
      echo "Update unsuccessful!";
 }
}
?> 

<div class="container-fluid">
  <h2 class="text-center mt-4"><?php echo $user['player'];?>'s Information</h2>
  <form class="row mt-4 justify-content-center" action="" method="POST">
    <input type="hidden" id="id" name="id" value="<?php echo $user['id']; ?>">
    <div class="col-sm-1">
      <label for="rank">Rank</label>
      <input class="form-control" type="text" id="rank" name="rank" value="<?php echo $user['rank']; ?>" required>
    </div>
    <div class="col-sm-2">
      <label for="player">Player Name</label>
      <input class="form-control" type="text" id="player" name="player" value="<?php echo $user['player']; ?>" required>
    </div>
    <div class="col-sm-2">
      <label for="points">Career Points Per Game</label>
      <input class="form-control" type="decimal" id="points" name="points" value="<?php echo $user['points']; ?>" required>
    </div>
    <div class="col-sm-3">
      <label for="rebounds">Career Rebounds Per Game</label>
      <input class="form-control" type="decimal" id="rebounds" name="rebounds" value="<?php echo $user['rebounds']; ?>" required>
    </div>
    <div class="col-sm-2">
      <label for="assists">Career Assists Per Game</label>
      <input class="form-control" type="decimal" id="assists" name="assists" value="<?php echo $user['assists']; ?>" required>
    </div>
    <div class="col-sm-4 mt-3">
      <label for="team">Current Team</label>
      <select class="form-select" id="team" name="team" value="<?php echo $user['team']; ?>" required>
            <option value="<?php echo $user['team']; ?>"><?php echo $user['team']; ?></option>
            <option value="Atlanta Hawks">Atlanta Hawks</option>
            <option value="Boston Celtics">Boston Celtics</option>
            <option value="Brooklyn Nets">Brooklyn Nets</option>
            <option value="Charlotte Hornets">Charlotte Hornets</option>
            <option value="Chicago Bulls">Chicago Bulls</option>
            <option value="Cleveland Cavaliers">Cleveland Cavaliers</option>
            <option value="Dallas Mavericks">Dallas Mavericks</option>
            <option value="Denver Nuggets">Denver Nuggets</option>
            <option value="Detroit Pistons">Detroit Pistons</option>
            <option value="Golden State Warriors">Golden State Warriors</option>
            <option value="Houston Rockets">Houston Rockets</option>
            <option value="Indiana Pacers">Indiana Pacers</option>
            <option value="Los Angeles Clippers">Los Angeles Clippers</option>
            <option value="Los Angeles Lakers">Los Angeles Lakers</option>
            <option value="Memphis Grizzlies">Memphis Grizzlies</option>
            <option value="Miami Heat">Miami Heat</option>
            <option value="Milwaukee Bucks">Milwaukee Bucks</option>
            <option value="Minnesota Timberwolves">Minnesota Timberwolves</option>
            <option value="New Orleans Pelicans">New Orleans Pelicans</option>
            <option value="New York Knicks">New York Knicks</option>
            <option value="Oklahoma City Thunder">Oklahoma City Thunder</option>
            <option value="Orlando Magic">Orlando Magic</option>
            <option value="Philadelphia 76ers">Philadelphia 76ers</option>
            <option value="Phoenix Suns">Phoenix Suns</option>
            <option value="Portland Trail Blazers">Portland Trail Blazers</option>
            <option value="Sacramento Kings">Sacramento Kings</option>
            <option value="San Antonio Spurs">San Antonio Spurs</option>
            <option value="Toronto Raptors">Toronto Raptors</option>
            <option value="Utah Jazz">Utah Jazz</option>
            <option value="Washington Wizards">Washington Wizards</option>
        </select>
    </div>
    <div class="col-sm-4 mt-3">
      <label for="position">Position</label>
      <select class="form-select" id="position" name="position" value="<?php echo $user['position']; ?>" required>
            <option value="<?php echo $user['position']; ?>"><?php echo $user['position']; ?></option>
            <option value="Point Guard">Point Guard</option>
            <option value="Shooting Guard">Shooting Guard</option>
            <option value="Small Forward">Small Forward</option>
            <option value="Power Forward">Power Forward</option>
            <option value="Center">Center</option>
            </select>
    </div>
    <button class="mt-4 mb-5 btn btn-primary w-50" type="submit" name="update"> Update Player Info </button>
  </form>
</div>

</body>

</html>