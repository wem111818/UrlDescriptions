<?php 

require_once('config.php');

function postURL($UN,$UD){
   try {
      $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $sql = "INSERT INTO urltable (URL, description) VALUES ('$UN','$UD')";
      $pdo -> query($sql);
      
      $pdo = null;
      $GLOBALS["status"] = "Database updated successfully with ".$UN;
   }
   catch (PDOException $e) {
      die( $e->getMessage() );
   }
}

function displayPostStatus() {
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $UN = $_REQUEST['URLname'];
      $UD = $_REQUEST['URLdescription'];
      if($UN != "" && $UD != "") {
         postURL($UN,$UD);
      }
   }
   else {
      $GLOBALS["status"] = "Enter URL info and Submit";
   }
}

function displayUrls() {
   try {
      $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               
      $sql = 'select URL, description from urltable Order By URL';
      $result = $pdo->query($sql);
      while ($row = $result->fetch()) {
         outputSingleUrl($row);
      }
      $pdo = null;
   }
   catch (PDOException $e) {
      die( $e->getMessage() );
   }
}

function outputSingleUrl($row) {
   echo '<tr>';
   echo '<td>';
   echo $row['URL'];
   echo '</td>';
   echo '<td>';
   echo $row['description'];
   echo '</td>';
}

if(isset($_POST['submit'])){
   displayPostStatus();
}
else { 
   $GLOBALS["status"] = 'Not doing function';
}

if(isset($_POST["submit"])){
   displayPostStatus();
}
else { 
    $GLOBALS["status"] = 'Not doing function';
}

$status = 'Enter URL info and Submit';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Descriptions</title>
    <link href="URL-Descriptions.css" rel="stylesheet"> 
  </head>
<body>
<main>
      <div>
         <h1>URL Descriptions</h1>
      </div>
      <div>
         <div>
            <p>Please enter a URL and a description</p>
         </div>
         <form action = '<?php echo displayPostStatus(); ?>' method="POST">
            <div>
               <p class='UserInput'>URL</p>
               <input type="text" name="URLname" placeholder="Enter URL" required><br/>
            </div>
            <div>
               <p class='UserInput'>Description of the URL</p>
               <input type="text" name="URLdescription" placeholder="Enter description" required>
               <input type="submit" value="Submit">
            </div>
         </form>
         <p class="status"><?php echo $GLOBALS["status"];?></p>
         <table class="table">
            <thead>
               <tr>
                  <th class = t-header>URL</th>
                  <th class = t-header>description</th>
               </tr>
            </thead>
            <tbody>
               <tr><?php displayUrls() ?></tr>
            </tbody>
         </table>
      </div>            
</main>

</body>
</html>