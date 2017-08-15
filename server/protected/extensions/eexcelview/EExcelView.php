<?php

Yii::import('zii.widgets.grid.CGridView');

/**
 * @author Nikola Kostadinov
 * @license MIT License
 * @version 0.3
 */
class EExcelView extends CGridView {

    //Document properties
    public $creator = 'NamNT';
    public $title = null;
    public $subject = 'Subject';
    public $description = '';
    public $category = '';
    //the PHPExcel object
    public $objPHPExcel = null;
    public $libPath = 'ext.phpexcel.Classes.PHPExcel'; //the path to the PHP excel lib
    //config
    public $autoWidth = true;
    public $exportType = 'Excel5';
    public $disablePaging = true;
    public $filename = null; //export FileName
    public $stream = true; //stream to browser
    public $grid_mode = 'grid'; //Whether to display grid ot export it to selected format. Possible values(grid, export)
    public $grid_mode_var = 'grid_mode'; //GET var for the grid mode
    //buttons config
    public $exportButtonsCSS = 'summary';
    public $exportButtons = array('Excel2007');
    public $exportText = 'Export to: ';
    //callbacks
    public $onRenderHeaderCell = null;
    public $onRenderDataCell = null;
    public $onRenderFooterCell = null;
    //mime types used for streaming
    public $mimeTypes = array(
        'Excel5' => array(
            'Content-type' => 'application/vnd.ms-excel',
            'extension' => 'xls',
            'caption' => 'Excel(*.xls)',
        ),
        'Excel2007' => array(
            'Content-type' => 'application/vnd.ms-excel',
            'extension' => 'xlsx',
            'caption' => 'Excel(*.xlsx)',
        ),
        'PDF' => array(
            'Content-type' => 'application/pdf',
            'extension' => 'pdf',
            'caption' => 'PDF(*.pdf)',
        ),
        'HTML' => array(
            'Content-type' => 'text/html',
            'extension' => 'html',
            'caption' => 'HTML(*.html)',
        ),
        'CSV' => array(
            'Content-type' => 'application/csv',
            'extension' => 'csv',
            'caption' => 'CSV(*.csv)',
        )
    );

    public function init() {
        if (isset($_GET[$this->grid_mode_var]))
            $this->grid_mode = $_GET[$this->grid_mode_var];
        if (isset($_GET['exportType']))
            $this->exportType = $_GET['exportType'];

        $lib = Yii::getPathOfAlias($this->libPath) . '.php';

        if ($this->grid_mode == 'export' and ! file_exists($lib)) {
            $this->grid_mode = 'grid';
            Yii::log("PHP Excel lib not found($lib). Export disabled !", CLogger::LEVEL_WARNING, 'EExcelview');
        }

        if ($this->grid_mode == 'export') {
            $this->title = $this->title ? $this->title : Yii::app()->getController()->getPageTitle();
            $this->initColumns();
            //parent::init();
            //Autoload fix
            
            spl_autoload_unregister(array('YiiBase', 'autoload'));
            Yii::import($this->libPath, true);

            $rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF;
            $rendererLibraryPath = Yii::getPathOfAlias('ext.tcpdf');

            PHPExcel_Settings::setPdfRenderer(
                $rendererName,
                $rendererLibraryPath
            );

            $this->objPHPExcel = new PHPExcel();

            spl_autoload_register(array('YiiBase', 'autoload'));
            
            $this->objPHPExcel->setActiveSheetIndex(0);
            $this->objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
            $this->objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $this->objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
            $this->objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
            $this->objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
            
            // Creating a workbook
            $this->objPHPExcel->getProperties()->setCreator($this->creator);
            $this->objPHPExcel->getProperties()->setTitle($this->title);
            $this->objPHPExcel->getProperties()->setSubject($this->subject);
            $this->objPHPExcel->getProperties()->setDescription($this->description);
            $this->objPHPExcel->getProperties()->setCategory($this->category);
        } else
            parent::init();
    }

    public function renderHeader() {
        $a = 0;
        foreach ($this->columns as $column) {
            $a = $a + 1;
            if ($column instanceof CButtonColumn)
                $head = $column->header;
            elseif ($column->header === null && $column->name !== null) {
                if(strpos($column->name, CustomEnum::COLUMN_IMG) !== false){
                    $head = CustomHelper::convertColumnImgHead($column);
                }
                elseif ($column->grid->dataProvider instanceof CActiveDataProvider)
                    $head = $column->grid->dataProvider->model->getAttributeLabel($column->name);
                else
                    $head = $column->name;
            } else
                $head = trim($column->header) !== '' ? $column->header : $column->grid->blankDisplay;

            $cell = $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnName($a) . "1", $head, true);
            if (is_callable($this->onRenderHeaderCell))
                call_user_func_array($this->onRenderHeaderCell, array($cell, $head));
        }
    }

    public function renderBody() {
        if ($this->disablePaging) //if needed disable paging to export all data
            $this->dataProvider->pagination = false;

        $data = $this->dataProvider->getData();
        $n = count($data);

        if ($n > 0) {
            for ($row = 0; $row < $n;  ++$row)
                $this->renderRow($row);
        }
        return $n;
    }

    public function renderRow($row) {
        $data = $this->dataProvider->getData();

        $a = 0;
        foreach ($this->columns as $n => $column) {
            $a++;
            if ($column instanceof CLinkColumn) {
                if ($column->labelExpression !== null){
                    $value = $column->evaluateExpression($column->labelExpression, array('data' => $data[$row], 'row' => $row));
                }
                else{
                    $value = $column->label;
                }
            } elseif ($column instanceof CButtonColumn)
                $value = ""; //Dont know what to do with buttons
            elseif ($column->value !== null)
                $value = $this->evaluateExpression($column->value, array('data' => $data[$row]));
            elseif ($column->name !== null) {
                $srcArr = explode("image||", CHtml::value($data[$row], $column->name));
                $src = isset($srcArr[1]) ? $srcArr[1] : "";
                $imgFile = strpos($column->name, CustomEnum::COLUMN_IMG);
                if ($column->name == '_no') {
                    $value = $row + 1;
                }
                elseif($column->name == 'mounting'){
                    $signageNew = new Signage();
                    $signageNew->mounting = $data[$row][$column->name];
                    $value = $signageNew->getMountingLabel();
                }
                //image show
                elseif($src){
                    $objDrawingPType = new PHPExcel_Worksheet_Drawing();
                    $objDrawingPType->setWorksheet($this->objPHPExcel->setActiveSheetIndex(0));
    //                $objDrawingPType->setName("Pareto By Type");
                    $objDrawingPType->setPath($src);
                    $objDrawingPType->setCoordinates($this->columnName($a) . ($row + 2));
                    $objDrawingPType->setWidth(60);
                    $objDrawingPType->setHeight(60);
                    $objDrawingPType->setResizeProportional(true);
                    $this->objPHPExcel->getActiveSheet()->getColumnDimension($this->columnName($a))->setAutoSize(true);
                    $this->objPHPExcel->getActiveSheet()->getRowDimension(($row + 2))->setRowHeight(60);
//                    $objDrawingPType->setOffsetX(1);
//                    $objDrawingPType->setOffsetY(5);
                    $value = "";
                }
                elseif($imgFile !== false){
                    $attribute = CustomHelper::getColumnImgAttribute($column);
                    if(CHtml::value($data[$row], $attribute) != CustomEnum::IMAGE_NO_FILE){
                        $file = File::model()->findByPk(CHtml::value($data[$row], $attribute));
                        $imgSrc = $file && $file->getThumbUrl(80, 80, false)
                                ? CustomEnum::FILE_SERVER_PATH.$file->getThumbUrl(80, 80, false)
                                : CustomEnum::FILE_SERVER_PATH.CustomEnum::IMAGE_NOT_AVAILABLE;
                        $objDrawingPType = new PHPExcel_Worksheet_Drawing();
                        $objDrawingPType->setWorksheet($this->objPHPExcel->setActiveSheetIndex(0));
                        $objDrawingPType->setPath($imgSrc);
                        $objDrawingPType->setCoordinates($this->columnName($a) . ($row + 2));
                        $objDrawingPType->setWidth(60);
                        $objDrawingPType->setHeight(60);
    //                    $objDrawingPType->setWidthAndHeight(65, 240);
                        $objDrawingPType->setResizeProportional(true);
                        $this->objPHPExcel->getActiveSheet()->getColumnDimension($this->columnName($a))->setAutoSize(true);
    //                    $this->objPHPExcel->getActiveSheet()->getColumnDimension($this->columnName($a))->setWidth(-1);
                        $this->objPHPExcel->getActiveSheet()->getRowDimension(($row + 2))->setRowHeight(60);
                    }
                    $value = "";
                }
                else {
                    //$value=$data[$row][$column->name];
                    $value = CHtml::value($data[$row], $column->name);
                    $value = $value === null ? "" : $column->grid->getFormatter()->format($value, 'raw');
                }
            }

            $cell = $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnName($a) . ($row + 2), strip_tags($value), true);
            if (is_callable($this->onRenderDataCell))
                call_user_func_array($this->onRenderDataCell, array($cell, $data[$row], $value));
            
        }
    }

    public function renderFooter($row) {
        $a = 0;
        foreach ($this->columns as $n => $column) {
            $a = $a + 1;
            if ($column->footer) {
                $footer = trim($column->footer) !== '' ? $column->footer : $column->grid->blankDisplay;

                $cell = $this->objPHPExcel->getActiveSheet()->setCellValue($this->columnName($a) . ($row + 2), $footer, true);
                if (is_callable($this->onRenderFooterCell))
                    call_user_func_array($this->onRenderFooterCell, array($cell, $footer));
            }
        }
    }

    public function run() {
        if ($this->grid_mode == 'export') {
            if($this->exportType == 'PDF'){
                $html = $this->renderContent(); 
                // Create 
                $external_css = '<style type="text/css">@page { margin: 20px !important;} html { width: 100%; max-width: 100%} body { margin: 20px !important; max-width: 100%} table {border-collapse: collapse; border: 1px solid #DFDFDF; width: 100% !important; } td {border-collapse: collapse !important; ; border: 1px solid #DFDFDF !important; word-break:break-all; width: auto !important; }</style>';
                $html = $external_css . $html;
                $html = str_replace('id="sheet0"', '', $html);
                $file = Yii::getPathOfAlias('webroot') . '/data/export/' . $this->filename . '.'.$this->mimeTypes[$this->exportType]['extension'];
                return iPhoenixUrl::exportPdfFromHTML($html, $file, "landscape", true);
            }
            else{
                $columnsTmp = $this->columns;
                if(isset($columnsTmp[0]) && $columnsTmp[0]->name == 'a'){
                    
                }
                else{
                    $this->renderHeader();
                }
                $row = $this->renderBody();
                $this->renderFooter($row);

                //set auto width
                if ($this->autoWidth)
                    foreach ($this->columns as $n => $column)
                        $this->objPHPExcel->getActiveSheet()->getColumnDimension($this->columnName($n + 1))->setAutoSize(true);
                //create writer for saving
                $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, $this->exportType);
                if (!$this->stream) {
//                    if($this->exportType == 'PDF'){
//                        $html = $this->renderContent(); 
//                        // Create 
//                        $external_css = '<style type="text/css">@page { margin: 20px !important;} html { width: 100%; max-width: 100%} body { margin: 20px !important; max-width: 100%} table {border-collapse: collapse; border: 1px solid #DFDFDF; width: 100% !important; } td {border-collapse: collapse !important; ; border: 1px solid #DFDFDF !important; word-break:break-all; width: auto !important; }</style>';
//                        $html = $external_css . $html;
//                        $html = str_replace('id="sheet0"', '', $html);
//                        $file = Yii::getPathOfAlias('webroot') . '/data/export/' . $this->filename . '.'.$this->mimeTypes[$this->exportType]['extension'];
//                        return iPhoenixUrl::exportPdfFromHTML($html, $file, "landscape", true);
//                    }else{
                        $file = Yii::getPathOfAlias('webroot') . '/data/export/' . $this->filename . '.'.$this->mimeTypes[$this->exportType]['extension'];
                        $objWriter->save($file);
//                    }
                } else { //output to browser
                    if (!$this->filename)
                        $this->filename = $this->title;
                    $this->cleanOutput();
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Content-type: ' . $this->mimeTypes[$this->exportType]['Content-type']);
                    header('Content-Disposition: attachment; filename="' . $this->filename . '.' . $this->mimeTypes[$this->exportType]['extension'] . '"');
                    header('Cache-Control: max-age=0');
                    $objWriter->save('php://output');
                    Yii::app()->end();
                }
            }
        } else
            parent::run();
    }

    /**
     * Returns the coresponding excel column.(Abdul Rehman from yii forum)
     * 
     * @param int $index
     * @return string
     */
    public function columnName($index) {
        --$index;
        if ($index >= 0 && $index < 26)
            return chr(ord('A') + $index);
        else if ($index > 25)
            return ($this->columnName($index / 26)) . ($this->columnName($index % 26 + 1));
        else
            throw new Exception("Invalid Column # " . ($index + 1));
    }

    public function renderExportButtons() {
        foreach ($this->exportButtons as $key => $button) {
            $item = is_array($button) ? CMap::mergeArray($this->mimeTypes[$key], $button) : $this->mimeTypes[$button];
            $type = is_array($button) ? $key : $button;
            $url = parse_url(Yii::app()->request->requestUri);
            //$content[] = CHtml::link($item['caption'], '?'.$url['query'].'exportType='.$type.'&'.$this->grid_mode_var.'=export');
            if (key_exists('query', $url))
                $content[] = CHtml::link($item['caption'], '?' . $url['query'] . '&exportType=' . $type . '&' . $this->grid_mode_var . '=export');
            else
                $content[] = CHtml::link($item['caption'], '?exportType=' . $type . '&' . $this->grid_mode_var . '=export');
        }
        if ($content)
            echo CHtml::tag('div', array('class' => $this->exportButtonsCSS), $this->exportText . implode(', ', $content));
    }

    /**
     * Performs cleaning on mutliple levels.
     * 
     * From le_top @ yiiframework.com
     * 
     */
    private static function cleanOutput() {
        for ($level = ob_get_level(); $level > 0;  --$level) {
            @ob_end_clean();
        }
    }

    /**
     * Renders the data items for the grid view.
     */
    public function renderContent()
    {
        ob_start();
        if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
        {
            echo "<table class=\"{$this->itemsCssClass}\">\n";
            $this->renderTableHeader();
            $this->renderTableBody();
            $this->renderTableFooter();
            echo "</table>";
        }
        else
            $this->renderEmptyText();
        
        return ob_get_clean();
    }
}
