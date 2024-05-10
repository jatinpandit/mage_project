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
            echo "<pre>";
            // print_r($brandConfig);
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
                        if (!is_string($_c)) {
                            foreach ($_c as $_k => $_v) {
                                // print_r($_k);
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

                                // print_r($_v->condition_value);
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
                    $val = 0;
                    if ($result) {
                        // print_r($_column);
                        switch ($_column) {
                            case 'sku':
                            case 'restock_date':
                            case 'instock_qty':
                            case 'restock_qty':
                                $val = $data[$dataColumn];
                                break;
                            case 'instock':
                            case 'status':
                            case 'discontinued':
                                $val = 1;
                                break;


                        }
                    }
                    $temp[$_column] = $val;
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

    public function instockCheck()
    {
        $collection = Mage::getModel('vendorinventory/items')->getCollection()->getItems();
        foreach ($collection as $c) {
            $model = Mage::getModel('catalog/product')->getCollection()->addFieldtoFilter('sku', $c->getSku())->getFirstItem();
            if ($c->getInstock() == 1) {
                $instockDate = date('d/m/Y');
            } elseif ($c->getRestockDate() != 0) {
                echo "<pre>";
                $instockDate = DateTime::createFromFormat('d-m-Y', $c->getRestockDate())->format('d/m/Y');
                var_dump($c->getSku());
                print_r($instockDate);
            } else {
                $instockDate = null;
            }
            $model->addAttributeUpdate('instock_date', $instockDate);
        }
    }

}