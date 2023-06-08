<style>
    .face {
        margin: 0 auto;
        width: 350px;
        height: 450px;
        padding: 20px;
        background: rgba(250, 250, 250, 0.96);
        border: 3px solid #07ad90;
        border-radius: 3px;
    }

    .face .content {
        color: #666;
    }

    .face .content h2 {
        font-size: 1.2em;
        color: #07ad90;
    }

    .face .content .field-wrapper {
        margin-top: 40px;
        position: relative;
    }

    .face .content .field-wrapper label {
        position: absolute;
        pointer-events: none;
        font-size: 0.85em;
        top: 40%;
        left: 0;
        transform: translateY(-50%);
        transition: all ease-in 0.25s;
        color: #999999;
    }

    .face .content .field-wrapper input[type=text],
    .face .content .field-wrapper input[type=password],
    .face .content .field-wrapper input[type=submit] {
        -webkit-appearance: none;
        appearance: none;
    }

    .face .content .field-wrapper input[type=text]:focus,
    .face .content .field-wrapper input[type=password]:focus,
    .face .content .field-wrapper input[type=submit]:focus {
        outline: none;
    }

    .face .content .field-wrapper input[type=text],
    .face .content .field-wrapper input[type=password] {
        width: 100%;
        border: none;
        background: transparent;
        line-height: 2em;
        border-bottom: 1px solid #07ad90;
        color: #666;
    }

    .face .content .field-wrapper input[type=text]::-webkit-input-placeholder,
    .face .content .field-wrapper input[type=password]::-webkit-input-placeholder {
        opacity: 0;
    }

    .face .content .field-wrapper input[type=text]::-moz-placeholder,
    .face .content .field-wrapper input[type=password]::-moz-placeholder {
        opacity: 0;
    }

    .face .content .field-wrapper input[type=text]:-ms-input-placeholder,
    .face .content .field-wrapper input[type=password]:-ms-input-placeholder {
        opacity: 0;
    }

    .face .content .field-wrapper input[type=text]:-moz-placeholder,
    .face .content .field-wrapper input[type=password]:-moz-placeholder {
        opacity: 0;
    }

    .face .content .field-wrapper input[type=text]:focus+label,
    .face .content .field-wrapper input[type=text]:not(:placeholder-shown)+label,
    .face .content .field-wrapper input[type=password]:focus+label,
    .face .content .field-wrapper input[type=password]:not(:placeholder-shown)+label {
        top: -35%;
        color: #42509e;
    }

    .face .content .field-wrapper input[type=submit] {
        -webkit-appearance: none;
        appearance: none;
        cursor: pointer;
        width: 100%;
        background: #07ad90;
        line-height: 2em;
        color: #fff;
        border: 1px solid #07ad90;
        border-radius: 3px;
        padding: 5px;
    }

    .face .content .field-wrapper input[type=submit]:hover {
        opacity: 0.9;
    }

    .face .content .field-wrapper input[type=submit]:active {
        transform: scale(0.96);
    }
</style>


<div class="face">
    <div class="content">
        <h2>Sign in</h2>
        <form action="./api/login.php" method="post">
            <div class="field-wrapper">
                <input type="text" name="acc" placeholder="username">
                <label>帳號</label>
            </div>
            <div class="field-wrapper">
                <input type="password" name="pw" placeholder="password" autocomplete="new-password">
                <label>密碼</label>
            </div>
            <div class="field-wrapper">
                <input type="submit" value="登入">
            </div>
        </form>
        <?php
        if (isset($_GET['error'])) {
            switch ($_GET['error']) {
                case 1:
                    echo "<div style='color:red;margin-top:20px;font-size:24px'>帳號密碼錯誤<div>";
                    break;
                default:
                    break;
            }
        }
        ?>
    </div>
</div>