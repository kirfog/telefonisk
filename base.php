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
    <form id="addclient" method="post">
        <div class="row">
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Номер полиса" autofocus name="number">
            </div>
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Дата окончания" name="end">
            </div>    
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Компенсация" name="comp">
            </div>
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="CK" name="sk">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Имя" name="firstname">
            </div>
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Фамилия" name="lastname">    
            </div>
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Возраст" name="age">
            </div>
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Стаж"  name="exp">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Марка" name="model">
            </div>
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Год" name="year">
            </div>
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Объём" name="cc">
            </div>
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Стоимость" name="cost">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <input type="text" class="form-control" placeholder="Телефон" name="phonenumber">
            </div>
            <div class="col-xs-3">
                <?php
                    $con=dbConnect();
                    $result = mysqli_query($con,"SELECT username FROM users"); 
                    ?>
                    <select name='op' class="form-control">
                        <?php
                        while($row = mysqli_fetch_assoc($result)) {?>
                        <option value="<?php echo $row['username'];?>"><?php echo $row['username'];?></option>
                        <?php
                        }
                ?>
                    </select>
            </div>
            <div class="col-xs-3"> 
                <button form="addclient" name="addclient" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;Добавить клиента</button>
            </div>
            <div class="col-xs-3">
                
            </div>  
        </div>
    </form>

            <!--<div class="col-xs-6">        
                <form id="start" method="post">
                       <input type="text" placeholder=" Начальный индекс" name="start">
                </form>
                <button form="start" type="submit" name="index" class="btn btn-primary"><span class="glyphicon glyphicon-sorts"></span>Изменить индекс</button>
            </div>-->   
        <div class="row">
            <div class="col-xs-3">
                <form id="del" method="post" role="form">
                    <?php $number=$_GET['number'];?>
                    <input type="text" class="form-control"  placeholder="Номер полиса" name="number" value="<?php echo $number;?>">
                </form>
            </div>    
            <div class="col-xs-3">
                <button form="del" type="submit" name="deleteclient" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Удалить клиента</button>
            </div>
            <div class="col-xs-3">
                
            </div>
            <div class="col-xs-3">
                
            </div>
        </div>
    
            
    <div class="row">
        <div class="col-xs-3"> 
            <form id="search" role="form" method="GET">
                <input type="hidden" class="form-control" name='page' value="<?php echo $_GET['page']; ?>">
                <input type=text class="form-control" name='search' value="<?php echo $_GET['search']; ?>">
            </form>
        </div>   
        <div class="col-xs-3">
            <button form="search" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Поиск</button>
        </div>
        

        <div class="col-xs-4">
            <?php
                if (isset($_POST['addclient'])){
                    $number = mysqli_real_escape_string($con, $_POST['number']);
                    $end = mysqli_real_escape_string($con, $_POST['end']);
                    $comp = mysqli_real_escape_string($con, $_POST['comp']);
                    $sk = mysqli_real_escape_string($con, $_POST['sk']);
                    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
                    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
                    $age = mysqli_real_escape_string($con, $_POST['age']);
                    $exp = mysqli_real_escape_string($con, $_POST['exp']);
                    $model = mysqli_real_escape_string($con, $_POST['model']);
                    $year = mysqli_real_escape_string($con, $_POST['year']);
                    $cc = mysqli_real_escape_string($con, $_POST['cc']);
                    $cost = mysqli_real_escape_string($con, $_POST['cost']);
                    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
                    $op = mysqli_real_escape_string($con, $_POST['op']);

                    $client = new client($number, $end, $comp, $sk, $firstname, $lastname, $age, $exp, $model, $year, $cc, $cost, $phonenumber, $op);
                    $client->add();
                }

                if (isset($_POST['deleteclient'])){
                    $number = mysqli_real_escape_string($con, $_POST['number']);
                    client::del($number);
                }

               /*
                if (isset($_POST['index'])){
                    if (isset($_POST['start']) && ($_POST['start']>0)){
                        $con=dbconnect();
                        $start = mysqli_real_escape_string($con, $_POST['start']);
                        $sql= " ALTER TABLE clients AUTO_INCREMENT = $start;";
                        if (!mysqli_query($con,$sql)) {
                            die('Error: ' . mysqli_error($con));
                        }
                        mysqli_close($con);
                    }
                }
                */

                list($list, $pagination, $rows) = client::findAll($_GET['search']);
            ?>
        </div>    
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-hover table-condensed table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Номер полиса</th>
                        <th>Дата окончания</th>
                        <th>Компенсация</th>
                        <th>СК</th>

                        <th>Имя клиента</th>
                        <th>Фамилия клиента</th>
                        <th>Возраст</th>
                        <th>Стаж</th>

                        <th>Марка</th>
                        <th>Год</th>
                        <th>Объём</th>
                        <th>Стоимость</th>

                        <th>Коментарий/th>

                        <th>Номер агента</th>
                        <th>Телефон</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $list; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="pagination">
                <?php echo $pagination; ?>
            </div>
        </div>
        <div class="col-xs-2">
                <div class="alert alert-success"><?php echo "Всего $rows";?></div>
        </div>
        <div class="col-xs-2">
            <form id='page' method='GET'>
                <input type="hidden" name='page' value="<?php echo $_GET['page']; ?>">
                <input type="hidden" name='search' value="<?php echo $_GET['search']; ?>">
                <input type=text class="form-control" placeholder="Номер страницы" name='pn' value="<?php echo $_GET['pn']; ?>">
            </form>
        </div>
        <div class="col-xs-2">
            <button form="page" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span>&nbsp;&nbsp;Страница</button>
        </div>    
    </div>
</div>