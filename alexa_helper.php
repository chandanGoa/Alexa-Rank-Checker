<?php

/*
* @copyright © 2017 WeaveBox.in
*/

function alexaRank($site)
{
    $xml = simplexml_load_file('http://data.alexa.com/data?cli=10&dat=snbamz&url=' .
        $site);

    $a = $xml->SD[1]->POPULARITY;
    if ($a != null)
    {
        $alexa_rank = $xml->SD[1]->POPULARITY->attributes()->TEXT;
        $alexa_rank = ($alexa_rank==null ? 'No Global Rank' : $alexa_rank);
    } else
    {
        $alexa_rank = 'No Global Rank';
    }
	   
    $a1 = $xml->SD[1]->COUNTRY;

    if ($a1 != null)
    {
        $alexa_pop = $xml->SD[1]->COUNTRY->attributes()->NAME;
        $regional_rank = $xml->SD[1]->COUNTRY->attributes()->RANK;
        $alexa_pop = ($alexa_pop==null ? 'None' : $alexa_pop);
        $regional_rank = ($regional_rank==null ? 'None' : $regional_rank);

    } else
    {
        $alexa_pop = 'None';
        $regional_rank = 'None';
    } 
	
	$a2 = $xml->RLS->RL;
	if ($a2 != null)
    {
		$related = array();
		$i = 0;
		foreach($a2 as $ap){
			$related[$i]['title'] = (string)$ap->attributes()->TITLE;
			$related[$i]['href'] = (string)$ap->attributes()->HREF;
			$i++;
		}

    } else
    {
        $related[$i]['title'] = 'None';
        $related[$i]['href'] = 'None';
    }


    return array($alexa_rank,$alexa_pop,$regional_rank,$related);
}

?>
