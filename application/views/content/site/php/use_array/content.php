<div class='_content'>
  <h3>Array</h3>
  在 php 中，array 會被經常拿來使用，<br/>
  搭配上 foreach 或者 相關函式應用可以發揮出更好的效果。<br/>
  php 中的 array 可以至官網閱讀更多相關訊息。<br/>
    > 1. <a href='http://php.net/manual/en/language.types.array.php' target='_blank'>php 中的 array</a><br/>
    > 2. <a href='http://php.net/manual/en/ref.array.php' target='_blank'>array 內部函式庫</a><br/>
  以下就列出幾個常用的應用。<br/>
  <br/>

<pre class='php prettyprint'>
  $arr = array (1, 2, 3, 4, 5);
  if ($arr)
    foreach ($arr as $val)
      echo $val;
</pre>
> 印出 12345<br/>
> 這是正常使用的 array 的方式。<br/>
<br/>


<pre class='php prettyprint'>
  $arr = array (1, 2, 3, 4, 5);
  $arr = array_map (function ($val) {
    return $val % 2 ? $val : null;
  }, $arr);
  var_dump ($arr);
</pre>
> 印出 array(5) { [0] => int(1) [1] => NULL [2] => int(3) [3] => NULL [4] => int(5) }<br/>
> 可以得知，array_map 內的 function 逐一的處理 $arr 內的值，並且將所有的 return 組成一個 array。<br/>
> function 將 $val 作 mod 2 也就是說當為基數時 回傳該值，偶數則為 null。<br/>
<br/>


<pre class='php prettyprint'>
  $arr = array (1, 2, 3, 4, 5);
  $arr = array_map (function ($val) {
    return $val % 2 ? $val : null;
  }, $arr);
  $arr = array_filter ($arr);
  var_dump ($arr);
</pre>
> 印出 array(3) { [0] => int(1) [2] => int(3) [4] => int(5) }<br/>
> array_filter 主要是過濾 array，預設是過濾掉會為 false 的值。<br/>
> 所以在 array_map 完後，若為 null 的元素就會被 array_filter 過濾掉。<br/>
<br/>


<pre class='php prettyprint'>
  $arr = array (1, 2, 3, 4, 5);
  $arr = array_filter ($arr, function ($val) {
    return $val % 2;
  });
  var_dump ($arr);
</pre>
> 印出 array(3) { [0] => int(1) [2] => int(3) [4] => int(5) }<br/>
> 由上方兩個例子可以得知，是可直接使用 array_filter 的。<br/>
> 在 array_filter 的 function 的 return 只要為 true 就可以回傳該值，false 則被過濾掉。<br/>
<br/>


<pre class='php prettyprint'>
  $arr = array (1, 2, 3, 4, 5);
  $arr = array_filter ($arr, function ($val) {
    return $val % 2;
  });
  var_dump ($arr);
  $arr = array_values ($arr);
  var_dump ($arr);
</pre>
> 印出<br/>
> array(3) { [0] => int(1) [2] => int(3) [4] => int(5) }<br/>
> array(3) { [0] => int(1) [1] => int(3) [2] => int(5) }<br/>
> 因為 array_filter 是把該元素抽離，所以原 key 則不變，<br/>
> 若要 key 有順序性，可以利用 array_values 將 key 重新設定。<br/>
<br/>

</div>