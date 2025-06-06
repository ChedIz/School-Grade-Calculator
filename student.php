<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $enabling = $_POST['enabling'];
    $summative = $_POST['summative'];
    $finalExam = $_POST['final_exam'];

    $participation = calculateAverage($enabling);
    $summativeGrade = calculateAverage($summative);
    $finalGrade = calculateFinalGrade($participation, $summativeGrade, $finalExam);
    $letter = getLetterGrade($finalGrade);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Grade Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Student Grade Result</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Class Participation</th>
                <th>Summative Grade</th>
                <th>Final Exam</th>
                <th>Final Grade</th>
                <th>Letter Grade</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= htmlspecialchars($name) ?></td>
                <td><?= number_format($participation, 2) ?></td>
                <td><?= number_format($summativeGrade, 2) ?></td>
                <td><?= number_format($finalExam, 2) ?></td>
                <td><?= $finalGrade ?></td>
                <td><?= $letter ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <a href="index.php">← Enter Another Student</a>
</div>
</body>
</html>
