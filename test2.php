<?php    function curl($url){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }


        $feed = 'https://patients.apiary.io/patients';
        $tweets = curl($feed);
		echo $tweets;var_dump($tweets);
		print_r($tweets);?>