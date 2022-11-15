<?php            

if($_POST['submit']){
	
	$sql_insert = ' INSERT INTO %s ( %s ) VALUES %s  ';
	
	$insert_data = '';
	foreach(preg_split("/((\r?\n)|(\r\n?))/", $_POST['csv']) as $line){
		// do stuff with $line
		$col = '';
		foreach(preg_split("/(\,)/", $line) as $c){
			$col .= sprintf('  "%s",', $c);
		}
		$col = rtrim($col, ",");
		$insert_data .=  '(' . $col . '),';
	} 
	//echo '' . $insert_data . '<br>';
	$insert_data = rtrim($insert_data, ",");
	
	$sql = sprintf($sql_insert, $_POST['tablename'], $_POST['fieldlist'], $insert_data);
	//exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CSV to MySQL Insert SQL :: mon3</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  </head>
  <body>
  <section class="section">
    <div class="container">
        <h1 class="title">CSV to MySQL Insert SQL </h1>
      
        <form class="form-horizontal" method="POST" id="usrform">
            
            <!-- Text input-->
            <div class="field">
              <label class="label" for="tablename">tablename</label>
              <div class="control">
                <input id="tablename" name="tablename" type="text" placeholder="" class="input ">
                
              </div>
            </div>
            
            <!-- Text input-->
            <div class="field">
              <label class="label" for="fieldlist">fieldlist</label>
              <div class="control">
                <input id="fieldlist" name="fieldlist" type="text" placeholder="" class="input ">
                
              </div>
            </div>
            
            <!-- Textarea -->
            <div class="field">
              <label class="label" for="csv">csv</label>
              <div class="control">                     
                <textarea class="textarea" id="csv" name="csv"></textarea>
              </div>
            </div>
            
            <input type="submit" name='submit'>
        </form>
        
        <div class="column"> <code><?php echo $sql ?></code></div>

    </div>
    
    
  </section>
  </body>
</html>
