<div class='_content'>
  <h3>Isset</h3>
  isset 是拿來判斷該變數是否被 init 過，以及是否為 null。<br/>
  若是變數尚未被 init 過，或是 null 則為 false，其餘則 true。

<pre class='php prettyprint'>
  isset ($boolean);        /* 尚未給予或初始 boolean，故為 false。 */
  $boolean = null;
  isset ($boolean);        /* 雖然已經給予初始，並且給予值 null，但值為 null，故為 false。 */
</pre>

  <h3>練習</h3>
<pre class='php prettyprint'>
  if (isset ($boolean))
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's false.<br/>
> $boolean 尚未被 init，所以為 false。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = null;
  if (isset ($boolean))
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's false.<br/>
> 雖然 boolean 已被 init，但其值為 null，所以為 false。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = '';
  if (isset ($boolean))
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 空字串，但是對於 isset 來說 boolean 已經被 init，並且其值不為 null，所以為 true。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = 0;
  if (isset ($boolean))
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 整數 0，但是對於 isset 來說 boolean 已經被 init，並且其值不為 null，所以為 true。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = false;
  if (isset ($boolean))
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 布林值 false，但是對於 isset 來說 boolean 已經被 init，並且其值不為 null，所以為 true。<br/>
<br/>


<pre class='php prettyprint'>
  $boolean = array ();
  if (isset ($boolean))
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> 空陣，但是對於 isset 來說 boolean 已經被 init，並且其值不為 null，所以為 true。<br/>
<br/>


<pre class='php prettyprint'>
  class Book {
  }
  $book = new Book ();
  if (isset ($book))
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's true.<br/>
> book 有被 init，並且其值不為 null，所以為 true。<br/>
<br/>


<pre class='php prettyprint'>
  class Book {
  }
  $book = new Book ();
  if (isset ($book->page1))
    echo "It's true.";
  else
    echo "It's false.";
</pre>
> It's false.<br/>
> book 雖然有被 init，並且其值不為 null，不過其物件內的 page1 是尚未被 init 的，所以為 false。<br/>
<br/>


</div>