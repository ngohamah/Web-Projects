<!doctype html>
<html lang="en">
  <head>
    <title>ChallengerFx Signal Booking</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php" style="color:black">
          <img src="assets/brand/challengerfx logo.jpg" alt="" width="80" height="80" class="d-inline-block align-text-middle">
          ChallengerFx Signal Booking
        </a>
      </div>
    </nav>
    <br>

    <!-- Code for getting records to update or delete into the data entry section -->
    <?php require('db_connect.php');
      if(isset($_GET['updateid']) || isset($_GET['deleteid'])){
        $sn_update = $_GET['updateid'];
        $sn_delete = $_GET['deleteid'];

        if($sn_update){
          $sql= "SELECT * FROM `signups` WHERE sn = '$sn_update'";
          $results = $conn->query($sql);
        }

        if($sn_delete){
          $sql= "SELECT * FROM `signups` WHERE sn = '$sn_delete'";
          $results = $conn->query($sql);
        }

        if($results->num_rows==1){
          $row=$results->fetch_assoc();
          $sn=$row['sn'];
          $fullname=$row['fullname'];
          $telegram=$row['telegram'];
          $date=$row['paymentdate'];
        }
      }

    ?>

    <form action="index.php" method="post">
      <div class="row g-3 container-sm m-auto">
        <div class="col-sm">
          <div class="form-floating">
            <input type="text" readonly class="form-control" id="floatingInputGrid" placeholder="sn" value="<?php echo $sn?>" name="sn">
            <label for="floatingInputGrid">SN</label>
          </div>
        </div>
        <div class="col-sm">
          <div class="form-floating">
            <input type="text" class="form-control" id="floatingInputGrid" placeholder="Enter full name" value="<?php echo $fullname?>" name="fullname">
            <label for="floatingInputGrid">Full Name</label>
          </div>
        </div>
        <div class="col-sm">
          <div class="form-floating">
            <input type="text" class="form-control" id="floatingInputGrid" placeholder="Enter Telegram name" value="<?php echo $telegram?>" name="telegram">
            <label for="floatingInputGrid">Telegram name</label>
          </div>
        </div>
        <div class="col-sm">
          <div class="form-floating">
            <input type="date" class="form-control" id="floatingInputGrid" value="<?php echo $date?>" name="date">
            <label for="floatingInputGrid">Payment date</label>
          </div>
        </div>
        <div class="col-sm">
          <div>
            <?php
               if(isset($_GET['updateid']))
               {
                echo "                 
                  <input type='submit' class='btn bg-black' style='width:8em; height:3.5em; color:white; font-weight:bold;' name='update' value='Update'>
                  ";
               }else if(isset($_GET['deleteid'])){
                echo "
                  <input type='submit' class='btn bg-black' style='width:8em; height:3.5em; color:white; font-weight:bold;' name='delete' value='Delete'>
                  ";
               }else{
                echo "
                  <input type='submit' class='btn bg-black' name='submit' style='width:8em; height:3.5em; color:white; font-weight:bold;' value='Enter'>
                ";
               }
            ?>
          </div>
        </div>
      </div>
    </form>

    <?php require('daysCount.php');
      if(isset($_POST['submit'])){
        $sn = $_POST['sn'];
        $fullname = $_POST['fullname'];
        $telegram = $_POST['telegram'];
        $date = $_POST['date'];
        
        //calculating dayscount

        $dayscount = daysCount($date);

        $sql = "INSERT INTO signups (fullname, telegram, paymentdate,dayscount)
        VALUES ('$fullname', '$telegram', '$date','$dayscount')";

        if (mysqli_query($conn, $sql)) {
          echo "<div class='container-sm' style='padding-top:5px; color:green; font-size:0.9em;'>New Signal member added successfully";
          } else {
          echo "<div class='container-sm' style='padding-top:5px; color:green; font-size:0.9em;'>An error occured while adding member";
          }
      }

      // Code to update record
      if(isset($_POST['update'])){
        $sn = $_POST['sn'];
        $fullname = $_POST['fullname'];
        $telegram = $_POST['telegram'];
        $date = $_POST['date'];
        
        $dayscount = daysCount($date);



        $sql = "UPDATE `signups` SET `fullname` = '$fullname', `telegram`='$telegram', `paymentdate`='$date', `dayscount`='$dayscount' WHERE `sn`='$sn'";
        
        if (mysqli_query($conn, $sql)) {
          echo "<div class='container-sm' style='padding-top:5px; color:green; font-size:0.9em;'>Signal member updated successfully";
          } else {
          echo "<div class='container-sm' style='padding-top:5px; color:green; font-size:0.9em;'>An error occured while updating member";
          }
      }

      // Code to delete record
      if(isset($_POST['delete'])){
        $sn = $_POST['sn'];
        
        $sql = "DELETE FROM `signups` WHERE `sn`='$sn'";

        if (mysqli_query($conn, $sql)) {
          echo "<div class='container-sm' style='padding-top:5px; color:red; font-size:0.9em;'>Signal member removed successfully";
          } else {
          echo "<div class='container-sm' style='padding-top:5px; color:red; font-size:0.9em;'>An error occured while removing member";
        }
      }
    ?>

    <br><br>

    <!-- Active, Expired and Search box -->
    <div class='container-sm'>

      <!-- Building active and expired buttons -->
      <a type="button" href='index.php?active=true' class="btn btn-success" style='width:25; height:25; color:white'>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
          <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
        </svg> Active</a>
      <a type="button" href='index.php?expired=true' class="btn btn-danger" style='width:25; height:25; color:white'>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
          <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
        </svg> Expired</a>

        <!-- Building search box -->
        <div style='display:inline-block; max-width:350px; margin-top:4px; float:right;'>
          <form action='index.php' method='get'>
            <div class="input-group">
              <input type="text" class="form-control" placeholder = 'Enter name or telegram'>
              <input type="submit" name='searchterm' class="btn btn-outline-secondary" value='Search' />
            </div>
          </form>
      </div>
    </div>
    
    <br>

    <!-- Reading results from the database, scroll behavior not so cool yet-->

    <div class="row g-3 container-sm m-auto" style='height:400px; overflow: auto;'>
      <table class="table table-sm">
        <thead style='font-size:1.2em;'>
            <tr class='bg-black' style='position: -webkit-sticky; position: sticky; top: 0; color:white; z-index: 1;'>
                <th scope="col">SN</th>
                <th scope="col">Name</th>
                <th scope="col">Telegram</th>
                <th scope="col">PaymentDate</th>
                <th scope="col" title="Remaining or Exceeded">Days</th>
                <th scope="col">Action</th>
                
            </tr>
        </thead>
        <tbody>
          <?php

            // active and expired member filters as well as search term.

            if(isset($_GET['active'])){
              $sql = "SELECT * FROM signups ORDER BY `dayscount` DESC";
            }
            
            if(isset($_GET['expired'])){
              $sql = "SELECT * FROM signups ORDER BY `dayscount` ASC";
            }
            
            if(!isset($_GET['active']) && !isset($_GET['expired'])){
              $sql = "SELECT * FROM signups";
            }

            /**key aspect of code -- continue. */
            if(isset($_GET['searchterm'])){
              $searchterm = $_GET['searchterm'];
              
            }
      
            $result = $conn->query($sql);

            $totalmembers = $result->num_rows;

            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                echo "<tr>";
                
                echo "<td>".$row["sn"]."</td>";
                echo "<td>".$row["fullname"]."</td>";
                echo "<td>".$row["telegram"]."</td>";
                echo "<td>".$row["paymentdate"]."</td>";

                // Taking into account the difference between currentday and when registration occurred it 
                // each time we read the information.
                
                $dayscount = daysCount($row['paymentdate']);

                if($dayscount>0){
                  echo "<td style='color:green'>".$dayscount." "."days"."</td>";
                }else{
                  echo "<td style='color:red'>".$dayscount." "."days"."</td>";
                }
                

                ?>
                  <td colspan=2> 
                    <a href='index.php?updateid=<?php echo $row['sn'];?>' class='btn btn-secondary' name='update' style="color:white; width: 7em; height:2.5em; margin-bottom:2px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                      <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                      <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg> Update</a>
                    <a href='index.php?deleteid=<?php echo $row['sn'];?>' class='btn btn-danger' name='delete' style="color:white;  width: 7em; height:2.5em;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                    </svg> Delete</a>
                  </td>
                </tr>
                <?php
              }
            } else {
              echo "0 results";
            }
            $conn->close();
          ?>
        </tbody>
      </table>
    </div>
    <div class='container-sm' style='bottom:0; text-align:left; margin-top:5em;'>
      <?php echo "<p style='font-weight:bold'>$totalmembers members</p>";?>
    </div>
    <div class='container-sm' style='bottom:0; text-align:center; margin-top:5em;'>
      <hr>
      <p class="mt-5 mb-3 text-muted">ChallengerFx &copy; 2022</p>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>