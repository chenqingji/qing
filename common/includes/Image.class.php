<?php
/**
 * Description of image  缩略图处理
 *
 * @author Administrator
 */
class Images {

    public function ChangeSize($file, $new_file, $width, $height) {
        $res = $this->loadImgRes($file);
        if ($res == false) {
            return false;
        }
        $originwidth = imagesx($res);
        $originheight = imagesy($res);

        $new_res = imagecreate($width, $height);
        if (imagecopyresampled($new_res, $res, 0, 0, 0, 0, $width, $height, $originwidth, $originheight)) {
            if ($this->saveImg($new_res, $new_file)) {
                imagedestroy($res);
                imagedestroy($new_res);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function Thumbnail($file, $new_file, $max_width, $max_height) {
        $res = $this->loadImgRes($file);
        $x = imagesx($res);
        $y = imagesy($res);
        if ($res == false) {
            return false;
        }
        if ($x > $max_width || $y > $max_height) {
            $x_scale = (int) ($x / $max_width);
            $y_scale = (int) ($y / $max_height);
            $scale = $x_scale > $y_scale ? $x_scale : $y_scale;
            $this->ChangeSize($file, $new_file, (int) ($x / $scale), (int) ($y / $scale));
        }
        return true;
    }

    private function loadImgRes(&$file) {
        if (!file_exists($file)) {
            return false;
        }
        switch (strtolower($this->getFileType($file))) {
            case "gif":
                if (function_exists("imagecreatefromgif")) {
                    return imagecreatefromgif($file);
                } else {
                    return false;
                }
            case "png":
                if (function_exists("imagecreatefrompng")) {
                    return imagecreatefrompng($file);
                } else {
                    return false;
                }
            case "jpeg":
                if (function_exists("imagecreatefromjpeg")) {
                    return imagecreatefromjpeg($file);
                } else {
                    return false;
                }
            case "jpg":
                if (function_exists("imagecreatefromjpeg")) {
                    return imagecreatefromjpeg($file);
                } else {
                    return false;
                }
            default:
                return false;
        }
    }

    private function saveImg(&$res, $newfile) {
        switch (strtolower($this->getFileType($newfile))) {
            case "gif":
                @imagegif($res, $newfile);
                return true;
            case "png":
                @imagepng($res, $newfile);
                return true;
            case "jpeg":
                @imagejpeg($res, $newfile);
                return true;
            case "jpg":
                @imagejpeg($res, $newfile);
                return true;
            default:
                return false;
        }
    }

    private function getFileType($name) {
        $arr = explode('.', $name);
        return $arr[count($arr) - 1];
    }

}

?>
