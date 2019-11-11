<?php include("../source/php/Percentages.class.php"); ?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Percentages: a JavaScript function and PHP class for calculating percentages</title>
  <!-- CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h1>Percentages</h1>
        <p>This example uses both the PHP class and the JavaScript function. Initially, all percentages are calculated with the class. Casting votes will trigger the JavaScript function.</p>

        <h2>Example poll</h2>
        <p>For the sake of the demo, the amount of votes is shown and voting will not be disabled after you cast a vote.</p>
        <?php
        // Example amount of votes
        $votes = array(21, 13, 4, 0, 3, 1);
        // Voting options
        $frameworks = array(
          array("name" => "Bootstrap",            "votes" => $votes[0]),
          array("name" => "Foundation",           "votes" => $votes[1]),
          array("name" => "Materialize",          "votes" => $votes[2]),
          array("name" => "Pure.css",             "votes" => $votes[3]),
          array("name" => "My own framework",     "votes" => $votes[4]),
          array("name" => "No framework at all",  "votes" => $votes[5])
        );
        // Calculate percentages
        $percentages = new Percentages($votes);
        $percentages = $percentages->get("corrected");
        ?>

        <div class="row">
          <div class="col-sm-6">
            <form id="example-poll">
              <table class="table">
                <thead>
                  <tr>
                    <th>My favorite framework:</th>
                    <th>Votes</th>
                    <th>%</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  // Create a row for each option
                  foreach($frameworks as $framework) {
                  ?>
                    <tr>
                      <td class="option">
                        <button type="button" class="btn btn-primary btn-sm" value="<?php echo $i; ?>"><?php echo $framework["name"]; ?></button>
                      </td>
                      <td class="votes"><?php echo $framework["votes"]; ?></td>
                      <td class="percentage"><?php echo $percentages[$i]; ?>%</td>
                    </tr>
                  <?php
                  $i++;
                  } ?>
                </tbody>
              </table>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script type="text/javascript" src="../source/js/Percentages.js"></script>
  <script type="text/javascript" src="example.js"></script>

</body>
</html>
