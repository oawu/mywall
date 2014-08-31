<div class='_content'>
  <h3>Controller</h3>
  開一個頁面以下列舉例。<br/>
  新增一個前台頁面 其網址為 http://demain/main/index<br/>
  首先 在 <pt>application/controllers/</pt> 下新增一個 main.php 檔案，並且繼承 Site_controller。<br/>
  然後 新增一個 public 的 method 名稱為 index。<br/>
<pre>
  application
    └── controllers
          └── <rf>main.php</rf>
</pre>
  <br/>

  <h3>View</h3>
  接著在 <pt>application/views/content/site/</pt> 下新增一個資料夾，並且命名為 main。<br/>
  然後也在 main 底下新增名稱為 index 的資料夾。<br/>
  最後在 index 內新增三隻檔案分別為 content.<rf>css</rf>、content.<rf>js</rf>、content.<rf>php</rf>。
<pre>
  application
    └── views
          └── content
                └── site /* 前台使用，若為後台則是 admin */
                      └── <rf>main</rf> /* 相對應於 class name */
                            └── <rf>index</rf> /* 相對應於 method name */
                                  ├── <rf>content.css</rf> /* 該頁面下的 css */
                                  ├── <rf>content.js</rf>  /* 該頁面下的 js */
                                  └── <rf>content.php</rf> /* 該頁面下的 php */
</pre>
  <br/>

  <h3>Load View</h3>
  開啟 <pt>application/controllers/main.php</pt> 並且於 index method 內新增一語法 $this->load_view ();。<br/>
<pre class='php prettyprint'>
  class Main extends Site_controller {

    public function __construct () { /* 建構子 */
      parent::__construct ();
    }

    public function index () {
      $this->load_view ();
    }
  }
</pre>
  <br/>

  <h3>開啟</h3>
  打開瀏覽器，並且輸入你的網址 http://demain/main/index 便可以看到該頁面內容。
  <br/>

  <br/>
</div>