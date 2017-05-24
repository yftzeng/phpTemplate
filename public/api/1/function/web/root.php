<?php

$datamap_track = new \Datamap\Track();

$a = $datamap_track::test(array('track_id', 'data_from_uuid'), 'youtube');

$b = array('1','2','3');
echo ok('', array('a'=>$a, 'b'=>$b));
