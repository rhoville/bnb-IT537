<?php
session_start();
include "config.php"
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
  <script>
        function filterCustomers() {
            let input = document.getElementById('searchBar');
            let filter = input.value.toUpperCase();
            let table = document.getElementById('customerTable');
            let trs = table.getElementsByTagName('tr');

            for (let i = 1; i < trs.length; i++) {
                let td = trs[i].getElementsByTagName('td')[0];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        trs[i].style.display = "";
                    } else {
                        trs[i].style.display = "none";
                    }
                }
            }
        }
    </script>
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

        .search {
    display: flex;
    align-items: center;
    margin-top: 20px;
    margin-bottom: 20px;
}

.search label {
    font-weight: bold;
    margin-right: 10px;
}

.search input[type="text"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    width: 200px;
    transition: border-color 0.3s;
}

.search input[type="text"]:focus {
    border-color: #4caf50;
    outline: none;
}

  </style>
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'menubar.php'; ?>

  <div id="site_content">
  <?php include 'sidebar.php'; ?>
  
      <div id="content">
  <h2>Customer List</h2>
  <a href="addcustomer.php">[Add a Customer]</a> | <a href="maintenance.php">[Return to Main Page]</a>
  <div class= "search">
  <label for="searchBar">Search Customer:</label>
    <input type="text" id="searchBar" placeholder="Search by Last Name..." onkeyup="filterCustomers()"></div>

  <table border="1" id="customerTable">
    <thead>
      <tr>
        <th>Lastname</th>
        <th>Firstname</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Create a connection
      $conn = connect();

      // Check if connection was successful
      if ($conn === false) {
        die("ERROR: Could not connect to the database. " . mysqli_connect_error());
      }

      // Define the SQL query to retrieve data
      $sql = "SELECT customerID,lastname, firstname FROM customer"; // Modify this SQL query according to your database and table structure

      // Prepare the SQL statement
      $stmt = mysqli_prepare($conn, $sql);

      // Check if statement was prepared successfully
      if ($stmt === false) {
        die("ERROR: Could not prepare SQL statement. " . mysqli_error($conn));
      }

      // Execute the query
      mysqli_stmt_execute($stmt);

      // Bind result variables
      mysqli_stmt_bind_result($stmt,$customerID, $lastname, $firstname);

      // Fetch data and populate the table
      while (mysqli_stmt_fetch($stmt)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($lastname) . "</td>";
        echo "<td>" . htmlspecialchars($firstname) . "</td>";
        echo "<td>";
        echo "<a href='viewcustomer.php?id=" . $customerID . "'>View</a> | ";  // Assuming you want to use lastname as id
        echo "<a href='editcustomer.php?id=" . $customerID . "'>Edit</a> | ";  // Assuming you want to use lastname as id
        echo "<a href='deletecustomer.php?id=" . $customerID . "'>Delete</a>";  // Assuming you want to use lastname as id
        echo "</td>";
        echo "</tr>";
    }
    

      // Close the statement
      mysqli_stmt_close($stmt);

      // Close the connection
      mysqli_close($conn);
      ?>
    </tbody>
  </table>
</div>

      </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>

