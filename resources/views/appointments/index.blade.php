<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
</head>
<body>
    <h1>Book an Appointment</h1>
    <form id="appointmentForm">
        <label for="doctor">Select Doctor:</label>
        <select id="doctor" name="doctor_id">
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
            @endforeach
        </select>

        <label for="appointment_date">Select Date:</label>
        <input type="date" id="appointment_date" name="appointment_date">

        <button type="button" onclick="fetchSlots()">Find Slots</button>
    </form>

    <div id="slots"></div>

    <script>
        function fetchSlots() {
            const doctorId = document.getElementById('doctor').value;
            const date = document.getElementById('appointment_date').value;

            fetch(`/slots?doctor_id=${doctorId}&appointment_date=${date}`)
                .then(response => response.json())
                .then(data => {
                    let slotsHtml = '';
                    data.forEach(slot => {
                        slotsHtml += `<div>
                            <span>${slot.start_time} - ${slot.end_time}</span>
                            <button onclick="bookAppointment(${slot.id})" ${slot.is_booked ? 'disabled' : ''}>
                                ${slot.is_booked ? 'Booked' : 'Book Now'}
                            </button>
                        </div>`;
                    });
                    document.getElementById('slots').innerHTML = slotsHtml;
                });
        }

        function bookAppointment(slotId) {
            fetch('/book-appointment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ slot_id: slotId })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchSlots(); // Refresh slots
            });
        }
    </script>
</body>
</html>
