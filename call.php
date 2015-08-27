<?php
session_start(); 
if(!$_SESSION['logged']){ 
    header("Location: index.php?page=login.php"); 
    exit;
}
$year=date("Y");
$month=date("m");
$day=date("d");
$hour=date("h");
$minute=date("i");
$second=date("s");
$time='now';
$operator=$_SESSION['operator'];
$number=$_GET['number'];
?>
<div class="container">
        <div class="row">
            <div class="col-xs-6">
                <form id="call" role="form" method="POST">
                    <div class="row">
                        <div class="col-xs-6">
                            <input type="text" class="form-control" placeholder="Номер полиса клиента" autofocus name="number" id="number1" value="<?php echo $number; ?>">
                        </div>
                        <div class="col-xs-6">
                            <button form="call" type="submit" name="startcall" class="btn btn-primary"><span class="glyphicon glyphicon-earphone"></span>&nbsp;&nbsp;Звонок коиенту</button>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-xs-6">
                        <?php
                                $con=dbConnect();
                                $result = mysqli_query($con,"SELECT username FROM users"); 
                                if ($operator == 100){?>
                                <select name='extension' class="form-control" title="Номер агента">
                                    <?php
                                    while($row = mysqli_fetch_assoc($result)) {?>
                                    <option value="<?php echo $row['username'];?>"><?php echo $row['username'];?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                    <?php
                                } else{
                                    echo "<input type='text' class='form-control' placeholder='Номер агента' readonly name='extension' value='$operator'>";
                                }
                            ?>                            
                         </div>
                        <div class="col-xs-6">
                            <button form="call" type="submit"  name="send" class="btn btn-primary"><span class="glyphicon glyphicon-envelope"></span>&nbsp;&nbsp;Отправить СМС</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <textarea name="comment_text" class="form-control"></textarea>
                        </div>
                        <div class="col-xs-6">
                             <button form="call" type="submit" name="comment" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Добавить коментарий</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                        <div class="col-xs-6">        
                            <form id="search" role="form" method="GET">
                                <input type="hidden" class="form-control" name='page' value="<?php echo $_GET['page']; ?>">
                                <input type=text class="form-control" name='search' value="<?php echo $_GET['search']; ?>">
                            </form>
                         </div>   
                        <div class="col-xs-6"> 
                            <button form="search" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Поиск</button>
                        </div>
                </div>
            </div>
            <div class="col-xs-6 alert alert-success">

<?php
                                echo 'Здравствуйте, ваш внутрений номер '. $_SESSION['operator'];
                                echo '<br>почтовый адрес '. $_SESSION['email'];
        
                    if (isset($_POST['startcall']) && $_POST['number']>0){
                        $number = $_POST['number'];
                        if (!$operator == 100){
                            client::call($number);
                         }else{
                            $op=$_POST['extension'];
                            client::callop($number, $op);
                        }
                    }

                    if (isset($_POST['send']) && $_POST['number']>0){
                        $number = $_POST['number'];
                        client::send($number);
                    }

                    if (isset($_POST['comment']) && $_POST['number']>0){
                        $number = $_POST['number'];
                        $comment = $_POST['comment_text'];
                        client::comment($number, $comment);
                    }
          
                
     
                    list($list, $pagination, $rows) = client::find($_GET['search'], $operator);
                ?>
   
            </div>
        </div>  

        <div class="row">
            <div class="col-xs-12 ">
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
                            <th>Коментарий</th>
                            <?php if ($operator == 100){echo "<th>Агент</th>";}?>
                        </tr>
                    </thead>
        
 
                    <tbody>
                        <?php 
                        echo $list;
                        ?>
                    </tbody>
                </table>
            </div>            
            
        </div>
    <div class="row">
        <div class="col-xs-4">
            <ul class="pagination">
                <?php 
                    echo $pagination;
                ?>
            </ul>
        </div>
        <div class="col-xs-2">
            <div class="alert alert-success"><?php echo "Всего $rows";?></div>
        </div>
        <div class="col-xs-2">
            <form id='page' method='GET'>
                <input type="hidden" name='page' value="<?php echo $_GET['page']; ?>">
                <input type="hidden" name='search' value="<?php echo $_GET['search']; ?>">
                <input type=text placeholder="Номер страницы" name='pn' value="<?php echo $_GET['pn']; ?>">
            </form>
        </div>
        <div class="col-xs-2">
            <button form="page" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span>&nbsp;&nbsp;Страница</button>
        </div>
    </div>
</div>