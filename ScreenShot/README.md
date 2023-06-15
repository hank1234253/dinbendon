# 分析需要的功能
## 功能一
* 登入登出系統
* 會員管理系統
* 權限管理
## 功能二
* 點餐系統
    * 點餐
    * 編輯
    * 取消
* 新增餐廳
* 編輯餐廳
* 刪除餐廳
## 功能三
* 班級點餐紀錄
* 簡易記帳系統
* 個人點餐紀錄

# 資料表
## 資料表一 會員(members)


| 欄位名 | 資料型態 | 主鍵 | 預設值 | 自動遞增 | 備註 |
| --- | --- | --- | --- | --- | --- |
|id|int(11)|V ||V|id|
|name|varchar(30)|X||X|姓名|
|acc|varchar(20)|X||X|帳號|
|pw|varchar(20)|X||X|密碼|
|class|int(11)|X||X|班級|
|num|int(11)|X||X|座號|
|pr|varchar(10)|X|student|X|權限|
## 資料表二 餐廳(restaurants)
|欄位名|資料型態|主鍵|預設值|自動遞增|備註|
| --- | --- | --- | --- | --- | --- |
|id|int(11)|V||V|id|
|name|varchar(30)|X||X|餐廳名稱|
|tel|varchar(20)|X||X|餐廳電話|
|addr|text|X||X|餐廳地址|
|img|text|X||X|餐廳圖片名稱|
|menu_img|text|X||X|菜單圖片名稱|
## 資料表三 餐點(options)
|欄位名|資料型態|主鍵|預設值|自動遞增|備註|
| --- | --- | --- | --- | --- | --- |
|id|int(11)|V||V|id|
|name|varchar(20)|X||X|餐點名稱|
|dollar|int(11)|X||X|價格|
|restaurant_id|int(11)|X||X|餐廳id 對應restaurant資料的id|
## 資料表四 紀錄(logs)
|欄位名|資料型態|主鍵|預設值|自動遞增|備註|
| --- | --- | --- | --- | --- | --- |
|id|int(11)|V||V|id|
|acc|varchar(20)|X||X|帳號|
|class|int(11)|X||X|班級|
|restaurant|varchar(30)|X||X|餐廳名稱|
|buy|text|X||X|所訂餐點|
|pay|int(11)|X||X|已付金額|
|create_time|timestamp|X|current_timestamp()|X|點餐時間|
        





