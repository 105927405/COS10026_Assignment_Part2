<!DOCTYPE html>
<html lang = "en">

<body>
    <?php include 'header.inc'; ?>

<div class = "JobContainer">

    <article>
        <h2> Available Positions </h2>
        <p> Blade EduNet is an Educational Technology company which focuses on developing digital learning tools and platforms.
             We are seeking web developers and designers to support accessible and inclusive online education services.
             Our company is dedicated to a proffesional environment where all staff and guests are treated with respect. 
             If you would like to apply for a position at Blade EduNet, our currently avalible positions are listed below. 
        </p>
        <hr class = "hrSpecial">
    </article>

</div>

<?php

require_once 'settings.php';

$sql = "SELECT * FROM Jobs";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        
?>

<div class = "JobContainer">
    <section>
            <h3><?php echo $row['Job_Name']; ?></h3>

            <aside> 
                <ul> 
                    <li> Pay 
                        <ul> 
                            <li> Annual Salary: $<?php echo $row['Pay']; ?> </li>
                        </ul>
                    </li>
                    <li> Hours 
                        <ul> 
                            <li> <?php echo $row['Hours']; ?> </li>
                        </ul>
                    </li>
                </ul>
                <a href="apply.php?ref=<?php echo $row['REF_NUM']; ?>"> 
                    Apply Now
                </a>
            </aside>
            <h4> About this position </h4>
            <p> <?php echo $row['Description']; ?>
            </p>
            <h5> Essential Skills: </h5>
            <p>
                <?php echo $row['E_Skills']; ?>
            </p>
            <h5> Preferable Skills: </h5>
            <p>
                <?php echo $row['P_Skills']; ?>
            </p>
</section>
</div>

<?php
    }
} else {
    echo "<p>No Jobs Available </p>";
}

$conn->close();

?>

<?php include 'footer.inc'; ?>
</body>
</html>
