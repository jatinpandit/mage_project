<?php
class Ccc_Filetransfer_Model_Zip extends ZipArchive
{
    public function extractFile($filename, $configId)
    {
        $filename = str_replace('_','/',$filename);
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $filePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $filename;
        // echo $filename;die;
        $extractTo = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . 'extracted' . DS . $basename;

        if ($this->open($filePath)) {
            $this->extractTo($extractTo);
        }
        $extractedFiles = glob($extractTo.DS.'*');
        $fileModel = Mage::getModel('filetransfer/file');
        
        foreach ($extractedFiles as $file) {
            $newFile = pathinfo($file, PATHINFO_BASENAME);
            $date = date('Y-m-d H:i:s', filemtime($extractTo . DS . $newFile));
            // echo $date;die;
            $fileData = [
                'config_id'=>$configId,
                'file_name' => DS.'extracted'.DS.$basename.DS.$newFile,
                'modified_date' => $date,
            ];
            // print_r($fileData);die;
            $fileModel->setData($fileData)->save();
        }
    }
}
