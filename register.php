<?php
    include("database.php");

    $global = "";
    $error = false;

    if(isset($_REQUEST['register'])){

        $firstname = $_REQUEST['firstname'];
        $surname = $_REQUEST['surname'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $confirm_password = $_REQUEST['confirm_password'];
        $staff = $_REQUEST['staff'];

        //do strip_tags
        $firstname = strip_tags($firstname);
        $surname = strip_tags($surname);
        $email = strip_tags($email);
        $password = strip_tags($password);
        $confirm_password = strip_tags($confirm_password);

        //do msqli_real_escape_string
        $firstname = mysqli_real_escape_string($connection, $firstname);
        $surname = mysqli_real_escape_string($connection, $surname);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);
        $confirm_password = mysqli_real_escape_string($connection, $confirm_password);

        //filter validate email

        if(!filter_var($password, FILTER_VALIDATE_EMAIL)){
            $global = "Invalid email.";
            $error = true;
        }            

        //if all fields are filled
        if($firstname != "" && $surname != "" && $email != "" && $password != "" && $confirm_password != "" && $staff != ""){

            //if password and confirm password are the same
            if($password == $confirm_password){

                //check if email is already registered
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = $connection -> query($sql);

                if($result -> num_rows > 0){
                    $global = "Email already registered.";
                    $error = true;
                }else{
                    //insert user into database
                    $sql = "INSERT INTO users (Firstname, Surname, Email, Password, Staff) VALUES ('$firstname', '$surname', '$email', '$password', '$staff')";
                    
                    if($connection->query($sql) === TRUE){
                        $global = "User registered successfully.";
                        $error = false;
                    }else{
                        $global = "Error: " . $sql . "<br>" . $connection->error;
                        $error = true;
                    }

                }
            }else{
                $global = "Passwords do not match.";
                $error = true;
            }
        }else{
            $global = "Please fill all fields.";
        }
    }

?>

<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Northwind shop.</title>
    </head>

    <body>
        <nav class="d-flex w-100 m-0">
            <div class="p-4 d-flex justify-content-center align-items-center bg-primary w-100 h-25">
                <h1 class="fs-3 text-white">
                    Northwind shop.
                </h1>
            </div>            
        </nav>  



        <div class="my-5 d-flex align-items-center justify-content-center">
            
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-9">
                    <div class="card m-auto p-3">
                    


                    <form  method="POST">
                        
                        <div>
                            <h5>
                            Register
                            </h5>
                        </div>

                        <div class="form-group my-4">

                            <label class="text-secondary font-weight-bold" for="firstname">Name</label>
                            <input type="text" class="form-control" id="name" name="firstname">
                            
                            <label class="text-secondary font-weight-bold" for="surname">Surname</label>
                            <input type="text" class="form-control" id="surname" name="surname">
                            
                            <label class="text-secondary font-weight-bold" for="Email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email">
                            
                            <label class="text-secondary font-weight-bold" for="password">Password</label>
                            <input type="text" class="form-control" id="password" name="password">
                            
                            <label class="text-secondary font-weight-bold" for="confirm_password">Confirm password</label>
                            <input type="text" class="form-control" id="confirm" name="confirm_password">
                            
                            <label class="text-secondary font-weight-bold" for="staff">Account type</label>
                            
                            <select class="form-control" id="staff" name="staff">
                                <option value="0">Student</option>
                                <option value="1">Staff</option>
                            </select>

                        </div>

                        <div class="w-100 d-flex justify-content-end">
                            <input type="submit" name="register"  class="btn btn-primary">
                        </div>

                    </form>



                </div>
                </div>

            </div>
                
            </div>

        </div>

        

        <div class=" w-100 d-flex justify-content-center align-items-center my-4">
            
            <?php if($error):?>

                <div class="alert alert-danger" role="alert">
                    <?php echo $global; ?>
                </div>

            <?php else:?>
                
                <div class="rounded bg-success text-white fw-bold p-4">
                    <?php echo $global; ?>
                </div>
            
            <?php endif?>

        </div>


    </body>

</html>