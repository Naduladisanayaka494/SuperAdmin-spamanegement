<!DOCTYPE html>
<html>

<head>
    <title>Spa Lanka - Palagathure</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            margin-right: 10px;
        }

        .form-group input[type="text"],
        .form-group select {
            padding: 10px;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin-top: 20px;
        }

        /* Media query for small screens */
        @media screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
            }

            .form-group input[type="text"],
            .form-group select {
                width: 100%;
            }

            .form-group input[type="submit"] {
                margin-top: 10px;
            }
        }
    </style>
    <script>
        function updateOutTime() {
            var inTime = document.getElementById("in-time").value;
            var date = new Date();
            var year = date.getFullYear();
            var month = ("0" + (date.getMonth() + 1)).slice(-2);
            var day = ("0" + date.getDate()).slice(-2);
            var currentDate = year + "-" + month + "-" + day;
            document.getElementById("out-time").value = currentDate + " " + inTime;
        }

        function toggleDropdown() {
            document.getElementById("dropdown").style.display = "block";
            document.getElementById("text-field").style.display = "none";
            document.getElementById("text-value").value = "";
        }

        function toggleTextField() {
            document.getElementById("dropdown").style.display = "none";
            document.getElementById("text-field").style.display = "block";

            var serviceType = document.querySelector('input[name="service-type"]:checked').value;
            var textValue = "";

            if (serviceType === "Normal") {
                textValue = "1500.00";
            } else if (serviceType === "Oil") {
                textValue = "2000.00";
            }

            document.getElementById("text-value").value = textValue;
        }
    </script>
</head>

<body>
    <div class="container">
        <?php date_default_timezone_set('Asia/Colombo'); ?>
        <form action="palagathure_save.php" method="post">
            <div class="form-group">
                <label for="branch">Branch:</label>
                <input type="text" id="branch" name="branch" value="Palagathure" class="form-control" disabled>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required class="form-control">
            </div>
            <div class="form-group">
                <label for="in-date">In Date:</label>
                <input type="text" id="in-date" name="in-date" value="<?php echo date('Y-m-d'); ?>" readonly class="form-control">
            </div>
            <div class="form-group">
                <label for="in-time">In Time:</label>
                <input type="text" id="in-time" name="in-time" value="<?php echo date('H:i:s'); ?>" readonly class="form-control">
            </div>
            <div class="form-group">
                <label for="out-time">Out Time:</label>
                <input type="text" id="out-time" name="out-time" value="<?php echo date('H:i:s', strtotime('+1 hour')); ?>" readonly class="form-control">
            </div>
            <div class="form-group">
                <label>Service Type:</label>
                <div class="form-check">
                    <input type="radio" id="full" name="service-type" value="Full" onclick="toggleDropdown()" required class="form-check-input">
                    <label for="full" class="form-check-label">Full</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="normal" name="service-type" value="Normal" onclick="toggleTextField()" required class="form-check-input">
                    <label for="normal" class="form-check-label">Normal</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="oil" name="service-type" value="Oil" onclick="toggleTextField()" required class="form-check-input">
                    <label for="oil" class="form-check-label">Oil</label>
                </div>
            </div>
            <div class="form-group">
                <div id="dropdown" style="display: none;">
                    <label for="dropdown-value">Amount:</label>
                    <select id="dropdown-value" name="dropdown-value" class="form-control">
                        <option value="3500">3500.00</option>
                        <option value="4000">4000.00</option>
                        <option value="4500">4500.00</option>
                        <option value="5000">5000.00</option>
                        <option value="6000">6000.00</option>
                    </select>
                </div>
                <div id="text-field" style="display: none;">
                    <label for="text-value">Amount:</label>
                    <input type="text" id="text-value" name="text-value" readonly class="form-control">
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Save" class="btn btn-primary">
            </div>
            <label>© 2023 Spa Lanka. All Rights Reserved.</label>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>