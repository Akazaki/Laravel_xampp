<?php
/**
 * ファイルを総合的に扱うクラス
 *
 * 画像ファイルのリサイズをおこなう
 */
class FileTool
{
	var $filename = NULL;

	function FileTool($_filename)
	{
		if(file_exists($_filename)){
			$this->filename = $_filename;
		}else{
			print('"' . $_filename . '" is not found.');
		}
	}

	/**
	 * 画像ファイルから画像リソースを取得しリサイズする
	 *
	 * @param string $srcCile : ソース画像ファイル名
	 * @param integer $dstW : 変換後幅
	 * @param integer $dstH : 変換後高さ
	 * @param string $bgcolor : 背景色、指定すると幅・高さ固定になる
	 * @param boolean $expand : 変換後のサイズが元サイズより大きい場合、拡大する
	 * @param string $position : 位置。L(左寄せ)R(右寄せ)T(上寄せ)B(下寄せ)
	 */
	function resizeImage($filename, $dstW, $dstH, $bgcolor=FALSE, $expand=FALSE, $position='')
	{
		$extension = $this->getMimeFromExtension($this->filename);

		if($extension == 'image/gif' || $extension == 'image/png' || $extension == 'image/jpeg'){
		}else{
			// 画像以外の場合の処理（ファイルの画像化）
			return FALSE;
		}

		list($srcW, $srcH) = getimagesize($this->filename);

		$rate = $dstW / $srcW;
		if($rate > $dstH / $srcH){
			$rate = $dstH / $srcH;
			$rszH = $dstH;
			$rszW = round($srcW * $rate);
		}else{
			$rszW = $dstW;
			$rszH = round($srcH * $rate);
		}
		if(! $expand && $rate > 1){
			$rszW = $srcW;
			$rszH = $srcH;
		}

		if($bgcolor === FALSE){
			$resource = imagecreatetruecolor($rszW, $rszH);
			$dstL = $dstT = 0;
		}else{
			$resource = imagecreatetruecolor($dstW, $dstH);
			preg_match('/#?(..)(..)(..)/i', $bgcolor ,$c);
			imagefill($resource, 0, 0, imagecolorallocate($resource, intval($c[1], 16), intval($c[2], 16), intval($c[3], 16)));

			if(strpos($position, 'L') !== FALSE){
				$dstL = 0;
			}else if(strpos($position, 'R') !== FALSE){
				$dstL = $dstW - $rszW;
			}else{
				$dstL = intval(($dstW - $rszW) / 2);
			}
			if(strpos($position, 'T') !== FALSE){
				$dstT = 0;
			}else if(strpos($position, 'B') !== FALSE){
				$dstT = $dstH - $rszH;
			}else{
				$dstT = intval(($dstH - $rszH) / 2);
			}
		}

		imagecopyresampled($resource, $this->imagecreatefrom($this->filename), $dstL, $dstT, 0, 0, $rszW, $rszH, $srcW, $srcH);
		$this->imagecreateto($resource, $filename);
	}

	/**
	 * イメージリソースを作成する
	 *
	 * @param string $filename : ソースファイル名
	 */
	function imagecreatefrom($filename)
	{
		$imageProperty = getimagesize($filename);
		if($imageProperty){
			$mime = $imageProperty['mime'];
		}else{
			return FALSE;
		}

		if($mime == 'image/gif'){
			return imagecreatefromgif($filename);
		}else if($mime == 'image/png'){
			return imagecreatefrompng($filename);
		}else if($mime == 'image/jpeg'){
			return imagecreatefromjpeg($filename);
		}else{
			return FALSE;
		}
	}
	/**
	 * ファイル名の拡張子から推定したファイルを作成する
	 *
	 * @param imageResource $image : イメージリソース
	 * @param string $filename : 出力先ファイル名
	 */
	function imagecreateto($resource, $filename=NULL)
	{
		$extension = $this->getMimeFromExtension($filename);
		if($extension === FALSE){
			$extension = $filename;
			$filename = NULL;
		}


		if($extension == 'image/gif'){
			return ($filename) ? imagegif($resource, $filename) : imagegif($resource);
		}else if($extension == 'image/png'){
			return ($filename) ? imagepng($resource, $filename) : imagepng($resource);
		}else if($extension == 'image/jpeg'){
			return ($filename) ? imagejpeg($resource, $filename) : imagejpeg($resource);
		}else{
			return FALSE;
		}
	}

	function getMimeFromExtension($filename)
	{
		if(mb_ereg('^.+\.([\w]+)$', $filename, $match)){
			$extension = mb_strtolower($match[1]);
		}else{
			return FALSE;
		}

		if($extension == 'gif' || $extension == 'png' || $extension == 'jpeg'){
			return 'image/' . $extension;
		}else if($extension == 'jpg'){
			return 'image/jpeg';
		}else if($extension == 'pdf' || $extension == 'zip'){
			return 'application/' . $extension;
		}else if($extension == 'doc'){
			return 'application/msword';
		}else if($extension == 'xls'){
			return 'application/vnd.ms-excel';
		}else{
			return FALSE;
		}
	}
	function getMime($filename)
	{
		$imageProperty = getimagesize($filename);
		if($imageProperty){
			return $imageProperty['mime'];
		}else{
			return FALSE;
		}
	}
}
?>
