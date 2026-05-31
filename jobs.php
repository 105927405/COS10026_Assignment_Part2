<!DOCTYPE html>
<html lang="en">

<body>
<?php include 'header.inc'; ?>

<div class="JobContainer">

    <article>
        <h2>Available Positions</h2>

        <p>
            Blade EduNet is an Educational Technology company which focuses on developing digital learning tools and platforms.
            We are seeking web developers and designers to support accessible and inclusive online education services.
        </p>

        <hr class="hrSpecial">

        <!-- SEARCH BOX -->
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search..."
                value="<?php if (isset($_GET['search'])) echo htmlspecialchars($_GET['search']); ?>">
            <button type="submit">Search</button>
        </form>

    </article>

</div>

<?php
require_once 'settings.php';

$conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

$search = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {

    $search = $_GET['search'];

    $sql = "
        SELECT * FROM Jobs
        WHERE
            REF_NUM LIKE '%$search%' OR
            Job_Name LIKE '%$search%' OR
            Pay LIKE '%$search%' OR
            E_Skills LIKE '%$search%' OR
            P_Skills LIKE '%$search%' OR
            Description LIKE '%$search%'
    ";

} else {
    $sql = "SELECT * FROM Jobs";
}

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
?>

<div class="JobContainer">
    <section>

        <h3><?php echo $row['Job_Name']; ?></h3>

        <aside>
            <ul>
                <li>Pay
                    <ul>
                        <li>Annual Salary: $<?php echo $row['Pay']; ?></li>
                    </ul>
                </li>

                <li>Hours
                    <ul>
                        <li><?php echo $row['Hours']; ?></li>
                    </ul>
                </li>
            </ul>

            <a href="EOI.php?ref=<?php echo $row['REF_NUM']; ?>">
                Apply Now
            </a>
        </aside>

        <h4>About this position</h4>
        <p><?php echo $row['Description']; ?></p>

        <h5>Essential Skills:</h5>
        <p><?php echo $row['E_Skills']; ?></p>

        <h5>Preferable Skills:</h5>
        <p><?php echo $row['P_Skills']; ?></p>

        <h5>Manager of Position:</h5>
        <p><?php echo $row['Manager']; ?></p>

    </section>
</div>

<?php
    }
} else {
    echo "<p>No Jobs Found</p>";
}

$conn->close();
?>

<?php include 'footer.inc'; ?>
</body>
</html>