<style>
    table{
        margin:0 auto;
    }
    th{
        padding: 5px;
        color:red;
        text-align: left;
    }
    td{
        padding: 5px;
    }
    .new{
            display: block;
            background-color: skyblue;
            width: 12vh;
            height: 12vh;
            line-height: 12vh;
            position: fixed;
            top:71vh;
            right: 3vw;
            border-radius: 12vh;
            box-shadow: 0 0 10px #ccc;
            transition: 0.2s;
            font-size: 18px;
    }
    .new:hover{
        top:69vh;
    }
    .top{
        display: block;
            background-color: skyblue;
            width: 12vh;
            height: 12vh;
            line-height: 12vh;
            position: fixed;
            top:85vh;
            right: 3vw;
            border-radius: 12vh;
            box-shadow: 0 0 10px #ccc;
            transition: 0.2s;
            font-size: 18px;
    }
    
    .top:hover{
        top:83vh
    }
    .box{
        margin: 0 auto;
        background-color: white;
        width: 1000px;
        border: 1px solid #ccc;
        border-radius: 1em;
        box-shadow: 0 0 8px #ccc;
        padding: 30px;
    }
    a{
        text-decoration: none;
    }
</style>
<?php
$class=$pdo->query("select `class` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();
?>
<a class="new" href='?do=add_student_form&class=<?=$class?>'>新增學生</a>
<a class="top" href="#">Top</a>
<div class="box">
<h1 class="mb-3">班級管理系統</h1>

    <table>
        <tr>
            <th>姓名</th>
            <th>帳號</th>
            <th>班級</th>
            <th>座號</th>
            <th>權限</th>
            <th>操作</th>
        </tr>
        <?php
            $sql="select * from `members` where `class`='{$class}'";
            $rows=$pdo->query($sql)->fetchAll();
            foreach($rows as $row){
            if($row['pr']!='teacher'){
        ?>
        <tr>
            <form action="./api/edit_member.php" method="post">
            <td><input type="text" name="name" value="<?=$row['name']?>" require></td>
            <td><?=$row['acc']?></td>
            <td><?=$row['class']?></td>
            <td>
                <input type="text" name="num" value="<?=$row['num']?>" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" require>
            </td>
            <td>學生</td>
            <td>
                <input type="hidden" name="id" value="<?=$row['id']?>">
                <button class="btn btn-primary" type="submit">變更</button>
                <button class="btn btn-secondary" type="button" onclick="location.href='?do=change&id=<?=$row['id']?>'">修改密碼</button>
                <button class="btn btn-danger" type="button" onclick="location.href='?do=check_member&id=<?=$row['id']?>'">刪除</button>
            </td>
            </form>
        </tr>
        <?php
            }
            }
        ?>
    </table>
</div>