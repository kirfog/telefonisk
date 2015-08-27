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
           
if (isset($_POST['del'])){
    client::cdr_delete($_POST['del']);
}

list($list, $pagination, $rows) = client::cdr($_GET['search'], $_GET['inbound']);
?>

<div class="container">
    <div class="row">
        <div class="col-xs-4">        
            <form id="search" role="form" method="GET">
                <div class="col-xs-6">
                <input type="hidden" class="form-control" name="page" value="<?php echo $_GET['page']; ?>">
                <input type="text" class="form-control" name="search" placeholder="Клиент" value="<?php echo $_GET['search']; ?>">
                </div>
                <div class="col-xs-6">
                <input type="text" class="form-control" name="inbound" placeholder="Агент" value="<?php echo $_GET['inbound']; ?>">
                </div>
            </form>
        </div>
        <div class="col-xs-2">
            <button form="search" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Поиск</button>
        </div>
        <div class="col-xs-4 alert alert-success">
            <form id="del" role="form" method="POST">
                <input type="hidden" class="form-control" name="page" value="<?php echo $_GET['page']; ?>">
                <input type="hidden" class="form-control" name="search" value="<?php echo $_GET['search']; ?>">
                <input type="hidden" class="form-control" name="inbound" value="<?php echo $_GET['inbound']; ?>">
                <input type="text" class="form-control" name="del" value="<?php echo $_GET['filetodel'];?>">
            </form>
        </div>
        <div class="col-xs-2">
            <button form="del" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Удалить запись</button>
        </div>
        
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-condensed table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Дата звонка</th>
                        <th>Время звонка</th>
                        <th>Откуда</th>
                        <th>Куда</th>
                        <th>Продолжительность</th>
                        <th>Статус</th>
                        <th>Запись</th>
                        <th>Файл</th>
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
                <input type="hidden" class="form-control" name="page" value="<?php echo $_GET['page']; ?>">
                <input type="hidden" class="form-control" name="search" value="<?php echo $_GET['search']; ?>">
                <input type="text" class="form-control" placeholder="Номер страницы" name="pn" value="<?php echo $_GET['pn']; ?>">
            </form>
        </div>
        <div class="col-xs-2">
            <button form="page" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span>&nbsp;&nbsp;Страница</button>
        </div>
    </div>
</div>
