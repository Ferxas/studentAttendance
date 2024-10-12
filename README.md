# Student Report Attendance

This project is a web-based application designed to manage student attendance records efficiently. It allows administrators to track attendance, generate reports, and manage student and class information.

## Features

- **User Authentication**: Secure login system to ensure that only authorized users can access the application.
- **Class Management**: Add, edit, and delete classes.
- **Student Management**: Register, update, and remove student records.
- **Attendance Tracking**: Record daily attendance for students.
- **Attendance Reports**: Generate reports to review attendance over specific periods.
- **Responsive Design**: User-friendly interface that works on various devices.

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/student-report-attendance.git
   ```

2. **Navigate to the project directory**:
   ```bash
   cd student-report-attendance
   ```

3. **Set up the database**:
   - Import the `dbasistencia.sql` file into your MySQL database to create the necessary tables.

4. **Configure the database connection**:
   - Update the `db-connect.php` file with your database credentials.

5. **Start the server**:
   - Use a local server environment like XAMPP or WAMP to run the application.

6. **Access the application**:
   - Open your web browser and go to `http://localhost/student-report-attendance`.

## Usage

- **Login**: Use your credentials to log in to the system.
- **Manage Classes**: Navigate to the "Courses" section to manage class information.
- **Manage Students**: Go to the "Students" section to handle student records.
- **Record Attendance**: Use the "Attendance" page to mark student attendance.
- **View Reports**: Access the "Report" section to generate and view attendance reports.

## TODO

- [x] Login authentication
- [ ] Implement user roles
- [ ] Add a dark mode toggle
- [ ] Generate reports considering Monday-to-Friday