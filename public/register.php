<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="../src/controllers/PilgrimController.php" method="POST">
        <label for="pil_name">Name:</label>
        <input type="text" id="pil_name" name="pil_name" required><br><br>
        <label for="pil_lga">LGA:</label>
        <input type="text" id="pil_lga" name="pil_lga" required><br><br>
        <label for="pil_nin">NIN:</label>
        <input type="text" id="pil_nin" name="pil_nin" required><br><br>
        <label for="pil_bvn">BVN:</label>
        <input type="text" id="pil_bvn" name="pil_bvn" required><br><br>
        <label for="passport_no">Passport No:</label>
        <input type="text" id="passport_no" name="passport_no" required><br><br>
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>
