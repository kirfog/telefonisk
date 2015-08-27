<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Telefonisk login</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="container text-center">
            <div class="row space">
            </div>
            <div class="row">
                <div class="col-xs-4"></div>
                <div class="col-xs-4">
                    <h3><span class="glyphicon glyphicon-asterisk">TELEFONISK</span></h3>
                    <form id="login" method="post">
                        <input type="text" class="form-control" placeholder="Номер агента" name="operator"><br><br>
                        <input type="password" class="form-control" placeholder="Пароль" name="password"><br><br>
                    </form>    
                    <button form="login" name="submit" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;Вход</button>
                </div>
                <div class="col-xs-4"></div>
            </div>
            <?php
            if(isset($_POST['submit'])){
                include('config.php');
                $con=dbconnect();
                $operator  = mysqli_real_escape_string($con, $_POST['operator']);
                $password = hash('sha256', mysqli_real_escape_string($con, $_POST['password']));
                $sql = "SELECT * FROM users WHERE username='$operator' AND password='$password' LIMIT 1";
                if (!mysqli_query($con,$sql)) {
                        die('Error: ' . mysqli_error($con));
                }
                $result=mysqli_query($con,$sql);
                if(mysqli_num_rows($result) == 1){ 
                    $row = mysqli_fetch_assoc($result);
                    session_start();
                    $_SESSION['operator'] = $row['username']; 
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['logged'] = TRUE; 
                    header("Location: index.php?page=call");
                    mysqli_close($con);
                    exit;
                }
                else{
                    echo "<div class='alert alert-warning'>Попробуйте ещё раз</div>";
                    mysqli_close($con);
                exit; 
                }
            }
            ?>
        </div>
    </body>
</html>

