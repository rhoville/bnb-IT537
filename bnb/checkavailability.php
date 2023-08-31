<?php
include 'config.php';
$conn = connect();

// Initialize an array to hold available rooms
$availableRooms = [];

// Get start and end dates from POST data
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

// SQL query to check for available rooms
$sql = "SELECT room.roomID, room.roomname, room.roomtype, room.beds
        FROM room
        WHERE room.roomID NOT IN (
          SELECT booking.roomID
          FROM booking
          WHERE (booking.checkinDate <= ? AND booking.checkoutDate >= ?)
          OR (booking.checkinDate < ? AND booking.checkoutDate >= ?)
          OR (? <= booking.checkinDate AND booking.checkinDate <= ?)
        )";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $endDate, $startDate, $endDate, $startDate, $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

// Add available rooms to the array
while ($row = $result->fetch_assoc()) {
    $availableRooms[] = $row;
}

// Close database connection
$conn->close();

// Send back available rooms as JSON
echo json_encode($availableRooms);
?>
