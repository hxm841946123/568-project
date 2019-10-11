<?php
// function downfile($fileurl)
function downfile($stock)
{
    $API_KEY = "AI26M6MQXWPC1OQR";
    $url = "https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&datatype=csv&interval=1min&symbol=$stock&apikey=" . $API_KEY;
    $data = file_get_contents($url);
    $row = explode("\n", $data);
    $count = count($row) - 1;
    for($i = 0; $i < $count; $i++ )
    {
        $day[] = explode(",", $row[$i]);
    }
    $ofilename = "./real_data/$stock.csv";
    $fp = fopen($ofilename,'a');
    foreach ($day as $lines) {
        fputcsv($fp, $lines, ',', ',');
    }
    fclose($fp);

}

$stock = array("YAHOY", "GOOG", "MSFT", "FB", "CCF", "BIDU", "SINA", "VZ", "T", "ATVI");

foreach ($stock as $tmp) {
	downfile($tmp);
}
?>