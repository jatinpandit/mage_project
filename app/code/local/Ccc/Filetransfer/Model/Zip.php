<?php
class Ccc_Filetransfer_Model_Zip extends ZipArchive
{
    public function extractFile($filename, $configId)
    {
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $filePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $filename;
        $extractTo = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . 'extracted' . DS . $basename;

        // Ensure the extraction directory exists and is writable
        if (!is_dir($extractTo)) {
            if (!mkdir($extractTo, 0777, true)) {
                Mage::log('Failed to create extraction directory: ' . $extractTo, null, 'filetransfer.log');
                return false;
            }
        }

        if (!is_writable($extractTo)) {
            Mage::log('Extraction directory is not writable: ' . $extractTo, null, 'filetransfer.log');
            return false;
        }

        // Try to open the zip file and handle potential errors
        if ($this->open($filePath) === TRUE) {
            // Extract the contents of the zip file
            if ($this->extractTo($extractTo) === FALSE) {
                Mage::log('Failed to extract the zip file to: ' . $extractTo, null, 'filetransfer.log');
                $this->close();
                return false;
            }
            $this->close();
        } else {
            Mage::log('Failed to open the zip file: ' . $filePath, null, 'filetransfer.log');
            return false;
        }

        // Process the extracted files
        $extractedFiles = glob($extractTo . DS . '*');
        if ($extractedFiles === false) {
            Mage::log('Failed to read extracted files from: ' . $extractTo, null, 'filetransfer.log');
            return false;
        }

        $fileModel = Mage::getModel('filetransfer/file');

        foreach ($extractedFiles as $file) {
            if (is_file($file)) {
                $newFile = pathinfo($file, PATHINFO_BASENAME);
                $date = date('Ymd-His', filemtime($file));
                $fileData = [
                    'config_id' => $configId,
                    'filename' => $basename . DS . $newFile,
                    'received_time' => $date,
                ];
                $fileModel->setData($fileData)->save();
            } else {
                Mage::log('Skipped non-file entry: ' . $file, null, 'filetransfer.log');
            }
        }

        return true;
    }
}
