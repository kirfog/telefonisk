<?php
session_start(); 
if(!$_SESSION['logged']){ 
    header("Location: login.php"); 
    exit;
}
if(($_SESSION['operator'])!="100"){ 
    header("Location: index.php?page=rights"); 
    exit;
} 
?>
<div class="container">
    <div class="row">
        <form id="adduser" method="post">      
            <div class="col-xs-2">
                <input type="text" class="form-control" placeholder="Телефон оператора" autofocus name="operator">
            </div>
            <div class="col-xs-2">
                <input type="text" class="form-control" placeholder="Почта" name="email">
             </div>   
            <div class="col-xs-2">
                <input type="password" class="form-control" placeholder="Пароль" name="password">    
            </div>
        </form>
        <div class="col-xs-2">
            <button form="adduser" type="submit" name="add" class="btn btn-primary"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;Добавить</button>
        </div>
        <div class="col-xs-4">
            <?php
                if (isset($_POST['add'])){
                $con=dbconnect();
                $operator = mysqli_real_escape_string($con, $_POST['operator']);
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $password = hash('sha256', mysqli_real_escape_string($con, $_POST['password']));
                $sql="INSERT INTO users (username, password, email) VALUES ('$operator', '$password', '$email')";
                if (!mysqli_query($con,$sql)) {
                    die('Error: ' . mysqli_error($con));
                }
                mysqli_close($con);
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2">
            <form id="deluser" method="post">
                <?php $number=$_GET['number'];?>
                <input type="text" class="form-control" placeholder="Телефон оператора" name="operator" value="<?php echo $number;?>">
            </form>
        </div>
        <div class="col-xs-2">
            <button form="deluser" type="submit" name="del" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Удалить</button>
        </div>
        <div class="col-xs-8">
            <?php
            if (isset($_POST['del'])){
                    $con=dbconnect();
                    $operator = mysqli_real_escape_string($con, $_POST['operator']);
                    $sql= "DELETE FROM users WHERE username = '$operator' LIMIT 1";
                    if (!mysqli_query($con,$sql)) {
                            die('Error: ' . mysqli_error($con));
                    }
                    mysqli_close($con);
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
        <table class="table table-condensed table-bordered table-hover table-striped">
                <thead>
                        <tr>
                                <!--<th>Номер агента</th>-->
                                <th>Телефон агента</th>
                                <th>Почта агента</th>
                                <th>Пароль агента</th>
                        </tr>
                </thead>
                <tbody>
                <?php
                $con=dbconnect();
                $result = mysqli_query($con,"SELECT * FROM users ORDER BY user_id DESC");
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    //echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "</tr>";
                }
                mysqli_close($con);
                ?>
        </tbody>
    </table>
        </div>
    </div>    
</div>