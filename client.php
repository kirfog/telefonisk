<?php
class client {
    
    public function __construct($number, $end, $comp, $sk, $firstname, $lastname, $age, $exp, $model, $year, $cc, $cost, $phonenumber, $op){
        $this->number = $number;
        $this->end = $end;
        $this->comp = $comp;
        $this->sk = $sk;
        
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->age = $age;
        $this->exp = $exp;
        
        $this->model = $model;
        $this->year = $year;
        $this->cc = $cc;
        $this->cost = $cost;
        
        $this->phonenumber = $phonenumber;
        $this->op = $op;
    }
        
    function add(){
        if (preg_match("/7\d{10,10}$/", $this->phonenumber)){
            $con=dbconnect();
            $sql="INSERT INTO clients (number, end, comp, sk, firstname, lastname, age, exp, model, year, cc, cost, phonenumber, op) VALUES ('$this->number', '$this->end', '$this->comp', '$this->sk', '$this->firstname', '$this->lastname', '$this->age', '$this->exp', '$this->model', '$this->year', '$this->cc', '$this->cost', '$this->phonenumber', '$this->op')";
            if (!mysqli_query($con,$sql)) {
                die('Error: ' . mysqli_error($con));
            }
            echo '<div class="alert alert-success">Клиент добвлен</div>';
        }else{
            echo '<div class="alert alert-danger">Не верный формат номера телефона</div>';
        }
        mysqli_close($con);
    }

    function call($number){
        $con=dbconnect();
        $result = mysqli_query($con,"SELECT * FROM clients WHERE number = '$number'");
        while($row = mysqli_fetch_assoc($result)){
            $end = $row['end'];
            $comp = $row['comp'];
            $sk = $row['sk'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $age = $row['age'];
            $exp = $row['exp'];
            $model = $row['model'];
            $year = $row['year'];
            $cc = $row['cc'];
            $cost= $row['cost'];
            $phonenumber = $row['phonenumber'];
            $op = $row['op'];
        }
        $errno="";
        $errstr="";
        $asterisk_ip=settings::asterisk_ip;
        $asterisk_port=settings::asterisk_port;
        $asterisk_trunk=settings::asterisk_trunk;
        $asterisk_user=settings::asterisk_user;
        $asterisk_pass=settings::asterisk_pass;
        $socket = fsockopen($asterisk_ip, $asterisk_port, $errno, $errstr, 20);
        fputs($socket,"Action: Login\r\n");
        fputs($socket,"UserName: $asterisk_user\r\n");
        fputs($socket,"Secret: $asterisk_pass\r\n\r\n");
        fputs($socket, "Action: Originate\r\n" );
        fputs($socket, "Channel: SIP/$asterisk_trunk/$phonenumber\r\n" );
        fputs($socket, "Exten: $op\r\n" );
        fputs($socket, "Context: default\r\n" );
        fputs($socket, "Priority: 1\r\n" );
        fputs($socket, "Timeout: 20000\r\n" );
        fputs($socket, "CallerID: $number\r\n");
        fputs($socket, "Async: yes\r\n\r\n" );
        fputs($socket,"Action: Logoff\r\n\r\n");
        sleep(2);
        fclose($socket);
        
    echo "<div class='alert'>";
    echo "Звоню клиенту: $firstname $lastname Возраст: $age Стаж: $exp Марка: $model Год: $year Объём: $cc Стоимость: $cost Страховая компания: $sk<br>";
    echo "</div>";
    }
    
        function callop($number, $op){
        $con=dbconnect();
        $result = mysqli_query($con,"SELECT * FROM clients WHERE number = '$number'");
        while($row = mysqli_fetch_assoc($result)){
            $end = $row['end'];
            $comp = $row['comp'];
            $sk = $row['sk'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $age = $row['age'];
            $exp = $row['exp'];
            $model = $row['model'];
            $year = $row['year'];
            $cc = $row['cc'];
            $cost= $row['cost'];
            $phonenumber = $row['phonenumber'];

        }
        $errno="";
        $errstr="";
        $asterisk_ip=settings::asterisk_ip;
        $asterisk_port=settings::asterisk_port;
        $asterisk_trunk=settings::asterisk_trunk;
        $asterisk_user=settings::asterisk_user;
        $asterisk_pass=settings::asterisk_pass;
        $socket = fsockopen($asterisk_ip, $asterisk_port, $errno, $errstr, 20);
        fputs($socket,"Action: Login\r\n");
        fputs($socket,"UserName: $asterisk_user\r\n");
        fputs($socket,"Secret: $asterisk_pass\r\n\r\n");
        fputs($socket, "Action: Originate\r\n" );
        fputs($socket, "Channel: SIP/$asterisk_trunk/$phonenumber\r\n" );
        fputs($socket, "Exten: $op\r\n" );
        fputs($socket, "Context: default\r\n" );
        fputs($socket, "Priority: 1\r\n" );
        fputs($socket, "Timeout: 20000\r\n" );
        fputs($socket, "CallerID: $number\r\n");
        fputs($socket, "Async: yes\r\n\r\n" );
        fputs($socket,"Action: Logoff\r\n\r\n");
        sleep(2);
        fclose($socket);
        
    echo "<div class='alert'>";
    echo "Звоню клиенту: $firstname $lastname Возраст: $age Стаж: $exp Марка: $model Год: $year Объём: $cc Стоимость: $cost Страховая компания: $sk<br>";
    echo "</div>";
    }
    
    

    function send($number){
        $con=dbconnect();
        $result = mysqli_query($con,"SELECT * FROM clients WHERE number = '$number'");
        while($row = mysqli_fetch_assoc($result)){
            $end = $row['end'];
            $comp = $row['comp'];
            $sk = $row['sk'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $age = $row['age'];
            $exp = $row['exp'];
            $model = $row['model'];
            $year = $row['year'];
            $cc = $row['cc'];
            $cost= $row['cost'];
            $phonenumber = $row['phonenumber'];
            $op = $row['op'];
        }
        
        $result = mysqli_query($con,"SELECT * FROM users WHERE username = '$op'");
        while($row = mysqli_fetch_assoc($result)){
            $email = $row['email'];
        }
        
        $sms_login = settings::sms_login;
        $sms_pass = settings::sms_pass;
        $src = "<?xml version='1.0' encoding='UTF-8'?>    
        <SMS> 
            <operations>  
                <operation>SEND</operation> 
            </operations> 
            <authentification>    
                <username>$sms_login</username>   
                <password>$sms_pass</password>
            </authentification>
            <message> 
                <sender>Avalon</sender>    
                <text>Здравствуйте $firstname $lastname\nПаспорт c пропиской, ПТС с 2-х сторон, СТС с 2-х сторон, права с 2-хсторон, права лиц допущенных к управлению\n$email</text>Ы
            </message>
            <numbers>
                <number messageID='msg11'>$phonenumber</number>
            </numbers>    
        </SMS>";  
        $Curl = curl_init();
        $CurlOptions = array(   
        CURLOPT_URL=>'http://atompark.com/members/sms/xml.php',  
        CURLOPT_FOLLOWLOCATION=>false,   
        CURLOPT_POST=>true,  
        CURLOPT_HEADER=>false,   
        CURLOPT_RETURNTRANSFER=>true,    
        CURLOPT_CONNECTTIMEOUT=>15,  
        CURLOPT_TIMEOUT=>100,    
        CURLOPT_POSTFIELDS=>array('XML'=>$src),   
        );  
        curl_setopt_array($Curl, $CurlOptions); 
        if(false === ($Result = curl_exec($Curl))) {    
        throw new Exception('Http request failed'); 
        }   
        curl_close($Curl);
        $xml = simplexml_load_string($Result);
        
        echo "<div class='alert'>";
            if ($xml->status[0]==1){
                echo "Сообщение отправленно клиенту $firstname $lastname";
            }
            if ($xml->status[0]==-3){
                echo "Недостаточно средств на счёте<br>";
                echo "<a href='https://my.epochta.ru/members/sms/billing/'>Пополнить счёт</a>";
            }
        echo "</div>";
    }
    

    
    function del($number){
        $con=dbconnect();
        $sql= "DELETE FROM clients WHERE number = '$number' LIMIT 1";
        if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
        }
        mysqli_close($con);
    }
    
    
    function find($search, $operator){
        $con = dbConnect();
        if ($operator == 100){
            $result = mysqli_query($con,"SELECT COUNT(*) FROM clients WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR number LIKE '%$search%'");
        }else{
            $result = mysqli_query($con,"SELECT COUNT(*) FROM clients WHERE op LIKE '$operator' AND (firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR number LIKE '%$search%')");
        }
        $row = mysqli_fetch_row($result);
        $rows = $row[0];
        $page_rows = 10;
        $last = ceil($rows/$page_rows);
        if($last < 1){
                $last = 1;
        }
        $pagenum = 1;
        if(isset($_GET['pn'])){
            $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
        }
        if ($pagenum < 1) { 
            $pagenum = 1; 
        } else if ($pagenum > $last) { 
            $pagenum = $last; 
        }
        $limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
        if ($operator == 100){
            $result = mysqli_query($con,"SELECT * FROM clients WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR number LIKE '%$search%' ORDER BY id DESC $limit");
        } else{
            $result = mysqli_query($con,"SELECT * FROM clients WHERE op LIKE '$operator' AND (firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR number LIKE '%$search%') ORDER BY id DESC $limit");
        }
        $paginationCtrls = '';
        if($last != 1){
                if ($pagenum > 1) {
                $previous = $pagenum - 1;
                        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=call&search='.$search.'&pn='.$previous.'"><-</a></li>';
                        for($i = $pagenum-4; $i < $pagenum; $i++){
                                if($i > 0){
                                $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=call&search='.$search.'&pn='.$i.'">'.$i.'</a></li>';
                                }
                    }
            }
                $paginationCtrls .= '<li><a href="#"><span class="label label-primary">'.$pagenum.'</span></a></li>';
                for($i = $pagenum+1; $i <= $last; $i++){
                        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=call&search='.$search.'&pn='.$i.'">'.$i.'</a></li>';
                        if($i >= $pagenum+4){
                                break;
                        }
                }
            if ($pagenum != $last) {
                $next = $pagenum + 1;
                $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=call&search='.$search.'&pn='.$next.'">-></a></li>';
            }
        }
        $list = '';
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $number = $row["number"];
                $end = $row["end"];
                $comp = $row["comp"];
                $sk = $row["sk"];

                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $age = $row["age"];
                $exp = $row["exp"];

                $model = $row["model"];
                $year = $row["year"];
                $cc = $row["cc"];
                $cost = $row["cost"];
                
                $comment = $row["comment"];

                $op = $row["op"];
                if ($operator == 100){
                    $list .="<tr class='click'>"
                            . "<td>$number</td>"
                            . "<td>$end</td>"
                            . "<td>$comp</td>"
                            . "<td>$sk</td>"
                            . "<td>$firstname</td>"
                            . "<td>$lastname</td>"
                            . "<td>$age</td>"
                            . "<td>$exp</td>"
                            . "<td>$model</td>"
                            . "<td>$year</td>"
                            . "<td>$cc</td>"
                            . "<td>$cost</td>"
                            . "<td>$comment</td>"
                            . "<td>$op</td></tr>";
                }else{
                     $list .="<tr class='click'>"
                            . "<td>$number</td>"
                            . "<td>$end</td>"
                            . "<td>$comp</td>"
                            . "<td>$sk</td>"
                            . "<td>$firstname</td>"
                            . "<td>$lastname</td>"
                            . "<td>$age</td>"
                            . "<td>$exp</td>"
                            . "<td>$model</td>"
                            . "<td>$year</td>"
                            . "<td>$cc</td>"
                            . "<td>$cost</td>"
                            . "<td>$comment</td></tr>";
                }
        }
        mysqli_close($con);
        
        return array($list, $paginationCtrls, $rows);
    }
    
        function findAll($search){
        $con = dbConnect();
        $result = mysqli_query($con,"SELECT COUNT(*) FROM clients WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR phonenumber LIKE '%$search%' OR number LIKE '%$search%'");
        $row = mysqli_fetch_row($result);
        $rows = $row[0];
        $page_rows = 10;
        $last = ceil($rows/$page_rows);
        if($last < 1){
                $last = 1;
        }
        $pagenum = 1;
        if(isset($_GET['pn'])){
            $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
        }
        if ($pagenum < 1) { 
            $pagenum = 1; 
        } else if ($pagenum > $last) { 
            $pagenum = $last; 
        }
        $limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
        $result = mysqli_query($con,"SELECT * FROM clients WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR phonenumber LIKE '%$search%' OR number LIKE '%$search%' ORDER BY id DESC $limit");
        $paginationCtrls = '';
        if($last != 1){
                if ($pagenum > 1) {
                $previous = $pagenum - 1;
                        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=base&search='.$search.'&pn='.$previous.'"><-</a></li>';
                        for($i = $pagenum-4; $i < $pagenum; $i++){
                                if($i > 0){
                                $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=base&search='.$search.'&pn='.$i.'">'.$i.'</a></li>';
                                }
                    }
            }
                $paginationCtrls .= '<li><a href="#"><span class="label label-primary">'.$pagenum.'</span></a></li>';
                for($i = $pagenum+1; $i <= $last; $i++){
                        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=base&search='.$search.'&pn='.$i.'">'.$i.'</a></li>';
                        if($i >= $pagenum+4){
                                break;
                        }
                }
            if ($pagenum != $last) {
                $next = $pagenum + 1;
                $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=base&search='.$search.'&pn='.$next.'">-></a></li>';
            }
        }
        $list = '';
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $number = $row["number"];
                $end = $row["end"];
                $comp = $row["comp"];
                $sk = $row["sk"];

                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $age = $row["age"];
                $exp = $row["exp"];

                $model = $row["model"];
                $year = $row["year"];
                $cc = $row["cc"];
                $cost = $row["cost"];
                
                $comment = $row["comment"];

                $op = $row["op"];
                $phonenumber = $row["phonenumber"];
                
                $list .="<tr class='click'>"
                            . "<td>$number</td>"
                            . "<td>$end</td>"
                            . "<td>$comp</td>"
                            . "<td>$sk</td>"
                            . "<td>$firstname</td>"
                            . "<td>$lastname</td>"
                            . "<td>$age</td>"
                            . "<td>$exp</td>"
                            . "<td>$model</td>"
                            . "<td>$year</td>"
                            . "<td>$cc</td>"
                            . "<td>$cost</td>"
                            . "<td>$comment</td>"
                            . "<td>$op</td>"
                            . "<td>$phonenumber</td></tr>";
        }
        mysqli_close($con);
        
        return array($list, $paginationCtrls, $rows);
    }
    
    
    function cdr($search, $inbound){
/*
$search_len = mb_strlen($search,'UTF-8');
if ($search_len==4){
    $search = preg_replace("/(\d\d)(\d\d)/", "2014-$2-$1", $search);
}
if ($search_len==3){
    $search = preg?_replace("/(\d)(\d\d)/", "2014-$2-0$1", $search);
}
*/
//clid = calldate
        
        $con = cdr_dbConnect();
        $result = mysqli_query($con,"SELECT COUNT(*) FROM cdr WHERE clid LIKE '%$search%' and dst LIKE '%$inbound%' and recordingfile <>''");
        $row = mysqli_fetch_row($result);
        $rows = $row[0];
        $page_rows = 20;
        $last = ceil($rows/$page_rows);
        if($last < 1){
                $last = 1;
        }
        $pagenum = 1;
        if(isset($_GET['pn'])){
            $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
        }
        if ($pagenum < 1) { 
            $pagenum = 1; 
        } else if ($pagenum > $last) { 
            $pagenum = $last; 
        }
        $limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;
        $result = mysqli_query($con,"SELECT * FROM cdr WHERE clid LIKE '%$search%' and dst LIKE '%$inbound%' and recordingfile <>'' ORDER by calldate DESC $limit");
        $paginationCtrls = '';
        if($last != 1){
                if ($pagenum > 1) {
                $previous = $pagenum - 1;
                        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=recordings&inbound='.$inbound.'&search='.$search.'&pn='.$previous.'"><</a></li>';
                        for($i = $pagenum-4; $i < $pagenum; $i++){
                                if($i > 0){
                                $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=recordings&inbound='.$inbound.'&search='.$search.'&pn='.$i.'">'.$i.'</a></li>';
                                }
                    }
            }
                $paginationCtrls .= '<li><a href="#"><span class="label label-primary">'.$pagenum.'</span></a></li>';
                for($i = $pagenum+1; $i <= $last; $i++){
                        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=recordings&inbound='.$inbound.'&search='.$search.'&pn='.$i.'">'.$i.'</a></li>';
                        if($i >= $pagenum+4){
                                break;
                        }
                }
            if ($pagenum != $last) {
                $next = $pagenum + 1;
                $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?page=recordings&inbound='.$inbound.'&search='.$search.'&pn='.$next.'">></a></li>';
            }
        }
        $list = '';
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				$date = preg_replace("/(\d+)-(\d+)-(\d+)\s(\d+):(\d+):(\d+)/", "$1/$2/$3", $row['calldate']);
				$time = preg_replace("/(\d+)-(\d+)-(\d+)\s(\d+):(\d+):(\d+)/", "$4:$5:$6", $row['calldate']);
				$clid = $row['clid'];
				$dst = $row['dst'];
				$billsec = $row['billsec'];
				$disposition = $row['disposition'];
				$path=preg_replace("/(\d+)-(\d+)-(\d+)\s(\d+):(\d+):(\d+)/", "$1/$2/$3/", $row['calldate']);
				$filename= ("records/" . $path . $row['recordingfile']);
				//if(file_exists($filename) and is_file($filename)){
                                    $list .="<tr>"
                                        . "<td>$date</td>"
                                        . "<td>$time</td>"
                                        . "<td>$clid</td>"
                                        . "<td>$dst</td>"
                                        . "<td>$billsec</td>"
                                        . "<td>$disposition</td>"
                                        . "<td><audio controls><source src='records/" . $path . $row['recordingfile'] . "' type='audio/wav'></audio></td>"
                                        . "<td class='file'>" . $path . $row['recordingfile'] . "</td>"
                                        . "</tr>";
                                    //}
        }
        mysqli_close($con);
        return array($list, $paginationCtrls, $rows);
    }
    
    function cdr_delete($file){
        $filename = $_SERVER['DOCUMENT_ROOT'] . "/telefonisk/records/" . $file;
        if (file_exists($filename)){
            unlink($filename);
        }
        
        $con = cdr_dbConnect();
        $recordingfile = preg_replace("/(^.{11})(.+)/", "$2", $file);
        $sql = "DELETE FROM cdr WHERE recordingfile LIKE '" . $recordingfile . "' LIMIT 1";
        if (!mysqli_query($con, $sql)) {
            die('Error: ' . mysqli_error($con));
        }
        mysqli_close($con);
    }
    

    function comment($number, $comment){
        $con=dbconnect();
        $sql = "UPDATE clients SET comment='$comment' WHERE number='$number'";
        if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
        }
        echo "<div class='alert'>";
        echo 'Коментарий добвлен';
        echo "</div>";
        mysqli_close($con);
    }

    
    
        
    
    
}
    