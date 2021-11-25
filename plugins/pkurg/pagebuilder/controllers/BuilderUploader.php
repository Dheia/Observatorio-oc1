<?php namespace Pkurg\PageBuilder\Controllers;

use Backend\Classes\Controller;
use Config;
use Input;
use Pkurg\PageBuilder\Models\Settings;
use Response;
use Storage;

class BuilderUploader extends Controller
{
    public $implement = [];

    public function __construct()
    {
        parent::__construct();
    }

    

    public function uploadFiles()
    {

        $input = Input::all();

        $file = Input::file('file');

        if (Settings::get('savelocal')) {

            if ($_FILES) {
                $resultArray = array();
                foreach ($_FILES as $file) {
                    $fileName = $file['name'];
                    $tmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileType = $file['type'];
                    if ($file['error'] != UPLOAD_ERR_OK) {
                        error_log($file['error']);
                        echo JSON_encode(null);
                    }
                    $fp = fopen($tmpName, 'r');
                    $content = fread($fp, filesize($tmpName));

                    $q = uniqid();


                    $fileName = preg_replace('/[^A-Za-z0-9 _ .-]/', '', $fileName);

                    $filePath = '/media/BuilderUploader/' . $q . $fileName;
                    Storage::put($filePath, $content);

                    $Url = url(Config::get('cms.storage.media.path')) . '/BuilderUploader/' . $q . $fileName;

                    fclose($fp);
                    $result = array(
                        'name' => $file['name'],
                        'type' => 'image',
                        'src' => $Url,
                        'height' => 350,
                        'width' => 250,
                    );
                    // we can also add code to save images in database here.
                    array_push($resultArray, $result);
                }
                $response = array('data' => $resultArray);
                //echo json_encode($response);
                return Response::json($response);
            }

        } else {

            if ($_FILES) {
                $resultArray = array();
                foreach ($_FILES as $file) {
                    $fileName = $file['name'];
                    $tmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileType = $file['type'];
                    if ($file['error'] != UPLOAD_ERR_OK) {
                        error_log($file['error']);
                        echo JSON_encode(null);
                    }
                    $fp = fopen($tmpName, 'r');
                    $content = fread($fp, filesize($tmpName));
                    fclose($fp);
                    $result = array(
                        'name' => $file['name'],
                        'type' => 'image',
                        'src' => "data:" . $fileType . ";base64," . base64_encode($content),
                        'height' => 350,
                        'width' => 250,
                    );
                    // we can also add code to save images in database here.
                    array_push($resultArray, $result);
                }
                $response = array('data' => $resultArray);
                //echo json_encode($response);
                return Response::json($response);
            }

        }

    }

}
