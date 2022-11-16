<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
<?php

//include("studentDatabase.php");

// define variables and set to empty values
$nameErr = $lastnameErr = $genderErr =$rnErr = $count_value_err="";
$name = $gender = $rating = $count_value = "";


$servername = "172.19.0.2";
$username = "sde_project";
$password = "root123";
$dbname = "docker_sde";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $dbname);

//check connection

if(!$conn)
{
 die("connection failed: ". mysql_error());
}

// sql to create table

$sql = "CREATE TABLE ratings (
rating INT(2) PRIMARY KEY,
name VARCHAR(30);
gender VARCHAR(30) NOT NULL)";

if(mysqli_query($conn,$sql)){
echo "table ratings created successfully";
}

//else
//{
//echo "error creating table" . $conn->error;
//}



if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if (empty($_POST["rating"])) {
    $rnErr = "rating number is required";
  } else {
    $rno = $_POST["rating"];
  }


  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = $_POST["name"];
    }

 if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = $_POST["gender"];
  }
}

if (empty($_POST["count_value"])) {
   $count_value = "Enter a valid rating number";
}
else
{
$count_value = $_POST["count_value"];
}

?>


<h2>Student Details</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Rollno: <input type="text" name="rating" value="<?php echo $rating;?>">
  <span class="error">* <?php echo $rnErr;?></span>
  <br><br>
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  Gender:
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other">Other  
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>

  Retrieve total count of rating: <input type="text" name="count_value" value="<?php echo $count_value;?>">
  <span class="error">* <?php echo $count_value_err;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php


$sql = "INSERT INTO ratings (rating, name, gender) VALUES ('$rating','$name','$gender')";

if (mysqli_query($conn,$sql))
{
echo "New record created successfully";
}

$sql = "SELECT COUNT(rating) as COUNT_RATING FROM ratings WHERE rating=$count_value";
$result = mysqli_query($conn,$sql);
echo "<br><br>";

echo "Number of ratings for " . $count_value . " present in the database:";
echo "<br>------------------------------------";
echo "<br>";

if(mysqli_num_rows($result)>0)
{
while ($row = mysqli_fetch_array($result))
{

echo "Count value:" . $row["COUNT_RATIING"] . "<br>";
}
}

$sql = "SELECT * FROM ratings WHERE rating=$count_value";
$result = mysqli_query($conn,$sql);
echo "<br><br>";

echo "Corresponding entries present in the database:";
echo "<br>------------------------------------";
echo "<br>";

if(mysqli_num_rows($result)>0)
{
while ($row = mysqli_fetch_array($result))
{

echo "Rating " . $row["rating"] . "Name:" . $row["name"] . "Gender:" . $row["gender"] . "<br>";
} 
}



mysqli_close($conn);
?>

</body>
</html>
