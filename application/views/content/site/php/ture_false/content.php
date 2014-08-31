<div class='_content'>
  <h3>True or False</h3>
  php 語言中變數皆可以拿來做布林判斷，其規則主要為 非下列值 則為 true。
<pre class='php prettyprint'>
  $boolean = 0;        /* 非零則對，其中字串 '0' 也為 false。 */
  $boolean = false;    /* 不解釋。 */
  $boolean = '';       /* 空字串，字串 '0'，也為 false。 */
  $boolean = array (); /* 空陣列，只要 count 為 0，就為 false。 */
  $boolean = null;     /* 不解釋。 */
</pre>

  <h3>練習</h3>
<pre class='php prettyprint'>
  $boolean = '';
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's false.<br/>
> 空字串，所以為 false。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = 'hello';
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 非空字串，所以為 true。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = 0;
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's false.<br/>
> 0 為 false。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = '0';
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's false.<br/>
> 字串 '0'，所以 php 將其形態視為整數，整數 0 故為 false。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = '0.0';
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 字串 '0.0'，非空字串，所以為 true。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = false;
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's false.<br/>
> 布林函數 false，不解釋。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = 'false';
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 字串 'false'，非空字串，所以為 true。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = array ();
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's false.<br/>
> 空的陣列，故為 false。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = array (0);
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 不為空的陣列，也就是長度大於 0，故為 true<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = array (null);
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 不為空的陣列，也就是長度大於 0，故為 true<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = array ('');
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 不為空的陣列，也就是長度大於 0，故為 true<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = 'array ()';
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 字串 'array ()'，非空字串，所以為 true。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = null;
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's false.<br/>
> null，就是 false。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = 'null';
  if ($boolean)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 字串 'null'，非空字串，所以為 true。<br/>
<br/>


<pre class='php prettyprint'>
  class Book {

  }
  $book = new Book ();
  if ($book)
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 有實作物件，所以為 true。<br/>
<br/>


</div>