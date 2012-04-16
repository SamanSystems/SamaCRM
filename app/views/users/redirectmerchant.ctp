<?php

echo '<div class="content_title">
		<h2>در حال انتقال به دروازه پرداخت...</h2>
	  </div>
		
		<div class="content_content">
                <script type="text/javascript">
                    setTimeout(\'document.RedirectForm.submit()\',4000);
                </script>
                <form method="post" name="RedirectForm" action="'.$params['address'].'">';
                    foreach($params['params'] as $name=>$val)
                        echo "<input type='hidden' name='$name' value='$val' />";
echo "
                <input type='submit' name='redirect' value='انتقال به دروازه پرداخت آنلاين...' />
                </form>
    </div>";

?>