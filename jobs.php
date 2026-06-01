<head>
    <meta charset="utf-8">
    <title>Blade EduNET - Jobs</title>
    <link rel="stylesheet" href="Styles/Style.css">
</head>

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

        <!-- SEARCH BOX (FIXED: no action attribute) -->
        <form method="GET">
            <input type="text" name="search" placeholder="Search..."
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
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

/* SAFE SEARCH (FIXED: prevents SQL injection) */
$search = isset($_GET['search'])
    ? '%' . strtolower(trim($_GET['search'])) . '%'
    : '%';

$sql = "
    SELECT *
    FROM Jobs
    WHERE
        CAST(REF_NUM AS CHAR) LIKE ?
        OR LOWER(Job_Name) LIKE ?
        OR CAST(Pay AS CHAR) LIKE ?
        OR LOWER(E_Skills) LIKE ?
        OR LOWER(P_Skills) LIKE ?
        OR LOWER(Description) LIKE ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssss",
    $search,
    $search,
    $search,
    $search,
    $search,
    $search
);

$stmt->execute();
$result = $stmt->get_result();

/* OUTPUT */
if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
?>

<div class="JobContainer">
    <section>

        <h3><?php echo htmlspecialchars($row['Job_Name']); ?></h3>

        <aside>
            <ul>
                <li>Pay
                    <ul>
                        <li>Annual Salary: $<?php echo htmlspecialchars($row['Pay']); ?></li>
                    </ul>
                </li>

                <li>Hours
                    <ul>
                        <li><?php echo htmlspecialchars($row['Hours']); ?></li>
                    </ul>
                </li>
            </ul>

            <a href="EOI.php?job=<?php echo urlencode($row['REF_NUM']); ?>">
                Apply Now
            </a>
        </aside>

        <h4>About this position</h4>
        <p><?php echo htmlspecialchars($row['Description']); ?></p>

        <h5>Essential Skills:</h5>
        <p><?php echo htmlspecialchars($row['E_Skills']); ?></p>

        <h5>Preferable Skills:</h5>
        <p><?php echo htmlspecialchars($row['P_Skills']); ?></p>

        <h5>Manager of Position:</h5>
        <p><?php echo htmlspecialchars($row['Manager']); ?></p>

    </section>
</div>

<?php
    }
} else {
    echo "<p>No Jobs Found</p>";
}

$stmt->close();
$conn->close();
?>

<?php include 'footer.inc'; ?>

</body>
</html>