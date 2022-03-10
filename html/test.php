<?php
/**
 * Created by PhpStorm.
 * User: ondrac
 * Date: 25.07.2018
 * Time: 10:44
 */
require_once __DIR__."/conf/config.inc";
require_once SYSTEMINCLUDES."function.php";
require_once SYSTEMINCLUDES."authenticateUser.php";
require_once SYSTEMINCLUDES . "autoLoader.php";
overUzivatele($pristup_zakazan);


//insertPrice(2,4,500);
//insertPrice(2,4,1500);
//insertPrice(2,4);
//$json = "{\"idProject\":\"7\",\"idProjectType\":\"1\",\"idProjectSubtype\":\"11\",\"created\":\"2020-01-23 09:51:08\",\"name\":\"pokus s objektem\",\"subject\":\"<p>aaa<\/p>\",\"editor\":\"phamson1\",\"author\":\"phamson1\",\"idFinSource\":\"1\",\"idPhase\":\"2\",\"idLocalProject\":\"142\",\"ginisOrAthena\":\"g\",\"noteGinisOrAthena\":\"GINIS CISLO\",\"deletedDate\":null,\"deleteAuthor\":null,\"inConcept\":\"0\",\"dateEvidence\":\"1\",\"deadlineDurUrRequired\":\"0\",\"deadlineEIARequired\":\"0\",\"deadlineStudyRequired\":\"0\",\"mergedDeadlines\":\"0\",\"constructionTime\":\"89\",\"mergePricePDAD\":\"0\",\"projectTypeName\":\"Novostavba \",\"projectSubtypeName\":\"Silnice s mostem\",\"phaseName\":\"V realizaci\",\"editorName\":\"Son Tung Pham\",\"idArea\":[{\"idArea\":\"6\",\"name\":\"Rakovn\u00edk\"},{\"idArea\":\"10\",\"name\":\"P\u0159\u00edbram\"}],\"company\":[{\"idProject\":\"7\",\"idCompany\":\"2\",\"idCompanyType\":\"1\"},{\"idProject\":\"7\",\"idCompany\":\"2\",\"idCompanyType\":\"2\"},{\"idProject\":\"7\",\"idCompany\":\"2\",\"idCompanyType\":\"3\"}],\"communication\":[{\"idCommunication\":\"4\",\"name\":\"104\",\"stationingFrom\":\"10.000\",\"stationingTo\":\"12.000\",\"gpsN1\":\"49.957214355469\",\"gpsN2\":\"50.041072845459\",\"gpsE1\":\"14.364341735840\",\"gpsE2\":\"14.581321716309\",\"idCommunicationType\":\"1\",\"comment\":\"\"}],\"assignments\":\"<p>Projekt nem&aacute; p\u0159i\u0159azen&yacute; \u017e&aacute;dn&yacute; &uacute;kol<\/p>\",\"price\":[{\"idPriceType\":\"1\",\"value\":\"22\",\"name\":\"Skute\u010dn\u00e1 cena AD\"},{\"idPriceType\":\"2\",\"value\":\"11\",\"name\":\"Skute\u010dn\u00e1 cena PD (zahrnuto i I\u010c)\"},{\"idPriceType\":\"3\",\"value\":\"200\",\"name\":\"P\u0159edpokl\u00e1dan\u00e1 cena AD\"},{\"idPriceType\":\"4\",\"value\":\"100\",\"name\":\"P\u0159edpokl\u00e1dan\u00e1 cena PD (zahrnuto i I\u010c) \"},{\"idPriceType\":\"5\",\"value\":\"578\",\"name\":\"Skute\u010dn\u00e1 cena stavby dle smlouvy\"},{\"idPriceType\":\"6\",\"value\":\"300\",\"name\":\"P\u0159edpokl\u00e1dan\u00e1 cena stavby\"},{\"idPriceType\":\"7\",\"value\":\"879\",\"name\":\"Skute\u010dn\u00e1 cena TDS a BOZP\"},{\"idPriceType\":\"8\",\"value\":\"400\",\"name\":\"P\u0159edpokl\u00e1dan\u00e1 cena TDS a BOZP\"},{\"idPriceType\":\"11\",\"value\":\"22\",\"name\":\"Cena stavby dle PD\"},{\"idPriceType\":\"12\",\"value\":\"33\",\"name\":\"Cena TDS a BOZP odhad\"}],\"deadlines\":[{\"idProject\":\"7\",\"idDeadlineType\":\"5\",\"value\":\"2020-02-22 00:00:00\"},{\"idProject\":\"7\",\"idDeadlineType\":\"6\",\"value\":\"2020-02-22 00:00:00\"},{\"idProject\":\"7\",\"idDeadlineType\":\"7\",\"value\":\"2020-02-22 00:00:00\"},{\"idProject\":\"7\",\"idDeadlineType\":\"10\",\"value\":\"2020-02-22 00:00:00\"},{\"idProject\":\"7\",\"idDeadlineType\":\"11\",\"value\":\"2020-02-22 00:00:00\"},{\"idProject\":\"7\",\"idDeadlineType\":\"12\",\"value\":\"2020-02-22 00:00:00\"},{\"idProject\":\"7\",\"idDeadlineType\":\"13\",\"value\":\"2020-02-22 00:00:00\"}],\"contacts\":[{\"idProject\":\"7\",\"idContact\":\"148\",\"idContactType\":\"1\"},{\"idProject\":\"7\",\"idContact\":\"147\",\"idContactType\":\"2\"},{\"idProject\":\"7\",\"idContact\":\"122\",\"idContactType\":\"3\"},{\"idProject\":\"7\",\"idContact\":\"147\",\"idContactType\":\"4\"},{\"idProject\":\"7\",\"idContact\":\"147\",\"idContactType\":\"5\"},{\"idProject\":\"7\",\"idContact\":\"148\",\"idContactType\":\"6\"},{\"idProject\":\"7\",\"idContact\":\"122\",\"idContactType\":\"9\"},{\"idProject\":\"7\",\"idContact\":\"147\",\"idContactType\":\"10\"},{\"idProject\":\"7\",\"idContact\":\"148\",\"idContactType\":\"11\"}],\"relations\":[{\"idRelationType\":\"1\",\"idProjectRelation\":[\"10\"]}],\"objects\":[{\"idObject\":\"183\",\"idObjectType\":\"1\",\"idProject\":\"7\",\"name\":\"100\",\"attribute\":[{\"idAttributeType\":\"1\",\"value\":\"5000\"},{\"idAttributeType\":\"2\",\"value\":\"656\"},{\"idAttributeType\":\"3\",\"value\":\"767\"}]},{\"idObject\":\"184\",\"idObjectType\":\"1\",\"idProject\":\"7\",\"name\":\"200\",\"attribute\":[{\"idAttributeType\":\"1\",\"value\":\"10000\"},{\"idAttributeType\":\"2\",\"value\":\"565\"},{\"idAttributeType\":\"3\",\"value\":\"989\"}]}],\"suspensions\":[]}";
//$phpArr= json_decode($json);
//print_r(Project::insertProject($phpArr));

echo updateContactPhone(460, "777666555");
//$hashToken = generateHash(date('H'));
//echo "/vip/download.php?preview=TRUE&idDocumentLocal=22&token=$hashToken";
//echo (previewFile(22));
//$project = new Project(4);
//print_r($project->dumpProject());
//print_r($project->getRelations());
//insertActionLog(3,2);
//print_r($_SESSION['teammates']);
/*function create_preview ( $file ) {
    $output_format = "jpeg";
    $preview_page = "1";
    $resolution = "300";
    $output_file = "imagick_preview.jpg";

    echo "Fetching preview...\n";
    $img_data = new Imagick();
    $img_data->setResolution( $resolution, $resolution );
    $img_data->readImage( $file . "[" . ($preview_page - 1) . "]" );
    $img_data->setImageFormat( $output_format );

    file_put_contents( $output_file, $img_data, FILE_USE_INCLUDE_PATH );
}*/


//print_r(setTeammate('milan.peska', '2019-07-05'));
//create_preview("test.pdf");
//restoreFileVersion(2);
//echo restoreProject(20);
//getFilesVersionTable(11);
//echo deleteFile(7);
/*if(isset($_POST['submit'])){
   // echo sys_get_temp_dir();

    print_r(newFileUpload($_FILES, 9,1,'testuju manual'));
}*/
//print_r(getDashboardStats());
//echo $_SERVER['REQUEST_URI'];
//print_r($_SESSION);
// Create a 100*30 image
/*$im = imagecreate(100, 100);

// White background and blue text
$bg = imagecolorallocate($im, 240,240,240);
$textcolor = imagecolorallocate($im, 64,64,64);

// Write the string at the top left
imagestring($im, 1, 30, 30, 'OD', $textcolor);

// Output the image
header('Content-type: image/png');

imagepng($im);
imagedestroy($im);*/

// Set the content-type

//phpinfo();

//echo getProjectIdFromidProjectLocal(66);
//print_r(findDiffProjects(getLastProjectLocalFromProjectId(8), 59));
//print_r(insertActionLog(66,3));
//print_r(insertViewedNotification(14));
//print_r(getArrActionsLog());
//print_r(getArrActionsLogByInterval());
//print_r(updateAssignments(5,'juuu'));
//print_r(getNextPhaseId(6,TRUE));

//$nextPhasesArr = getNextPhaseId(3, TRUE);
//$nextIdPhase =$nextPhasesArr[0]['idPhase'];
//echo $nextIdPhase;
//print_r(findCompanyByIdContact(6));

//echo createRelation(8,2,1);
//print_r(getNextPhaseId(17,FALSE));
//print_r( $_SESSION);
//$arr = ['name' => 'TEST','address'=>'adresa','ic' => '123455','dic'=>'cy123','www'=>'www'];
//echo insertCompany($arr);
//print_r(findCompanyById(18));
//print_r(editCompany(['idCompany'=>18,'name'=>'TEST','address'=>'adresa','ic'=>'123455','dic'=>'cy123','www'=>'wwww2']));
//print_r(time() - $_SESSION['aktivita']);
//changeAccessDeniedUser('dolezon3',FALSE);
//print_r(createContact("Ing. Jakub Heřman","jakub.herman@novotny.partner.cz","569874321","AF-CITYPLAN, s.r.o."));

//print_r(createContact("Ing. Jakub Heřman","jakub.herman@novotny.partner.cz","569874321","AF-CITYPLAN, s.r.o."));

//print_r(createContact("Ing. Jakub Heřman","jakub.herman@novotny.partner.cz","569874321","AF-CITYPLAN, s.r.o."));
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
    </style>
</head>
<body>

<form action="test.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="file2Upload" id="file2Upload">
    <input type="submit" value="Upload file" name="submit">
</form>



</body>
</html>