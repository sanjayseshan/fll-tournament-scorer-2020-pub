<?php
if (strpos($_SERVER['SERVER_NAME'], "virtualopeninvitational") !== false) {
  // header("Location: welcomeVOI.php");
}
// if (!isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'],"virtualopeninvitational")==false && strpos($_SERVER['HTTP_REFERER'],"flltutorials")==false) header("Location: /index.php?source=welcomeVOI.php");

?>

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="/js/download.js"></script>

<script>
    language = "en"
</script>
<script src="/js/languages.js"></script>
<script src="/js/language-detector.js"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> -->
  <title>Tournament Scoring System</title>
</head>

<body>
  <script>
    $(function() {
      $("#topbar").load("topbar.php");
    });
  </script>
  <div id="topbar"></div><br>
  <div>

    <script>
      $(function() {
        $("#header").load("header.html");
      });
    </script>
    <div id="header"></div>

    <br>
    <section>
      <div class="text-body">

        <?php
        // Initialize the session
        session_start();
        if (trim($_SESSION["username"]) == "guest") header("Location: logout.php");


        // Check if the user is logged in, if not then redirect him to login page
        // if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        //   header("location: login.php");
        //   exit;
        // }
        ?>

        <div class="page-header">
          <h1>Welcome <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
        </div>
      </div>
    </section><br>
    <div class="text-body" style="font-size: 20px;">

     
      <section>
        <div>
          <h2>Login to Existing Tournament:</h2>
        </div>
      </section><br>
      <section>
        <div>
          <script>
            function loadtourn(tourn) {
              document.getElementById('text').value = tourn
              document.getElementById('sub').click()

            }

            // tournaments = textFileToArray('tournaments.txt')
            x = 0
            // while (x != tournaments.length) {
            //   //document.write('<button onclick="loadtourn(\''+tournaments[x]+'\')">'+tournaments[x]+'</button><br>')
            //   x = x + 1
            // }
          </script>
          <table style='width:100%;font-size:20px;border-collapse: collapse;' border="1">
            <tr style="background-color: orange; color: black !important;">
              <td>Tournament</td>
              <td>Region</td>
              <td>Date</td>
            </tr>
            <?php
            $tourns = glob("tournaments/*/tournament.txt*");
            sort($tourns);
            foreach ($tourns as $filename) {
              if (file_exists(str_replace("tournament.txt", "userdata", $filename) ."/". $_SESSION["username"]) || $_GET["show"]=="all") {
                //	echo $filename."<br />";
                $file = fopen($filename, "r");
                $x = trim(fgets($file));
                $y = str_replace("'", "\'", $x);
                $link = str_replace("tournament.txt", "login.php", $filename);
                echo '<tr><td><a href="' . $link . '">' . $x . '</a></td><td>' . trim(fgets($file)) . '</td><td>' . trim(fgets($file)) . '</td>';
                fclose($file);
              }
            }
            ?>
          </table>
        </div>

    </div>
    </section>
    <br>
    <script>
      $(function() {
        $("#footer").load("footer.html");
      });
    </script>
    <div id="footer"></div>
  </div>
  <script src="/js/translate.js"></script>
</body>