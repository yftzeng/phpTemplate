<?php

include __DIR__.'/app/config/bootstrap.php';
ini_set('error_log','error.log');

use Carbon\Carbon        as Carbon;
use Wow\Log\WowLog       as D;
use Wow\Util\Uuid        as Uuid;
use Wow\I18N\WowI18N     as I;
use Wow\Util\WowFunction as F;
use Wow\Util\WowJwt      as JWT;

//D::info('a');

/* *
echo $I->T(date('Y-m-d H:i:s'), 'UTC');
echo "\n";
echo $I->T(date('Y-m-d H:i:s'), 'Asia/Taipei');
echo "\n";
echo Carbon::now('Europe/London')->toDateTimeString();
echo "\n";
echo Carbon::now('UTC')->toDateTimeString();
echo "\n";
echo Carbon::now('UTC')->toIso8601String();
echo "\n";
/* */

/* *
$t = JWT::encode('{"d":"a"}');
$t = JWT::decode($t);
echo $t;
/* */

/* *
echo F::encode('data');
echo F::decode(F::encode('data'));
echo F::currentUtcTime();
/* */


/* *
$rs = ORM::for_table('users')->find_one();
 * */

/* *
$rs = ORM::for_table('users')->create();
$rs->member_uuid = Uuid::v1();
$rs->username  = 'xxx';
$rs->password  = 'ooo';
$rs->created_at = Carbon::now('UTC')->toDateTimeString();
$rs->updated_at = $I->T(date('Y-m-d H:i:s'), 'UTC');
$rs->save();
if ($rs === false) {
    echo "Error";
}
/* */

/* *
$currenttime = date('Y-m-d H:i:s');
$rs = ORM::for_table('users')
    ->where_lte('created_at', $I->T($currenttime, 'UTC'))
    ->find_many();
if ($rs === false) {
    echo "Error";
}
var_dump($rs[1]->created_at);
foreach($rs as $r) {
    $r->created_at = $I->T($currenttime);
}
var_dump($rs[1]->created_at);
/* */

//var_dump(ORM::get_last_query());
