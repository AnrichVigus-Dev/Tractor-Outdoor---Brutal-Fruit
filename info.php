<?php 
//phpinfo();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
file_put_contents('usercomposits/new.txt', 'test');
file_put_contents('campaignimages/new.txt', 'test');
file_put_contents('approvedcomposits/new.txt', 'test');
file_put_contents('useruploads/new.txt', 'test');
file_put_contents('images/new.txt', 'test');


echo substr(sprintf('%o', fileperms('images')), -4);
//chmod('usercomposits', 0777);
//echo substr(sprintf('%o', fileperms('usercomposits')), -4);

/*
$directory = 'Storage Account Folders';

$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

while($it->valid()) {

    if (!$it->isDot()) {

        echo 'SubPathName: ' . $it->getSubPathName() . "<br/>";
        echo 'SubPath:     ' . $it->getSubPath() . "<br/>";
        echo 'Key:         ' . $it->key() . "<br/><br/>";
    }

    $it->next();
}
*/



function listFolderFiles($dir){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;

    echo '<ol>';
    foreach($ffs as $ff){
        echo '<li>'.$ff;
        if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
        echo '</li>';
    }
    echo '</ol>';
}

//listFolderFiles('.');
//echo "<hr/>";
//listFolderFiles('Storage Account Folders');
echo "<hr/>";
listFolderFiles('useruploads'); 
echo "<hr/>";
listFolderFiles('usercomposits'); 
echo "<hr/>";
//listFolderFiles('campaignimages'); 
echo "<hr/>";
//listFolderFiles('approvedcomposits'); 
echo "<hr/>";
//listFolderFiles('useruploads'); 
