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
            width: 100px;
            height: 100px;
            line-height: 100px;
            position: fixed;
            top:73vh;
            right: 3vw;
            border-radius: 50px;
            box-shadow: 0 0 10px #ccc;
            transition: 0.2s;
    }
    .new:hover{
        top:71vh;
    }
    .top{
        display: block;
            background-color: skyblue;
            width: 100px;
            height: 100px;
            line-height: 100px;
            position: fixed;
            top:86vh;
            right: 3vw;
            border-radius: 50px;
            box-shadow: 0 0 10px #ccc;
            transition: 0.2s;
    }
    
    .top:hover{
        top:84vh
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
<a class="new" href='?do=add_form'>新增會員</a>
<a class="top" href="#">Top</a>
<div class="box">
<h1 class="mb-3">會員管理系統</h1>
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
            $sql="select * from `members` order by `class`,`num`";
            $rows=$pdo->query($sql)->fetchAll();
            $classes=$pdo->query("select `class` from `members` group by `class`")->fetchAll();
            foreach($rows as $row){
            if($row['pr']!='super'){
        ?>
        <tr>
            <form action="./api/edit_member.php" method="post">
            <td><input type="text" name="name" value="<?=$row['name']?>" require></td>
            <td><?=$row['acc']?></td>
            <td>
                <select name="class">
                <?php
                    foreach($classes as $class){
                        if($class['class']!='0'){
                ?>
                    <option value="<?=$class['class']?>" <?php if($class['class']==$row['class'])echo "selected"?> ><?=$class['class']?></option>
                <?php
                }
                }
                ?>
                </select>
            </td>
            <td>
                <input type="text" name="num" value="<?=$row['num']?>" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" require>
            </td>
            <td>
                <select name="pr">
                    <option value="teacher" <?=($row['pr']=="teacher")?"selected":""?>>老師</option>
                    <option value="student" <?=($row['pr']=="student")?"selected":""?>>學生</option>
                </select>
            </td>
            <td>
                <input type="hidden" name="id" value="<?=$row['id']?>">
                <button class="btn btn-primary" type="submit">變更</button>
                <button class="btn btn-secondary" type="button" onclick="location.href='?do=check_member&id=<?=$row['id']?>'">刪除</button>
                <button class="btn btn-danger"  type="button" onclick="location.href='?do=change&id=<?=$row['id']?>'">修改密碼</button>
            </td>
            </form>
        </tr>
        <?php
            }
            }
        ?>
    </table>
</div>