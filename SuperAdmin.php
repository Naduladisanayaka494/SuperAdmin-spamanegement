<!DOCTYPE html>
<html>
<head>
    <title>Super Admin</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Include custom CSS for styling -->
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .buttons {
            margin-top: 10px;
        }

        .table-wrapper {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php
    // Database connection settings
    $host = "localhost";
    $dbname = "expense_budget_db";
    $username = "root";
    $password = "";

    // Create a PDO instance
    $dsn = "mysql:host=$host;dbname=$dbname";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if (isset($_POST['save'])) {
        // Retrieve form data
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $avatar = $_POST['avatar'];
        $type = $_POST['type'];
        $date_added = date('Y-m-d H:i:s');
        $date_updated = date('Y-m-d H:i:s');

        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, password, avatar, last_login, type, date_added, date_updated) 
                                VALUES (?, ?, ?, ?, ?, NULL, ?, ?, ?)");
        $stmt->execute([$firstname, $lastname, $username, $password, $avatar, $type, $date_added, $date_updated]);

        // Redirect to the Super Admin page to display the updated table
        header("Location: superadmin.php");
        exit;
    }

    // Check if the remove button is clicked
    if (isset($_POST['remove'])) {
        $adminId = $_POST['adminId'];

        // Prepare and execute the SQL statement to remove the admin row
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$adminId]);

        // Redirect to the Super Admin page to display the updated table
        header("Location: superadmin.php");
        exit;
    }

    // Check if the update button is clicked
    if (isset($_POST['update'])) {
        $adminId = $_POST['adminId'];
        $updatePassword = password_hash($_POST['updatePassword'], PASSWORD_DEFAULT);
        $updateDateUpdated = date('Y-m-d H:i:s');

        // Prepare and execute the SQL statement to update the admin row
        $stmt = $conn->prepare("UPDATE users SET password = ?, date_updated = ? WHERE id = ?");
        $stmt->execute([$updatePassword, $updateDateUpdated, $adminId]);

        // Redirect to the Super Admin page to display the updated table
        header("Location: superadmin.php");
        exit;
    }

    // Retrieve the list of admins from the database
    $stmt = $conn->query("SELECT * FROM users");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

<div class="card" style="width: 80rem;">
        <div class="header">
            <h1>Super Admin</h1>
            <p>Create and manage admins</p>
        </div>

        <div class="row">
            <div class="col-md-12 offset-md-112">
                <div class="buttons">
                    <!-- Button to trigger the Create Admin modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAdminModal">
                        Create Admin
                    </button>
                </div>
            </div>
        </div>

        <br><br>

        <div class="table-wrapper">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Avatar</th>
                        <th>Type</th>
                        <th>Date Added</th>
                        <th>Date Updated</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($admins as $admin) { ?>
                        <tr>
                            <td><?= $admin['firstname'] ?></td>
                            <td><?= $admin['lastname'] ?></td>
                            <td><?= $admin['username'] ?></td>
                            <td><?= $admin['avatar'] ?></td>
                            <td><?= $admin['type'] ?></td>
                            <td><?= $admin['date_added'] ?></td>
                            <td><?= $admin['date_updated'] ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="adminId" value="<?= $admin['id'] ?>">
                                    <button type="button" class="btn btn-danger btn-remove" data-admin-id="<?= $admin['id'] ?>">Remove</button>
                                    <button type="button" class="btn btn-success btn-update" data-toggle="modal" data-target="#updateAdminModal" data-admin-id="<?= $admin['id'] ?>">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Admin Modal -->
    <div class="modal fade" id="createAdminModal" tabindex="-1" role="dialog" aria-labelledby="createAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAdminModalLabel">Create Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Admin creation form -->
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <input type="text" class="form-control" id="avatar" name="avatar">
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <input type="text" class="form-control" id="type" name="type">
                        </div>
                        <button type="submit" name="save" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript code to handle remove button
        function removeRow(adminId) {
            if (confirm("Are you sure you want to remove this admin?")) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '';

                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'adminId';
                input.value = adminId;

                var button = document.createElement('button');
                button.type = 'submit';
                button.name = 'remove';
                button.style.display = 'none';

                form.appendChild(input);
                form.appendChild(button);

                document.body.appendChild(form);
                button.click();

                document.body.removeChild(form);
            }
        }

        // Attach event listeners to the remove buttons
        var removeButtons = document.getElementsByClassName('btn-remove');
        for (var i = 0; i < removeButtons.length; i++) {
            removeButtons[i].addEventListener('click', function (event) {
                event.preventDefault();
                removeRow(this.dataset.adminId);
            });
        }
    </script>

    <!-- Update Admin Modal -->
    <div class="modal fade" id="updateAdminModal" tabindex="-1" role="dialog" aria-labelledby="updateAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateAdminModalLabel">Update Admin Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Admin update form -->
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="updatePassword">Password</label>
                        <input type="password" class="form-control" id="updatePassword" name="updatePassword" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript code to handle update button
    function updateRow(adminId) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '';

        var inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'adminId';
        inputId.value = adminId;

        var inputPassword = document.createElement('input');
        inputPassword.type = 'hidden';
        inputPassword.name = 'updatePassword';
        inputPassword.value = document.getElementById('updatePassword').value;

        var button = document.createElement('button');
        button.type = 'submit';
        button.name = 'update';
        button.style.display = 'none';

        form.appendChild(inputId);
        form.appendChild(inputPassword);
        form.appendChild(button);

        document.body.appendChild(form);
        button.click();

        document.body.removeChild(form);
    }

    // Attach event listeners to the update buttons
    var updateButtons = document.getElementsByClassName('btn-update');
    for (var i = 0; i < updateButtons.length; i++) {
        updateButtons[i].addEventListener('click', function () {
            var adminId = this.dataset.adminId;
            var updateFirstname = document.getElementById('updateFirstname');
            var updateLastname = document.getElementById('updateLastname');

            updateFirstname.value = document.getElementById('firstname-' + adminId).textContent;
            updateLastname.value = document.getElementById('lastname-' + adminId).textContent;

            document.getElementById('updatePassword').value = '';
        });
    }
</script>

</body>
</html>
