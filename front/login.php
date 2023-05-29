<form action="./api/login.php" method="post">
    <div>
        <label for="acc">帳號</label>
        <input type="text" name="acc" id="acc">
    </div>
    <div>
        <label for="pw">密碼</label>
        <input type="password" name="pw" id="pw">
    </div>
    <div>
        <input type="submit" value="登入">
    </div>
</form>
<?php
    if(isset($_GET['error'])){
        switch($_GET['error']){
            case 1:
                echo "<div style='color:red'>帳號密碼錯誤<div>";
                break;
            default:
                break;
            }
    }
?>