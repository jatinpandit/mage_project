<?php

class Ccc_Vendorinventory_Model_Observer
{
    public function readCsv()
    {
        // echo 111;
        $brand = Mage::helper('vendorinventory')->getBrandNames();
        // print_r( $brand[key]);die;
        foreach ($brand as $key => $value) {
            $brandId = $key;
            $csvPath = Mage::getBaseDir('var') . '/inventory/' . $brandId . '/inventory.csv';

            $collection = Mage::getModel('vendorinventory/configuration_column')
                ->getCollection()
                ->addFieldtoFilter('configuration.brand_id', $brandId)
                ->join('configuration', 'main_table.brand_table_id=configuration.id');
            // echo $collection->getselect();
            $brandConfig = json_decode($collection->getFirstItem()->getBrandColumnConfiguration());
            // echo "<pre>";
            // print_r($brandConfig['sku'][0]);
            $file = fopen($csvPath, 'r');
            $headers = fgetcsv($file);
            // print_r($headers);
            $data = [];

            while ($row = fgetcsv($file)) {
                $model = Mage::getModel('vendorinventory/items');
                $data = array_combine($headers, $row);
                // print_r($data);
                $temp = [];
                foreach ($brandConfig as $_column => $_config) {
                    $dataColumn = '';
                    $temp[$_column] = null;
                    $rule = [];
                    foreach ($_config as $_c) {
                        // print_r($_c);
                        if (!is_string($_c)) {
                            foreach ($_c as $_k => $_v) {
                                $dataColumn = $_k;
                                if ($_column === 'sku') {
                                    $itemcollection = $model->getCollection()->addFieldtoFilter('sku', $data[$_k]);
                                    // var_dump($itemcollection->getFirst/Item());
                                    if ($itemcollection->getFirstItem()->getId()) {
                                        // echo 111;
                                        $model->load($itemcollection->getFirstItem()->getId());
                                    }
                                    $rule[] = true;
                                    break;
                                }

                                if ($_v->condition_value) {
                                    $rule[] = $this->checkRule(
                                        $data[$_k],
                                        $_v->condition_value,
                                        $_v->data_type,
                                        $_v->condition_operator
                                    );
                                } else {
                                    $rule[] = false;
                                }
                                // print_r($_v);
                            }
                        } else {
                            // echo 111;
                            switch ($_c) {
                                case "AND":
                                    $rule[] = "AND";
                                    break;
                                case "OR":
                                    $rule[] = "OR";
                                    break;
                            }
                        }
                    }
                    // print_r($temp);
                    // $temp['sku'] = $data[$headers[0]];
                    $result = false;
                    $logicalOperator = '';
                    foreach ($rule as $item) {
                        if ($item === "AND" || $item === "OR") {
                            $logicalOperator = $item;
                        } else {
                            if ($logicalOperator === "AND") {
                                $result = $result && $item;
                            } else {
                                $result = $result || $item;
                            }
                        }
                    }
                    if ($result)
                        $temp[$_column] = $data[$dataColumn];
                }
                // print_r($temp);
                $temp['brand_id'] = $brandId;
                $model->addData($temp)->save(); 
            }
        }
    }

    public function checkRule($dataValue, $condValue, $condDataType, $condOperator)
    {
        switch (strtolower($condDataType)) {
            case "count":
            case "number":
                // echo 1;
                return $this->compare((int) $dataValue, (int) $condValue, $condOperator);
            // break;
            case "text":
                // echo 1;
                return $this->compare(strtolower($dataValue), strtolower($condValue), $condOperator);
            case "date":
                $date1 = DateTime::createFromFormat('d-m-Y', $dataValue);
                $date2 = DateTime::createFromFormat('d/m/Y', $condValue);
                return $this->compare($date1, $date2, $condOperator);
        }
    }

    public function compare($value1, $value2, $operator)
    {
        switch ($operator) {
            case "=":
                return $value1 == $value2;
            case "!=":
                return $value1 != $value2;
            case "<=":
                return $value1 <= $value2;
            case ">=":
                return $value1 >= $value2;
            case ">":
                // echo 2;
                return $value1 > $value2;
            case "<":
                return $value1 < $value2;
        }
    }
}