<?php
namespace App\Http\Controllers;

class DownloadController extends Controller
{

    /**
     * Download file
     *
     * @param string $fileName
     * @return json
     * @author vduong daiduongptit090@gmail.com
     */
    public function download ($fileName, $isRead = false)
    {
        if (!$fileName) {
            return;
        }
        if (!file_exists(public_path('images/product/' . $fileName))) {
            return;
        }

        $fileName = basename(public_path('images/product/' . $fileName));
        $fileSize = filesize(public_path('images/product/' . $fileName));

        // Output headers.
        if (!$isRead) {
            header("Cache-Control: private");
            header("Content-Type: application/stream");
            header("Content-Length: ".$fileSize);
            header("Content-Disposition: attachment; filename=".$fileName);
            readfile (public_path('images/product/' . $fileName));
        } else {
            header("Content-type: application/pdf");
            readfile (public_path('images/product/' . $fileName));
        }
    }
}
