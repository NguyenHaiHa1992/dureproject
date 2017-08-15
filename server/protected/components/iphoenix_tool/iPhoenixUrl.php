<?php
class iPhoenixUrl
{
    static function createUrl($route,$params=array(),$ampersand='&')
    {
        if (isset($_GET['iphoenix_language'])) {
            $params['iphoenix_language']=$_GET['iphoenix_language'];
        }
        return Yii::app()->createUrl($route, $params, $ampersand);
    }

	static function exportPdf($url, $filename){
		if(!defined("DOMPDF_ENABLE_REMOTE")){
            define("DOMPDF_ENABLE_REMOTE", true);
        }

		$html = file_get_contents($url);
		// unregister Yii's autoloader
		spl_autoload_unregister(array('YiiBase', 'autoload'));
		// register dompdf's autoloader
		require_once(Yii::app()->basePath."/extensions/dompdf/dompdf_config.inc.php");
		// register Yii's autoloader again
		spl_autoload_register(array('YiiBase', 'autoload'));
		$dompdf = new DOMPDF();
		$dompdf->set_paper(array(0, 0, 595, 841), 'portrait');
		$dompdf->load_html($html);
		$dompdf->render();
		$output = $dompdf->output();

		$quote_file_name = str_replace(" ", "_", $filename);
		if(file_exists("data/pdf/{$quote_file_name}.pdf")) {
			unlink("data/pdf/{$quote_file_name}.pdf");
		}
		file_put_contents("data/pdf/{$quote_file_name}.pdf", $output);
	}

	static function exportPdfFromHTML($html, $filename, $option = 'portrait', $absolute_path = false){
		if(!defined("DOMPDF_ENABLE_REMOTE")){
                    define("DOMPDF_ENABLE_REMOTE", true);
                }

		// unregister Yii's autoloader
		spl_autoload_unregister(array('YiiBase', 'autoload'));
		// register dompdf's autoloader
		require_once(Yii::app()->basePath."/extensions/dompdf/dompdf_config.inc.php");
		// register Yii's autoloader again
		spl_autoload_register(array('YiiBase', 'autoload'));
		$dompdf = new DOMPDF();
		$dompdf->set_paper(array(0, 0, 595, 841), $option);
		$dompdf->load_html($html);
		$dompdf->render();
		$output = $dompdf->output();

		$quote_file_name = str_replace(" ", "_", $filename);
                
                if($absolute_path){
                    $file_path = $quote_file_name;
                }
                else{
                    $file_path = "data/pdf/{$quote_file_name}.pdf";
                }
                
		if(file_exists($file_path)) {
                    unlink($file_path);
		}
		file_put_contents($file_path, $output);
	}
}
?>