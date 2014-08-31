<div class='_content'>
  <h3>Controller</h3>
  OA's controller 主要 base on CI_Controller，相關設定在 <pt>application/core/controllers/</pt> 下可以設定。<br/>
  命名規則主要為 <rf>00_name.php</rf>，依照<u>數字順序</u>決定 include 順序，這會影響到 extends 的先後順序。<br/>
  數字使用<rf>兩位數</rf>，名稱統一使用<rf>小寫</rf>。<br/>
  目前主要 controller 結構如下：
<pre>
CI_Controller
  │
  └── Root_controller              /* 基礎設定 */
        │
        ├── Oa_controller          /* 進階設定 */
        │     │
        │     ├── Admin_controller /* for 後台 */
        │     │
        │     └── Site_controller  /* for 前台 */
        │
        └── Delay_controller        /* for delay job */
</pre>
  <br/>

  <h3>前、後台 controller</h3>
  前台 controller 主要位置在 <pt>application/controllers/</pt> 下，主要繼承 Site_controller，所有關於前台使用的 method、load library.. 等，都可以在 Site_controller 設定。
  後台 controller 主要位置在 <pt>application/controllers/admin/</pt> 下，主要繼承 Admin_controller，所有關於後台使用的 method、load library.. 等，都可以在 Admin_controller 設定。
<pre>
  application/core/controllers/03_admin_controller.php
  application/core/controllers/04_site_controller.php
</pre>
  <br/>

  <h3>Controller 功能</h3>
  1. Root_controller 下基本常用功能有如下：
<pre>
  get_class ();  /* 取得目前的 controller 名稱 */
  get_method (); /* 取得目前的 controller 下的 method 名稱 */
  input_get ();  /* 接取頁面 $_GET 的參數 */
  input_post (); /* 接取頁面 $_POST 的參數 */
</pre>
  <br/>
  2. Oa_controller 下基本常用功能有如下：
<pre>
  add_javascript (); /* 在該頁面加入 js file */
  add_css ();        /* 在該頁面加入 css file */
  add_hidden ();     /* 在該頁面加入 hidden tag */
  add_meta ();       /* 在該頁面加入 meta tag */
  has_post ();       /* 判斷頁面是否有 $_POST 的參數 */
  is_ajax ();        /* 判斷頁面是否為 ajax 的 request */
  output_json ();    /* 輸出 json 格式的 result */
  load_view ();      /* Load 該頁面的 內容+Frame */
</pre>
  <br/>
  3. Site_controller、Admin_controller 主要使用 Root_controller、Oa_controller 的 method 做細部設定。
  <br/>
  <br/>
  4. Delay_controller 主要 for delay request 的 controller 使用，其中會需要驗證。
  <br/>
  <br/>

</div>