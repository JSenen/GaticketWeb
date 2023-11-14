<?php
class IncidenceHistory {

    public $idhistory;
    public $historyTip;
    public $historyTheme;
    public $historyCommit;
    public $historyDateFinish;
    public $historyAdmin;
    public $historySolution;

    //====== TODO EL HISTORIAL ===========
function getAllHistory(){

    $urlhistory = BASE_URL.'history';
    $ch = curl_init($urlhistory);
    curl_setopt($ch, CURLOPT_URL, $urlhistory);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $urlhistory = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $resultlist = json_decode($urlhistory, true);

    return $resultlist;
    
}

}


?>

