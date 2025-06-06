<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Grade Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Student Grade Calculator</h1>
    <p>This system will compute grades for 5 students based on your input.</p>
    <form action="students.php" method="post">
       <h2>Enter Student Details</h2>

    <label for="name">Name of Student:</label>
    <input type="text" name="name" required><br>

    <h3>Enabling Assessments (5)</h3>
    <?php
    for ($i = 1; $i <= 5; $i++) {
        echo "<label>Assessment $i:</label>";
        echo "<input type='number' name='enabling[]' min='0' max='100' required><br>";
    }
    ?>

    <h3>Summative Assessments (3)</h3>
    <?php
    for ($i = 1; $i <= 3; $i++) {
        echo "<label>Summative $i:</label>";
        echo "<input type='number' name='summative[]' min='0' max='100' required><br>";
    }
    ?>

    <h3>Final Exam</h3>
    <label for="final_exam">Final Exam Grade:</label>
    <input type="number" name="final_exam" min="0" max="100" required><br><br>

    <input type="submit" value="Submit Student Grade">
    </form>
</body>
</html>
