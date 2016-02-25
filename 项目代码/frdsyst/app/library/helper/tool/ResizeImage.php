<?php 
//php生成缩略图片的类
class ResizeImage{
    public $type;//图片类型
    public $width;//实际宽度
    public $height;//实际高度
    public $resize_width;//改变后的宽度
    public $resize_height;//改变后的高度
    public $cut;//是否裁图
    public $srcimg;//源图象  
    public $dstimg;//目标图象地址
    public $im;//临时创建的图象
	public $quality;//图片质量
	public $img_array=array('jpg','png','gif');
	//http://www.phpernote.com/php-function/782.html
    function __construct($img,$wid,$hei,$c,$dstpath,$quality=100){
        $this->srcimg=$img;
        $this->resize_width=$wid;
        $this->resize_height=$hei;
        $this->cut=$c;
		$this->quality=$quality;
		//$this->type=strtolower(substr(strrchr($this->srcimg,'.'),1));//图片的类型
		$this->type=$this->checkFileType($this->srcimg);//更为严格的检测图片类型
		if(!in_array($this->type,$this->img_array)){
			return '';
		}
        $this->initi_img();//初始化图象
        $this -> dst_img($dstpath);//目标图象地址
        $this->width=imagesx($this->im);
        $this->height=imagesy($this->im);
        $this->newimg();//生成图象
        ImageDestroy($this->im);
    }
    function newimg(){
        $resize_ratio=($this->resize_width)/($this->resize_height);//改变后的图象的比例
        $ratio=($this->width)/($this->height);//实际图象的比例
        if(($this->cut)=='1'){//裁图
			if(function_exists('imagepng')&&(str_replace('.','',PHP_VERSION)>=512)){//针对php版本大于5.12参数变化后的处理情况
				$quality=9;
			}
            if($ratio>=$resize_ratio){//高度优先
                $newimg=imagecreatetruecolor($this->resize_width,$this->resize_height);
                imagecopyresampled($newimg,$this->im,0,0,0,0,$this->resize_width,$this->resize_height,(($this->height)*$resize_ratio),$this->height);
                imagejpeg($newimg,$this->dstimg,$this->quality);
            }
            if($ratio<$resize_ratio){//宽度优先
                $newimg=imagecreatetruecolor($this->resize_width,$this->resize_height);
                imagecopyresampled($newimg,$this->im,0,0,0,0,$this->resize_width,$this->resize_height,$this->width,(($this->width)/$resize_ratio));
                imagejpeg($newimg,$this->dstimg,$this->quality);
            }
        }else{//不裁图
            if($ratio>=$resize_ratio){
                $newimg=imagecreatetruecolor($this->resize_width,($this->resize_width)/$ratio);
                imagecopyresampled($newimg,$this->im,0,0,0,0,$this->resize_width,($this->resize_width)/$ratio,$this->width,$this->height);
                imagejpeg($newimg,$this->dstimg,$this->quality);
            }
			if($ratio<$resize_ratio){
                $newimg=imagecreatetruecolor(($this->resize_height)*$ratio,$this->resize_height);
                imagecopyresampled($newimg,$this->im,0,0,0,0,($this->resize_height)*$ratio,$this->resize_height,$this->width,$this->height);
                imagejpeg($newimg,$this->dstimg,$this->quality);
            }
        }
    }
    function initi_img(){//初始化图象
        if($this->type=='jpg'){
            $this->im=imagecreatefromjpeg($this->srcimg);
        }
        if($this->type=='gif'){
            $this->im=imagecreatefromgif($this->srcimg);
        }
        if($this->type=='png'){
            $this->im=imagecreatefrompng($this->srcimg);
        }
    }
    function dst_img($dstpath){//图象目标地址
        $full_length=strlen($this->srcimg);
        $type_length=strlen($this->type);
        $name_length=$full_length-$type_length;
        $name=substr($this->srcimg,0,$name_length-1);
        $this->dstimg=$dstpath;
		//echo $this->dstimg;
    }
	//读取文件前几个字节 判断文件类型
	function checkFileType($filename){
		$file=fopen($filename,'rb');
		$bin=fread($file,2); //只读2字节
		fclose($file);
		$strInfo =@unpack("c2chars",$bin);
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
		if($strInfo['chars1']=='-1'&&$strInfo['chars2']=='-40'){
			return 'jpg';
		}
		if($strInfo['chars1']=='-119'&&$strInfo['chars2']=='80'){
			return 'png';
		}
		return $fileType;
	}
}
?>