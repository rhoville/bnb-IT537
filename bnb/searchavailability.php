<script>
    // Document Ready function
$(document).ready(function () {
    // Event listener for form submission
    $("#availabilityForm").on("submit", function (e) {
        // Prevent default form submission
        e.preventDefault();

        // Get form values
        let startDate = $("#startDate").val();
        let endDate = $("#endDate").val();

        // AJAX request
        $.ajax({
            type: "POST",
            url: "checkavailability.php",
            data: {
                startDate: startDate,
                endDate: endDate
            },
            dataType: "json",
            success: function (response) {
                // Clear any existing rows in the tbody
                $("#availableRooms tbody").empty();

                // Loop through the JSON array and append rows
                $.each(response, function (index, room) {
                    let newRow = `<tr>
                                    <td>${room.roomID}</td>
                                    <td>${room.roomname}</td>
                                    <td>${room.roomtype}</td>
                                    <td>${room.beds}</td>
                                  </tr>`;
                    $("#availableRooms tbody").append(newRow);
                });
            },
            // Error handler
            error: function (error) {
                console.error("Error:", error);
            }
        });
    });
});

</script>
    <h2>Search for Room Availability</h2>
    
    <form id="availabilityForm">
        <div class="date-input">
            <label for="startDate">Start Date:</label>
            <input type="text" id="startDate" name="startDate" placeholder="dd-mm-yyyy">
        </div>
        <div class="date-input">
            <label for="endDate">End Date:</label>
            <input type="text" id="endDate" name="endDate" placeholder="dd-mm-yyyy">
        </div>
        <button type="submit">Search availability</button>
    </form>

    <table id="availableRooms">
        <thead>
            <tr>
                <th>Room ID</th>
                <th>Room Name</th>
                <th>Room Type</th>
                <th>Beds</th>
            </tr>
        </thead>
        <tbody>
            <!-- Available rooms will be inserted here -->
        </tbody>
    </table>
</div>
    </div>
    </body>
</html>