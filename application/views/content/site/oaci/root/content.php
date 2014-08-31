<div class='_content'>
  <h2>Root_controller</h2>
  初始原始基本設定，包含必須用到的 driver、helper 相關設定。<br/>
  其中分成主要項目有如下：
<pre>
  set_class ();   /* 設定 controller class 名稱，主要是 for load_content 取得正確 content.php 使用 */
  set_method ();  /* 設定 controller method 名稱，主要是 for load_content 取得正確 content.php 使用 */
  get_class ();   /* 取得 controller class 名稱 */
  get_method ();  /* 取得 controller method 名稱 */
  
  set_controllers_path ();  /* 設定 controller 資料夾位置 */
  set_libraries_path ();    /* 設定 library 資料夾位置 */
  set_views_path ();        /* 設定 view 資料夾位置 */
  get_controllers_path ();  /* 取得 controller 資料夾位置 */
  get_libraries_path ();    /* 取得 library 資料夾位置 */
  get_views_path ();        /* 取得 view 資料夾位置 */

  set_content_path ();  /* 設定 content 位於 view 的資料夾位置 */
  set_frame_path ();    /* 設定 frame 位於 view 的資料夾位置 */
  get_frame_path ();    /* 取得 content 位於 view 的資料夾位置 */
  get_content_path ();  /* 取得 frame 位於 view 的資料夾位置 */
  
  input_get ();   /* 接取頁面 $_GET 的參數 */
  input_post ();  /* 接取頁面 $_POST 的參數 */

  load_content ();  /* Load 該 controller class、method name 頁面的 內容 */
</pre>
<br/>

  <h3>Root_controller set_class (string $class_name)</h3>
  此 method 會在 Root_controller 建構子就給予該值，藉由 CI 原生的 $this->router->fetch_class () 取得目前的 class name。<br/>
  回傳值為該 controller 物件。<br/>
  <br/>

  <h3>Root_controller set_method (string $method_name)</h3>
  此 method 會在 Root_controller 建構子就給予該值，藉由 CI 原生的 $this->router->fetch_method () 取得目前的 method name。<br/>
  回傳值為該 controller 物件。<br/>
  <br/>

  <h3>string get_class ()</h3>
  取得 set_class 所設定的 class name 值。<br/>
  回傳值為 字串。<br/>
  <br/>

  <h3>string set_method ()</h3>
  取得 set_method 所設定的 method name 值。<br/>
  回傳值為 字串。<br/>
  <br/>

  <h3>Root_controller set_controllers_path ([string $...])</h3>
  此 method 會在 Root_controller 建構子就給予該值，其預設值為 controllers。<br/>
  每個參數則是對應於 application 下的一層層的資料夾名稱。<br/>
  回傳值為該 controller 物件。<br/>
  <br/>

  <h3>Root_controller set_libraries_path ([string $...])</h3>
  此 method 會在 Root_controller 建構子就給予該值，其預設值為 libraries。<br/>
  每個參數則是對應於 application 下的一層層的資料夾名稱。<br/>
  回傳值為該 controller 物件。<br/>
  <br/>

  <h3>Root_controller set_views_path ([string $...])</h3>
  此 method 會在 Root_controller 建構子就給予該值，其預設值為 views。<br/>
  每個參數則是對應於 application 下的一層層的資料夾名稱。<br/>
  回傳值為該 controller 物件。<br/>
  <br/>

  <h3>string get_controllers_path ()</h3>
  取得 set_controllers_path 所設定的 controllers 路徑。<br/>
  回傳值為 字串。<br/>
  <br/>

  <h3>string get_libraries_path ()</h3>
  取得 set_libraries_path 所設定的 libraries 路徑。<br/>
  回傳值為 字串。<br/>
  <br/>

  <h3>string get_views_path ()</h3>
  取得 set_views_path 所設定的 views 路徑。<br/>
  回傳值為 字串。<br/>
  <br/>

  <h3>Root_controller set_content_path ([string $...])</h3>
  此 method 會需要在 Site_controller or Admin_controller 的建構子就給予該值，其預設值為 array ()。<br/>
  Site_controller 建構子預設值為 array ('content', 'site')<br/>
  Admin_controller 建構子預設值為 array ('content', 'admin')<br/>
  每個參數則是對應於 views 下的一層層的資料夾名稱。<br/>
  回傳值為該 controller 物件。<br/>
  <br/>

  <h3>Root_controller set_frame_path ([string $...])</h3>
  此 method 會需要在 Site_controller or Admin_controller 的建構子就給予該值，其預設值為 array ()。<br/>
  Site_controller 建構子預設值為 array ('frame', 'site')<br/>
  Admin_controller 建構子預設值為 array ('frame', 'admin')<br/>
  每個參數則是對應於 views 下的一層層的資料夾名稱。<br/>
  回傳值為該 controller 物件。<br/>
  <br/>

  <h3>string get_frame_path ()</h3>
  取得 set_content_path 所設定的 frame 路徑。<br/>
  回傳值為 字串。<br/>
  <br/>

  <h3>string get_content_path ()</h3>
  取得 set_content_path 所設定的 content 路徑。<br/>
  回傳值為 字串。<br/>
  <br/>

  <h3>string input_get ()</h3>
  取得頁面 $_GET 的參數，是架構在 CI 的 $this->input->get ();<br/>
  其相關應用可以到 <a>這裡</a> 了解！<br/>
  失敗或者沒有該變數，則回傳 null。<br/>
  <br/>

  <h3>string input_post ()</h3>
  取得頁面 $_POST 的參數，是架構在 CI 的 $this->input->post (); 並且加入了接收圖片等功能強化。<br/>
  其相關應用可以到 <a>這裡</a> 了解！<br/>
  失敗或者沒有該變數，則回傳 null。<br/>
  <br/>


  <h3>string load_content ()</h3>
  取得頁面 $_POST 的參數，是架構在 CI 的 $this->input->post (); 並且加入了接收圖片等功能強化。<br/>
  其相關應用可以到 <a>這裡</a> 了解！<br/>


</div>