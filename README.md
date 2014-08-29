Welcome to MYWALL!
===================

這是一個分享圖片的社群，主要是參考了 [STYLEWALL](http://style.fashionguide.com.tw/) ，將 **缺點改進** 並且 **加強效能** 的簡單版本。

<br/>
聲明
-------------
本作品只限分享於研究、研討性質之使用，並不提供任何有營利效益之使用。
  如有營利用途，務必告知作者 OA(comdan66@gmail.com)，並且經由作者同意。

> **特別注意:**

> - 下列步驟中，由於在初始網站時候會建立初始資料以便於 Demo 或者研究函式功能，建立方法是藉由爬取 [STYLEWALL](http://style.fashionguide.com.tw/) 網站的首頁資源建立，如有進一步相關應用與授權，請與 [STYLEWALL](http://style.fashionguide.com.tw/) 官方聯絡，如有違法之行為，**作者不負相關責任**。

<br/>
快速安裝
-------------
1. 請先確保 Apache 是可以正常運行 **CodeIgniter**，以及可以正常開啓 controller、method，以及設定好相關的 **vhost** 以及 **domain**。

2. 開啓終端機，並且 cd 至目錄 **mywall** 下。

3. 將下列指令 複製到終端機 並執行 :
>cp resource/share/database.php application/config/database.php & mkdir upload & mkdir application/cell/cache & mkdir application/cache/file & mkdir application/cache/output & touch application/logs/query-log.log & touch application/logs/delay_job-log.log & chmod 777 temp & chmod 777 upload & chmod 777 application/cell/cache & chmod 777 application/cache/file & chmod 777 application/cache/output & chmod 777 application/logs/query-log.log & chmod 777 application/logs/delay_job-log.log

4. 修改 *application/config/database.php* 資料，建議 _$db['default']['database']_ 值改成 **mywall** 然後輸入你的 MySQL **帳號**、**密碼**，並且在你的 MySQL 建立一張表，建議名稱叫做 **mywall**。

5. 初始網站，開啓瀏覽器，並網址輸入 :
> http:// your domain /demo/c

開啓網頁後，程式會自動至 [STYLEWALL](http://style.fashionguide.com.tw/) 爬取資料，所以會有點久。

<br/>
一般安裝
-------------
1. 請先確保 Apache 是可以正常運行 **CodeIgniter**，以及可以正常開啓 controller、method，以及設定好相關的 **vhost** 以及 **domain**。

2. 開啓終端機，並且 cd 至目錄 **mywall** 下。

3. 首先複製建立 database file，在終端機輸入指令 :
> cp resource/share/database.php application/config/database.php

4. 然後修改 **database.php** 資料，建議 _$db['default']['database']_ 值改成 **mywall** 然後輸入你的 MySQL **帳號**、**密碼**，並且在你的 MySQL 建立一張表，建議名稱叫做 **mywall**。

5. 建立 upload 資料夾，在終端機輸入指令 :
> mkdir upload

6. 建立 cell cache 資料夾，在終端機輸入指令 :
> mkdir application/cell/cache

7. 建立 file cache 資料夾，在終端機輸入指令 :
> mkdir application/cache/file

8. 建立 output cache 資料夾，在終端機輸入指令 :
> mkdir application/cache/output

9. 建立 log file 檔案，在終端機輸入指令 :
> touch application/logs/query-log.log<br/>
> touch application/logs/delay_job-log.log

10. 設定資料夾、檔案權限 :
> chmod 777 temp<br/>
> chmod 777 upload<br/>
> chmod 777 application/cell/cache<br/>
> chmod 777 application/cache/file<br/>
> chmod 777 application/cache/output<br/>
> chmod 777 application/logs/query-log.log<br/>
> chmod 777 application/logs/delay_job-log.log 

11. 初始網站，開啓瀏覽器，並網址輸入 :
> http:// your domain /demo/c

開啓網頁後，程式會自動至 [STYLEWALL](http://style.fashionguide.com.tw/) 爬取資料，所以會有點久。
