<?php
session_start();

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Handle student deletion
if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    if (isset($_SESSION['students'][$index])) {
        unset($_SESSION['students'][$index]);
        $_SESSION['students'] = array_values($_SESSION['students']); // reindex
    }
    header("Location: index.php");
    exit();
}

// Handle full reset
if (isset($_GET['reset'])) {
    $_SESSION['students'] = [];
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    function calculateAverage($grades) {
        return array_sum($grades) / count($grades);
    }

    function calculateFinalGrade($participation, $summative, $exam) {
        return round(($participation * 0.30) + ($summative * 0.30) + ($exam * 0.40));
    }

    function getLetterGrade($grade) {
        if ($grade >= 90) return 'A';
        elseif ($grade >= 80) return 'B';
        elseif ($grade >= 70) return 'C';
        elseif ($grade >= 60) return 'D';
        else return 'F';
    }

    $name = $_POST['name'];
    $enabling = $_POST['enabling'];
    $summative = $_POST['summative'];
    $finalExam = $_POST['final_exam'];

    $participation = calculateAverage($enabling);
    $summativeGrade = calculateAverage($summative);
    $finalGrade = calculateFinalGrade($participation, $summativeGrade, $finalExam);
    $letter = getLetterGrade($finalGrade);

    $_SESSION['students'][] = [
        'name' => $name,
        'participation' => $participation,
        'summative' => $summativeGrade,
        'exam' => $finalExam,
        'final' => $finalGrade,
        'letter' => $letter
    ];

    header("Location: index.php"); // avoid resubmission
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FEU Grade Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
   <img src="feulogo (1).png"
     alt="FEU Logo"
     style="display:block; margin: 0 auto 20px auto; height: 80px; object-fit: contain;">


    <h1>FEU Student Grade Calculator</h1>

    <!-- Grade Entry Form -->
    <form action="index.php" method="post">
        <h2>Enter Student Details</h2>

        <label>Name of Student:</label>
        <input type="text" name="name" required>

        <h3>Enabling Assessments (5)</h3>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <label>Assessment <?= $i ?>:</label>
            <input type="number" name="enabling[]" min="0" max="100" required>
        <?php endfor; ?>

        <h3>Summative Assessments (3)</h3>
        <?php for ($i = 1; $i <= 3; $i++): ?>
            <label>Summative <?= $i ?>:</label>
            <input type="number" name="summative[]" min="0" max="100" required>
        <?php endfor; ?>

        <h3>Final Exam</h3>
        <label>Final Exam Grade:</label>
        <input type="number" name="final_exam" min="0" max="100" required>

        <input type="submit" value="Submit Student Grade">
    </form>

    <!-- Student Grade Table -->
    <?php if (!empty($_SESSION['students'])): ?>
        <h2>Submitted Students</h2>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Participation</th>
                <th>Summative</th>
                <th>Final Exam</th>
                <th>Final Grade</th>
                <th>Letter</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($_SESSION['students'] as $index => $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['name']) ?></td>
                    <td><?= number_format($s['participation'], 2) ?></td>
                    <td><?= number_format($s['summative'], 2) ?></td>
                    <td><?= number_format($s['exam'], 2) ?></td>
                    <td><?= $s['final'] ?></td>
                    <td><?= $s['letter'] ?></td>
                    <td><a class="delete" href="?delete=<?= $index ?>">Delete</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <a class="reset" href="?reset=1">🔄 Reset All Students</a>
    <?php endif; ?>
</div>
</body>
</html>
