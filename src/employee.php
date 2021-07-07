<!-- TODO Employee view -->

<?php
require_once('library/loginManager.php');
require_once('library/employeeManager.php');

session_start();

$userId = $_SESSION['authUserId'];
$authUser = getUserById($userId);

$id = $_GET['id'];
$employee = getEmployeeById($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <title>Employee</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5 px-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Employee Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link " href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="employee.php">Employees</a>
                    </li>
                </ul>
            </div>
            <li class="nav-item d-flex dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $authUser['name'] ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#">
                            <i class="bi bi-person me-2"></i>
                            Profile
                        </a>
                    </li>
                    <li><a class="dropdown-item" href="#">
                            <i class="bi bi-box-arrow-left me-2"></i>
                            logout
                        </a>
                    </li>
                </ul>
            </li>
        </div>
    </nav>

    <section class="form-section">
        <h2>User Detail</h2>
        <form class="row g-3" id="updateForm">
            <input type="hidden" class="form-control" id="employeeId" value="<?php echo $employee['id'] ?>">
            <div class="col-md-6">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control" id="inputName" value="<?php echo $employee['name'] ?>">
            </div>
            <div class="col-md-6">
                <label for="inputLastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="inputLastName" value="<?php echo $employee['lastName'] ?>">
            </div>
            <div class="col-6">
                <label for="inputEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="inputEmail" placeholder="user@mail.com" value="<?php echo $employee['email'] ?>">
            </div>
            <div class="col-6">
                <label for="selectGender" class="form-label">Gender</label>
                <select class="form-control" id="SelectGender">
                    <option value="man">Man</option>
                    <option value="woman">Woman</option>
                    <option Value="other">Other</option>
                </select>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <label for="inputAge" class="form-label">Age</label>
                    <input type="text" class="form-control" id="inputAge" value="<?php echo $employee['age'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="inputCity" value="<?php echo $employee['city'] ?>">
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" class="form-select" value="<?php echo $employee['state'] ?>">
                    <option selected>CA</option>
                    <option>TX</option>
                    <option>LU</option>

                </select>
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">Zip</label>
                <input type="text" class="form-control" id="inputZip" value="<?php echo $employee['postalCode'] ?>">
            </div>
            <div class="col-md-6">
                <label for="inputAddress" class="form-label">Street Address</label>
                <input type="text" class="form-control" id="inputAddress" value="<?php echo $employee['streetAddress'] ?>">
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">Phone number</label>
                <input type="text" class="form-control" id="inputPhone" value="<?php echo $employee['phoneNumber'] ?>">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary" name="updateSubmit">Update</button>
            </div>
        </form>
        <div class="alert-wrapper">
        </div>
    </section>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $("#updateForm").on('submit', function(e) {
            e.preventDefault();

            const id = $(this).find('#employeeId').val(),
                name = $(this).find('#inputName').val(),
                lastName = $(this).find('#inputLastName').val(),
                email = $(this).find('#inputEmail').val(),
                gender = $(this).find('#SelectGender').val(),
                age = $(this).find('#inputAge').val(),
                city = $(this).find('#inputCity').val(),
                state = $(this).find('#inputState').val(),
                postalCode = $(this).find('#inputZip').val(),
                streetAddress = $(this).find('#inputAddress').val(),
                phoneNumber = $(this).find('#inputPhone').val();

            $.ajax({
                type: "PUT",
                url: "./library/employeeController.php",
                data: {
                    id,
                    name,
                    lastName,
                    email,
                    gender,
                    age,
                    city,
                    state,
                    postalCode,
                    streetAddress,
                    phoneNumber,

                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data.Status) {
                        $(".alert-wrapper").append('<div class="alert alert-success" role="alert ">Employee updated!</div>');
                    } else {
                        $(".alert-wrapper").append('<div class="alert alert-danger" role="alert ">Error updating employee</div>');
                    }
                }
            });
        });

        let gender = "<?php echo $employee['gender'] ?>";
        $("#SelectGender").val(gender);
    </script>
</body>

</html>