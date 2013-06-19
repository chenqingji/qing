<?php

/**
 * qing项目所有上传后台控制类
 * @author jm
 */
class UploadController extends SysController {

        /**
         * pay功能文件上传处理
         */
        public function payUpload() {
                session_start();

                $fileUploader = new FileUploader();
                $fileInfo = $fileUploader
                        ->setDir(Constants::UPLOAD_DIR_PAY,"{y}/{m}/{d}/")
                        ->setThumb(200)
//                        ->setWaterMark(yii::getPathOfAlias('common.images')."/9logo.jpg")
                        ->setPrefixFilename(Constants::PREFIX_NAME_FOR_PAY_UPLOAD_FILE)
                        ->upload();
//                file_put_contents('/tmp/upload.txt', print_r($fileInfo, true),FILE_APPEND);
                echo json_encode(array_shift($fileInfo));
                session_write_close();
        }

        /**
         * 
         */
}

?>
