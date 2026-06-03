<!DOCTYPE html>
<html lang="en">

<?php include 'header.inc'; ?> 

 
<body>


<div class="AboutContainer">
<h2>About Blade EduNET</h2>
 
<p>
  Using <strong>Blade EduNET</strong>, you will find the latest educational support
  and applications to help students learn, grow, and access opportunities.
</p>
 
<p>
  At <strong>Blade EduNET</strong>, we strive to provide the best educational support
  for students from different backgrounds.
</p>
 
<p>
  “No education is the restriction of the mind”
</p>

 
<figure class="groupImage">
<img src="Styles/Images/groupphoto.jpg" alt="Blade EduNET team members">
<figcaption>Blade EduNET Team Members</figcaption>
</figure>

 

<h3>About the Group</h3>
 

<?php
    require_once 'settings.php';
 
    $conn = new mysqli($host, $user, $password, $database);
 
    if ($conn->connect_error) {
      die("Database connection failed: " . $conn->connect_error);
        }
 
    $result = $conn->query("SELECT * FROM about");
 
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
?>
<article>
<h4><?php echo htmlspecialchars($row['Name']); ?></h4>
<p><?php echo htmlspecialchars($row['Contributions']); ?></p>
</article>
<?php
      }
    } else {
      echo "<p>No group information available.</p>";
    }
 
    $conn->close();
?>

 

<h3>Fun Facts About Us</h3>
 

<table>
<tr>
<th>Name</th>
<th>Age</th>
<th>Hobbies</th>
<th>Uni Club</th>
<th>Favourite Song</th>
<th>Favourite Food</th>
<th>Other Fun Facts</th>
</tr>
 
<tr>
<td>Aaron</td>
<td>24</td>
<td>Motorsports, Gaming, History</td>
<td>Swinburne Race Team</td>
<td>Let Down by Radiohead</td>
<td>Seven Stars Menthol and Hibiki</td>
<td>Went to Chisholm TAFE before University</td>
</tr>
 
<tr>
<td>Marcus</td>
<td>24</td>
<td>Gaming, Anime, Reading</td>
<td>Swinburne Rover Team</td>
<td>Outlaws Get No Entry</td>
<td>Burgers</td>
<td>Spent 7 years in St John's</td>
</tr>
 
<tr>
<td>Blake</td>
<td>19</td>
<td>Gaming, Networking, Music</td>
<td>Swinburne Rover Team</td>
<td>Taylor Swift</td>
<td>Pasta &amp; Mango</td>
<td>Built a server farm at 15</td>
</tr>
</table>


 

<h3>Classes</h3>
 
<dl>
<dt>Web Technology</dt>
<dd>COS10026</dd>
<dd>Atie Kia</dd>
 
<dt>User Experience Design Project</dt>
<dd>ICT20025</dd>
<dd>Dr Karola von Baggo</dd>
 
<dt>Network Routing Principles</dt>
<dd>TNE20002 / TNE70003</dd>
<dd>Patrick Cage</dd>
 
<dt>Network Security and Resilience</dt>
<dd>TNE30009</dd>
<dd>Peter Branch</dd>
</dl>

 

<h3>Time Table</h3>
 

<table>
<tr>
<th>Time</th>
<th>Monday</th>
<th>Tuesday</th>
<th>Wednesday</th>
<th>Thursday</th>
<th>Friday</th>
</tr>
 
<tr>
<td>8:30 - 10:30</td>
<td>ICT20025</td>
<td></td>
<td></td>
<td></td>
<td>TNE20002</td>
</tr>
 
<tr>
<td>10:30 - 12:30</td>
<td></td>
<td>TNE30009</td>
<td></td>
<td></td>
<td>TNE20002</td>
</tr>
 
<tr>
<td>12:30 - 14:30</td>
<td>TNE30009</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
 
<tr>
<td>13:30 - 15:30</td>
<td>TNE20002</td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
 
<tr>
<td>14:30 - 16:30</td>
<td></td>
<td>ICT20025</td>
<td></td>
<td></td>
<td>COS10026</td>
</tr>
</table>

</div>
 
</body>
<?php include 'footer.inc'; ?>
</html>