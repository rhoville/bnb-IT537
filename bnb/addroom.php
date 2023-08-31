<?php
session_start();
?>

<!DOCTYPE HTML>
<html>

<head>
  <title>Home Page</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="style/style.css" title="style" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    .header-container {
      display: flex;
      flex-direction: column;
      align-items: left;
      padding: 20px;
      background-color: #000000;
    }
    .logo {
      width: 200px;
      height: auto;
      object-fit: contain;
    }
    .slogan {
      margin-top: 10px;
      font-size: 14px;
      font-weight: bold;
      color: #ffffff;
    }
    .social-media {
      margin-top: 20px;
    }
    .social-media a {
      margin: 0 10px;
      font-size: 24px;
      color: white; 
    }
    .li {
      color: #ffffff;
    }
    .welcome-message {
  color: yellow;
  font-size: 16px;
  margin-bottom: 10px;
  text-align:  right;
    }
    .box-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 40vh; 
    flex-wrap: wrap; 
    margin-top: 50px;
}
        .box {
            width: 200px;
            height: 200px;
            margin: 10px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .box:hover {
            transform: translateY(-10px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        }

        .box a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
        }

.form{
  margin-top: 50px;
}
a {
  text-decoration: none;
}
  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
      <div id="content">
      <?php
//function to clean input but not validate type and content
function cleanInput($data) {  
  return htmlspecialchars(stripslashes(trim($data)));
}

//the data was sent using a formtherefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Add')) {
//if ($_SERVER["REQUEST_METHOD"] == "POST") { //alternative simpler POST test    
    include "config.php"; //load in any variables
    $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
        exit; //stop processing the page further
    };

//validate incoming data - only the first field is done for you in this example - rest is up to you do
//roomname
    $error = 0; //clear our error flag
    $msg = 'Error: ';
    if (isset($_POST['roomname']) and !empty($_POST['roomname']) and is_string($_POST['roomname'])) {
       $fn = cleanInput($_POST['roomname']); 
       $roomname = (strlen($fn)>50)?substr($fn,1,50):$fn; //check length and clip if too big
       //we would also do context checking here for contents, etc       
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid roomname '; //append eror message
       $roomname = '';  
    } 
 
//description
       $description = cleanInput($_POST['description']);        
//roomtype
       $roomtype = cleanInput($_POST['roomtype']);            
//beds    
       $beds = cleanInput($_POST['beds']);        
       
//save the room data if the error flag is still clear
    if ($error == 0) {
        $query = "INSERT INTO room (roomname,description,roomtype,beds) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($DBC,$query); //prepare the query
        mysqli_stmt_bind_param($stmt,'sssd', $roomname, $description, $roomtype,$beds); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>New room added to the list</h2>";        
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
    mysqli_close($DBC); //close the connection once done
}
?>
<h1>Add a new room</h1>
<a href='roomlist.php'>[Return to the room listing]</a><a href='./maintenance.php'>[Return to the main page]</a>

<form class= "form" method="POST" action="addroom.php">
  <p>
    <label for="roomname">Room name: </label>
    <input type="text" id="roomname" name="roomname" minlength="5" maxlength="50" required> 
  </p> 
  <p>
    <label for="description">Description: </label>
    <textarea type="text" id="description" row="3" cols="8" name="description" minlength="5" maxlength="200" required> </textarea>
  </p>  
  <p>  
    <label for="roomtype">Room type: </label>
    <input type="radio" id="roomtype" name="roomtype" value="S"> Single 
    <input type="radio" id="roomtype" name="roomtype" value="D" Checked> Double 
   </p>
  <p>
    <label for="beds">Beds (1-5): </label>
    <input type="number" id="beds" name="beds" min="1" max="5" value="1" required> 
  </p> 
  
   <input type="submit" name="submit" value="Add">
 </form>
    
      </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>

