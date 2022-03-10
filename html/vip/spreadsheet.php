<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 03.01.2020
 * Time: 15:04
 */

require_once(__DIR__."/../../classes/PhpSpreadsheet/vendor/autoload.php");
require_once __DIR__."/../conf/config.inc";
require_once SYSTEMINCLUDES."authenticateUser.php";
overUzivatele($pristup_zakazan);

$doc = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $doc->getActiveSheet();
$doc->getProperties()
    ->setCreator($_SESSION['jmeno'])
    ->setLastModifiedBy($_SESSION['jmeno'])
    ->setTitle("Výpis projektů")
    ->setDescription("Výpis projektů vytvořených v aplikaci ADMISS");
$doc->setActiveSheetIndex(0);
$sheet->getPageSetup()->setFitToWidth(1);
$sheet->getPageSetup()->setFitToHeight(1);
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($doc);
\PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder() );
$headerContetnt = ['Název stavby',
    'Předmět stavby',
    'Okresy',
    'Zodpovědný technik za KSÚS',
    'Celkové náklady s DPH (stavba + TDS a BOZP) předpoklady červeně',
    'Zhotovitel stavby','Firma TDS + BOZP',
    'Autorský dozor',
    'Staveniště předáno (nebo stav podkladů a soutěže)',
    'Dokončení',
    'Datum vydání stavebního povolení',
    'Zdroj financování',
    'Staničení dle CLEVERy'];
$sheet->fromArray($headerContetnt,null,'A1');

$styleArrayFirstRow = [
    'font' => [
        'bold' => true,
    ],
    'borders' => [
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'FFEB3B',
        ],
    ],
];

$stylePrePrices = [
    'font' => [
        'color' =>[
            'rgb' => 'E8403C',
        ],
    ]
];


$styleDate = [
    'numberFormat' => [
        'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY
    ]
];

$styleVerticalAlign = [
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ]
];

$sheet->getStyle('A1:'.$sheet->getHighestColumn()."1")->applyFromArray($styleArrayFirstRow);

$headerCollums = $sheet->rangeToArray('A1:' . $sheet->getHighestColumn(). $sheet->getHighestRow());

foreach ($sheet->getColumnIterator('A',$sheet->getHighestColumn()) as $column){
    $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
}


$projects = getFilteredProjects($_GET,10000,1);


$content = array();
$prePriceRows = array();
$line = 1;
foreach ($projects as $idProject){

    $line++;
    $project = new Project($idProject['idProject']);
    $priceContrustion = NULL;
    if($project->baseInformation['idPhase'] > 3){
        $priceContrustion = $project->getPricesByType(6)->getValueWithTax() + $project->getPricesByType(8)->getValueWithTax();
        array_push($prePriceRows, $line);
    }else if($project->baseInformation['idPhase'] == 3){
        $priceContrustion = $project->getPricesByType(11)->getValueWithTax() + $project->getPricesByType(12)->getValueWithTax();
    }else if($project->baseInformation['idPhase'] < 3){
        $priceContrustion = $project->getPricesByType(5)->getValueWithTax() + $project->getPricesByType(7)->getValueWithTax();
    }
    $deadline = $project->getDeadlineByType(12);
    $constructionHandover = ($deadline['value'] == null) ? null : date("d-m-Y", strtotime($deadline['value']));
    $deadline = $project->getDeadlineByType(10);
    $constructionPermit = ($deadline['value'] == null) ? null : date("d-m-Y", strtotime($deadline['value']));
    $row = array(
        $project->baseInformation['name'],
        unicodeToUtf8(htmlspecialchars_decode(strip_tags($project->baseInformation['subject']))),
        join("\n",array_map(function($area){return $area['name'];},$project->getArea())),
        $project->getEditor(),
        $priceContrustion,
        $project->getCompanyByType(2)['name'],
        $project->getCompanyByType(3)['name'],
        $project->getCompanyByType(1)['name'],
        $constructionHandover,
        null,
        $constructionPermit,
        $project->getFinSource(),
        join("\n",array_map(function($communication){return ($communication['idCommunicationType'] != 3 )?$communication['name']. " - km ".$communication['stationingFrom']." - ".$communication['stationingTo']:$communication['name']." - ".$communication['comment'];},
        $project->getCommunication()))
        );
    array_push($content, $row);


}
foreach ($prePriceRows as $styledRow){
    $sheet->getStyle('E'.$styledRow)->applyFromArray($stylePrePrices);
}

$sheet->fromArray($content,null,'A2');


for($i = 1; $i <= $sheet->getHighestRow(); $i++){
    $sheet->getStyle('I'.$i)->applyFromArray($styleDate);
    $sheet->getStyle('K'.$i)->applyFromArray($styleDate);
}


foreach ($sheet->getRowIterator() as $row) {
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(FALSE);
    foreach ($cellIterator as $cell) {
        $cell->getStyle()->applyFromArray($styleVerticalAlign);
    }
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="file.xlsx"');
$writer->save("php://output");

