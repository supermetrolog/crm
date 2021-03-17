		    		    <?
$link = 'https://pkk5.rosreestr.ru/#x=4034393.888696498&y=6756994.231129001&z=20&text=46%3A29%3A101001%3A10&type=1&app=search&opened=1';
$ch = curl_init($link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);	
var_dump($data);	    		    								