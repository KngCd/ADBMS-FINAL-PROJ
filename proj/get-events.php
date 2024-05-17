<?php
// get-events.php
include ('config.php');

// get-events.php
session_start();

$id = $_SESSION['id'];

// Query the database to retrieve the events
$sql = "SELECT c.classcode, cs.classcode, cs.student_id, ac.topic, ac.description,
ac.due_date, ac.time, ac.classcode, ac.teacher_id FROM class_student cs JOIN class c ON cs.classcode = c.classcode
JOIN activity ac ON c.classcode = ac.classcode WHERE cs.student_id = '$id'";
$result = mysqli_query($con, $sql);

// Create an array to store the events
$events = array();

// Loop through the results and create an event object for each item
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = array(
        'title' => $row['topic'],
        'end' => $row['due_date'],
        'extendedProps' => array(
            'topic' => $row['topic'],
            'time' => $row['time']
        )
    );
}

// Close the database connection
mysqli_close($con);

// Output the events in JSON format
header('Content-Type: application/json');
echo json_encode($events);
?>