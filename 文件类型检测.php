<?php
/** 
* 1. 读取文件前几个字节 判断文件类型 
* @return String 
*/ 
function checkTitle($filename){ 
  $file=fopen($filename, "rb"); 
  $bin=fread($file, 2); //只读2字节 
  fclose($file); 
  $strInfo =@unpack("c2chars", $bin); 
  $typeCode=intval($strInfo['chars1'].$strInfo['chars2']); 
  $fileType=''; 
  switch($typeCode){ 
    case 7790: 
      $fileType='exe'; 
    break; 
    case 7784: 
      $fileType='midi'; 
    break; 
    case 8297: 
      $fileType='rar'; 
    break; 
    case 255216: 
      $fileType='jpg'; 
    break; 
    case 7173: 
      $fileType='gif'; 
    break; 
    case 6677: 
      $fileType='bmp'; 
    break; 
    case 13780: 
      $fileType='png'; 
    break; 
    default: 
      $fileType='unknown'.$typeCode; 
    break; 
  } 
  //Fix 
  if($strInfo['chars1']=='-1' && $strInfo['chars2']=='-40'){ 
    return 'jpg'; 
  } 
  if($strInfo['chars1']=='-119' && $strInfo['chars2']=='80'){ 
    return 'png'; 
  } 
  return $fileType; 
} 
echo checkTitle('0.jpg');

/*2.mime_content_type()函数判断获取mime类型

 mime_content_type返回指定文件的MIME类型，

用法：
echomime_content_type('php.gif') ."\n";
echomime_content_type('test.php');
输出：
*/

/*
php Fileinfo 获取文件MIME类型(finfo_open)

 PHP官方推荐mime_content_type()的替代函数是Fileinfo函数。PHP 5.3.0+已经默认支持Fileinfo函数(fileinfo support-enabled)，不必进行任何配置即可使用finfo_open()判断获取文件MIME类型。
用法：
$finfo    = finfo_open(FILEINFO_MIME);
$mimetype = finfo_file($finfo, $filename);
finfo_close($finfo);
*/

/* 3. 
image_type_to_mime_type()获取图片MIME类型

 如果需要判断MIME类型的文件只有图像文件，那么首先可以使用exif_imagetype()函数获取图像类型常量，再用image_type_to_mime_type()函数将图像类型常量转换成图片文件的MIME类型。
注意：需要在php.ini中配置打开php_mbstring.dll(Windows需要)和extension=php_exif.dll。
*/


/* 4. 
php上传文件获取MIME类型

如果使用php上传文件，检测上传文件的MIME类型，则可以使用全局变量$_FILES['uploadfile']['type']，由客户端的浏览器检测获取文件MIME类型。
*/
