<?php
// Manba @IT_HACK_ZONE // // Tarqatildi @IT_HackerZone ga Agarda kimda kim manbaga tegsa rozi emasmiz. 
ob_start();
define('API_TOKEN','7578029627:AAETdVpOtPjURS6RwjczEqk3Owdi6DRaWNg');
$admin = "5410810778";
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_TOKEN."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
var_dump(curl_error($ch));
    }else{
return json_decode($res);
    }
}

// O'zagurvchilar //
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$cid = $message->chat->id;
$mid = $message->message_id;
$text = $message->text;
$number = $message->number;
$fid= $message->from->id;
$name = $message->from->first_name;
$botname = bot('getme',['bot'])->result->username;
$user = $message->from->username;

//inline metodlar
$data = $update->callback_query->data;
$qid = $update->callback_query->id;
$ccid = $update->callback_query->message->chat->id;
$cmid = $update->callback_query->message->message_id;
$callfrid = $update->callback_query->from->id;
$callname = $update->callback_query->from->first_name;
$calluser = $update->callback_query->from->username;
$surname = $update->callback_query->from->last_name;
$step = file_get_contents("step/$cid.txt");
$last = file_get_contents("last.txt");
$video = $message->video;
$baza = "2452546891"; // Kino yigʻiladigan baza kanal IDsi
$kanal_user = "Baza_Useri"; // Kino yigʻiladigan baza kanal Username si
$kanal = "Kino_Kodi"; // Kino kodlari tashlanadigan kanal

mkdir("step");

function joinchat($id){
global $mid;
$array = array("inline_keyboard");
$kanallar = "@reklama_kanal";
if($kanallar == null){
return true;
}else{
$ex = explode("
",$kanallar);
for($i=0;$i<=count($ex) -1;$i++){
$first_line = $ex[$i];
$first_ex = explode("@",$first_line);
$url = $first_ex[1];
$ism=bot('getChat',['chat_id'=>"@".$url,])->result->title;
$ret = bot("getChatMember",[
"chat_id"=>"@$url",
"user_id"=>$id,
]);
$stat = $ret->result->status;
if((($stat=="creator" or $stat=="administrator" or $stat=="member"))){
$array['inline_keyboard']["$i"][0]['text'] = "✅ ". $ism;
$array['inline_keyboard']["$i"][0]['url'] = "https://t.me/$url";
}else{
$array['inline_keyboard']["$i"][0]['text'] = "❌ ". $ism;
$array['inline_keyboard']["$i"][0]['url'] = "https://t.me/$url";
$uns = true;
}
}
$array['inline_keyboard']["$i"][0]['text'] = "🔄 Tekshirish";
$array['inline_keyboard']["$i"][0]['url'] = "https://t.me/Bot_useri?start";
if($uns == true){
bot('sendMessage',[
'chat_id'=>$id,
'text'=>"<b>⚠️ Botdan to'liq foydalanish uchun quyidagi kanallarimizga obuna bo'ling!</b>",
'parse_mode'=>'html',
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode($array),
]);
return false;
}else{
return true;
}}}

if(mb_stripos($text,"/start")!==false){
   $baza=file_get_contents("statistika.txt");
   if(mb_stripos($baza,$cid) !==false){
   }else{
   $txt="
$cid";
   $file=fopen("statistika.txt","a");
   fwrite($file,$txt);
   fclose($file);
   }
}

$panel = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[["text"=>"➕ Film yuklash"],["text"=>"📨 Xabar yuborish"]],
[["text"=>"📊 Statistika"],["text"=>"📁 Bot kodi"]],
]]);

if($text == "/start"){
if(joinchat($cid)=="true"){
bot('sendPhoto',[
'chat_id'=>$cid,
'photo'=>"t.me/$kanal/170",
'caption'=>"<b>👑 Assalomu alaykum. Kino kodini kiriting:</b>

/last - Botga soʻnggi yuklangan film.",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🎦 KINOLARNI TOPISH",'url'=>"t.me/$kanal"]],
]])
]);
}}

$filmkod = explode(" ",$text);
$filmkod = $filmkod[1];
if(mb_stripos($text, "/start") !==false){
bot('sendvideo',[
'chat_id'=>$cid,
'video'=>"https://t.me/$kanal_user/$filmkod",
'caption'=>"<b>🛅 Siz soʻragan film topildi!</b>

<i>@$botname - Kinolar olami!</i>",
'parse_mode'=>"html",
]);
}

if($video){
$id = bot('CopyMessage',[
'chat_id'=>"-100$baza",
'from_chat_id'=>$cid,
'message_id'=>$mid,
])->result->message_id;
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"🚀 Botga yangi kino yuklandi!

#️⃣ Film kodi: $id",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"Postni koʻrish",'url'=>"t.me/$kanal_user/$id"]],
]])
]);
file_put_contents("last.txt","$id");
}

if(isset($text) and !$video){
$ok = bot('sendvideo',[
'chat_id'=>$cid,
'video'=>"https://t.me/$kanal_user/$text",
'caption'=>"<b>🛅 Siz soʻragan film topildi!</b>

<i>@$botname - Kinolar olami!</i>",
'parse_mode'=>"html",
])->result->message_id;
}

if($text == "/last"){
if(joinchat($cid)=="true"){
bot('sendvideo',[
'chat_id'=>$cid,
'video'=>"t.me/$kanal/$last",
'caption'=>"<b>🚀 Marxamat, botga soʻnggi yuklangan film:</b>

<i>@$botname - Kinolar olami!</i>",
'parse_mode'=>"html",
]);
}}

if($text == "/panel"){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>👤 Assalomu alaykum hurmatli administrator. Panel siz uchun ochiq!</b>",
'parse_mode'=>"html",
'reply_markup'=>$panel,
]);
}

$baza = file_get_contents("statistika.txt");
$stat = substr_count($baza,"
");
if($text == "📊 Statistika"){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"<b>📊 Bot aʼzolari soni: $stat ta</b>",
'parse_mode'=>"html",
'reply_markup'=>$panel,
]);
}

if($text == "📁 Bot kodi"){
bot('sendDocument',[
'chat_id'=>$admin,
'document'=>new CURLFile(__FILE__),
'caption'=>"🖥️ Marxamat, @$botname kodi.",
'parse_mode'=>"html",
'reply_markup'=>$panel,
]);
}

if($text == "➕ Film yuklash"){
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"Kinoni kiriting:

Baza: @$kanal_user",
'parse_mode'=>"html",
'reply_markup'=>$panel,
]);
}

if($text == "📨 Xabar yuborish"){
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Yuboriladigan xabar turini tanlang</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"Bitta foydalanuvchiga xabar",'callback_data'=>"user"]],
[['text'=>"Barcha foydalanuvchilariga xabar",'callback_data'=>"send"]],
[['text'=>"Yopish",'callback_data'=>"panel"]],	
]])
]);
}

$saved = file_get_contents("step/xabar.txt");
if($data == "user"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Foydalanuvchi iD raqamini kiriting:</b>",
'parse_mode'=>'html',
]);
file_put_contents("step/$ccid.txt",'user');
}

if($step == "user"){
if(is_numeric($text)=="true"){
file_put_contents("step/xabar.txt",$text);
	bot('SendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>Xabaringizni kiriting:</b>",
	'parse_mode'=>'html',
	]);
file_put_contents("step/$cid.txt",'xabar');
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Faqat raqamlardan foydalaning!</b>",
'parse_mode'=>'html',
]);
}
}

if($step == "xabar"){
	bot('SendMessage',[
	'chat_id'=>$saved,
	'text'=>"$text",
        'parse_mode'=>'html',
'disable_web_page_preview'=>true,
'protect_content'=>true,
	]);
	bot('SendMessage',[
	'chat_id'=>$cid,
	'text'=>"<b>✅ Xabaringiz yuborildi.</b>",
       'parse_mode'=>'html',
        'reply_markup'=>$panel,
	]);
	unlink("step/$cid.txt");
	unlink("step/xabar.txt");
}

if($data == "send"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"*Xabaringizni kiriting:*",
'parse_mode'=>"markdown",
'reply_markup'=>$boshqarish
]); file_put_contents("step/$ccid.txt","users");
}
if($step=="users"){
$lich = file_get_contents("statistika.txt");
$lichka = explode("
",$lich);
foreach($lichka as $lichkalar){
$okuser=bot("sendmessage",[
'chat_id'=>$lichkalar,
'text'=>$text,
'parse_mode'=>'html',
'disable_web_page_preview'=>true,
]);
}
}
if($okuser){
bot("sendmessage",[
'chat_id'=>$cid,
'text'=>"<b>✅ Hammaga yuborildi.</b>",
'parse_mode'=>'html',
'reply_markup'=>$panel
]);
unlink("step/$cid.txt");
}