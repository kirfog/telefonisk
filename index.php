<!DOCTYPE html>
<?php
session_start(); 
if(!$_SESSION['logged']){ 
    header("Location: login.php");
    exit;
}
include ('config.php');
include ('client.php');
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Telefonisk</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="row space">
            
        </div>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-asterisk"></span></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                    <li 
                        <?php
                            $page=$_GET['page'];
                            if ($page == 'call'){
                                echo "class='active'";
                            }
                         ?>
                        ><a href="?page=call">Звонок клиенту</a>
                    </li>
                    <li
                        <?php
                            $page=$_GET['page'];
                            if ($page == 'base'){
                                echo "class='active'";
                            }
                         ?>
                        ><a href="?page=base">Клиенты</a></li>
                    <li
                        <?php
                            $page=$_GET['page'];
                            if ($page == 'users'){
                                echo "class='active'";
                            }
                         ?>
                        ><a href="?page=users">Агенты</a></li>
                    <li
                        <?php
                            $page=$_GET['page'];
                            if ($page == 'recordings'){
                                echo "class='active'";
                            }
                         ?>
                        ><a href="?page=recordings">Записи</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li><a href="?page=exit">Выход</a></li>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>
        <main>

            <?php
                    if (isset($_GET['page'])){
                            if (file_exists($_GET['page'] . '.php')){
                                    include ($_GET['page'] . '.php');
                            }
                            else{
                                    include 'call.php';
                            }
                    }
                    else{
                            include 'call.php';
                    }
            ?>

        </main>
        <footer>
            <div class="row navbar-fixed-bottom">
                <div class="col-xs-12">
                    <a href="#"><span class="glyphicon glyphicon-asterisk">TELEFONISK 0.924</span></a>
                </div>
            </div>
        </footer>
        <script src="jquery.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
            $("tr.click").click(function(){
                //$(this).closest('tr').find('td:eq(0)').css("background-color","yellow");
                $(this).closest('tr').find('td').css("background-color","#DFF0D8");
                var num = $(this).closest('tr').find('td:eq(0)').html();
                var url = $(location).attr('href');
                window.location = url+"&number="+num;
            });
            $("td.file").click(function(){
                //$(this).closest('tr').find('td:eq(0)').css("background-color","yellow");
                $(this).closest('tr').find('td').css("background-color","#DFF0D8");
                var num = $(this).html();
                var url = $(location).attr('href');
                window.location = url+"&filetodel="+num;
            });
            });
            
        </script>
    </body>
</html>